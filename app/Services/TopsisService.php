<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\AlternativeValue;

class TopsisService
{
    // Bobot kriteria tetap hasil perhitungan AHP
    private $weights = [
        'C1' => 0.0953, // Energi
        'C2' => 0.3104, // Protein
        'C3' => 0.0592, // Lemak
        'C4' => 0.2389, // Karbohidrat
        'C5' => 0.2961, // Serat
    ];

    /**
     * Menjalankan seluruh tahapan perhitungan TOPSIS
     * 
     * @return array
     */
    public function calculate()
    {
        // 1. Ambil data kriteria dan alternatif dari database
        $criterias = Criteria::all()->keyBy('code');
        $alternatives = Alternative::with('alternativeValues')->get();

        if ($alternatives->isEmpty() || $criterias->isEmpty()) {
            return [
                'rankingResults' => [],
                'bestMenu' => null,
                'steps' => []
            ];
        }

        // 2. Buat matriks keputusan X
        $matrixX = [];
        foreach ($alternatives as $alt) {
            foreach ($criterias as $critCode => $crit) {
                // Cari nilai alternatif untuk kriteria ini
                $valObj = $alt->alternativeValues->where('criteria_id', $crit->id)->first();
                $matrixX[$alt->id][$critCode] = $valObj ? (double)$valObj->value : 0.0;
            }
        }

        // 3. Hitung pembagi (divider) untuk normalisasi matriks
        // divider_j = sqrt( sum_{i=1}^m x_{ij}^2 )
        $dividers = [];
        foreach ($criterias as $critCode => $crit) {
            $sumSq = 0;
            foreach ($alternatives as $alt) {
                $sumSq += pow($matrixX[$alt->id][$critCode], 2);
            }
            $dividers[$critCode] = $sumSq > 0 ? sqrt($sumSq) : 1.0;
        }

        // 4. Normalisasi matriks keputusan (R)
        // r_{ij} = x_{ij} / divider_j
        $matrixR = [];
        foreach ($alternatives as $alt) {
            foreach ($criterias as $critCode => $crit) {
                $matrixR[$alt->id][$critCode] = $matrixX[$alt->id][$critCode] / $dividers[$critCode];
            }
        }

        // 5. Pembobotan matriks ternormalisasi (Y)
        // y_{ij} = w_j * r_{ij}
        $matrixY = [];
        foreach ($alternatives as $alt) {
            foreach ($criterias as $critCode => $crit) {
                $weight = $this->weights[$critCode] ?? 0.0;
                $matrixY[$alt->id][$critCode] = $matrixR[$alt->id][$critCode] * $weight;
            }
        }

        // 6. Tentukan Solusi Ideal Positif (A+) dan Solusi Ideal Negatif (A-)
        // Karena semua 5 kriteria adalah benefit:
        // A+_j = max(y_{ij}), A-_j = min(y_{ij})
        $idealPos = [];
        $idealNeg = [];
        foreach ($criterias as $critCode => $crit) {
            $columnValues = [];
            foreach ($alternatives as $alt) {
                $columnValues[] = $matrixY[$alt->id][$critCode];
            }
            $idealPos[$critCode] = !empty($columnValues) ? max($columnValues) : 0.0;
            $idealNeg[$critCode] = !empty($columnValues) ? min($columnValues) : 0.0;
        }

        // 7. Hitung Jarak Jarak Alternatif ke Solusi Ideal Positif (D+) dan Negatif (D-)
        // D+_i = sqrt( sum_{j=1}^n (y_{ij} - A+_j)^2 )
        // D-_i = sqrt( sum_{j=1}^n (y_{ij} - A-_j)^2 )
        $dPos = [];
        $dNeg = [];
        $preference = [];

        foreach ($alternatives as $alt) {
            $sumSqPos = 0;
            $sumSqNeg = 0;
            foreach ($criterias as $critCode => $crit) {
                $yVal = $matrixY[$alt->id][$critCode];
                $sumSqPos += pow($yVal - $idealPos[$critCode], 2);
                $sumSqNeg += pow($yVal - $idealNeg[$critCode], 2);
            }
            $dPos[$alt->id] = sqrt($sumSqPos);
            $dNeg[$alt->id] = sqrt($sumSqNeg);

            // 8. Hitung Nilai Preferensi (V_i)
            // V_i = D-_i / (D+_i + D-_i)
            $totalDist = $dPos[$alt->id] + $dNeg[$alt->id];
            $preference[$alt->id] = $totalDist > 0 ? ($dNeg[$alt->id] / $totalDist) : 0.0;
        }

        // 9. Susun hasil akhir dan urutkan ranking (Rank)
        $rankingResults = [];
        foreach ($alternatives as $alt) {
            $rankingResults[] = [
                'id' => $alt->id,
                'code' => $alt->code,
                'name' => $alt->name,
                'score' => $preference[$alt->id],
                'd_pos' => $dPos[$alt->id],
                'd_neg' => $dNeg[$alt->id],
            ];
        }

        // Urutkan preferensi dari terbesar ke terkecil
        usort($rankingResults, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Tambahkan atribut rank (1, 2, 3...)
        foreach ($rankingResults as $index => &$res) {
            $res['rank'] = $index + 1;
        }

        // Ambil alternatif terbaik
        $bestMenu = !empty($rankingResults) ? $rankingResults[0] : null;

        return [
            'rankingResults' => $rankingResults,
            'bestMenu' => $bestMenu,
            'steps' => [
                'matrixX' => $matrixX,
                'dividers' => $dividers,
                'matrixR' => $matrixR,
                'matrixY' => $matrixY,
                'idealPos' => $idealPos,
                'idealNeg' => $idealNeg,
                'dPos' => $dPos,
                'dNeg' => $dNeg,
            ]
        ];
    }
}
