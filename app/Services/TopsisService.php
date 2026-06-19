<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\AlternativeValue;

/**
 * TopsisService
 *
 * Mengimplementasikan seluruh tahapan perhitungan TOPSIS
 * (Technique for Order of Preference by Similarity to Ideal Solution)
 * yang dipadukan dengan bobot AHP tetap.
 *
 * Langkah-langkah:
 *   1.  Baca matriks keputusan dari database
 *   2.  Normalisasi matriks (metode euclidean)
 *   3.  Pembobotan matriks ternormalisasi (bobot AHP)
 *   4.  Tentukan Solusi Ideal Positif (A+) dan Negatif (A-)
 *       berdasarkan atribut kriteria (benefit / cost)
 *   5.  Hitung jarak ke A+ (D+) dan A- (D-)
 *   6.  Hitung nilai preferensi Vi = D- / (D+ + D-)
 *   7.  Urutkan hasil dari Vi terbesar ke terkecil (Rank)
 */
class TopsisService
{
    /**
     * Bobot vektor prioritas AHP yang bersifat tetap.
     * Sumber: hasil perhitungan AHP dengan CR = 0.0247 < 0.10 (Konsisten).
     *
     * @var array<string, float>
     */
    private array $weights = [
        'C1' => 0.0953, // Energi
        'C2' => 0.3104, // Protein
        'C3' => 0.0592, // Lemak
        'C4' => 0.2389, // Karbohidrat
        'C5' => 0.2961, // Serat
    ];

    /**
     * Menjalankan seluruh tahapan perhitungan TOPSIS.
     *
     * @return array{
     *   rankingResults: array,
     *   bestMenu: array|null,
     *   steps: array
     * }
     */
    public function calculate(): array
    {
        // ─────────────────────────────────────────────────────────────────
        // LANGKAH 1 — Ambil data dari database
        // ─────────────────────────────────────────────────────────────────
        $criterias    = Criteria::all()->keyBy('code');          // Collection keyed by 'C1','C2',...
        $alternatives = Alternative::with('alternativeValues')->get();

        if ($alternatives->isEmpty() || $criterias->isEmpty()) {
            return [
                'rankingResults' => [],
                'bestMenu'       => null,
                'steps'          => [],
            ];
        }

        // ─────────────────────────────────────────────────────────────────
        // LANGKAH 2 — Susun Matriks Keputusan X [alternatif × kriteria]
        //   x_{ij} = nilai alternatif i pada kriteria j
        // ─────────────────────────────────────────────────────────────────
        $matrixX = [];
        foreach ($alternatives as $alt) {
            foreach ($criterias as $critCode => $crit) {
                $valObj = $alt->alternativeValues
                    ->where('criteria_id', $crit->id)
                    ->first();
                $matrixX[$alt->id][$critCode] = $valObj ? (float) $valObj->value : 0.0;
            }
        }

        // ─────────────────────────────────────────────────────────────────
        // LANGKAH 3 — Normalisasi Matriks (Euclidean)
        //   divider_j = sqrt( Σ x_{ij}² )
        //   r_{ij}    = x_{ij} / divider_j
        // ─────────────────────────────────────────────────────────────────
        $dividers = [];
        foreach ($criterias as $critCode => $crit) {
            $sumSq = 0.0;
            foreach ($alternatives as $alt) {
                $sumSq += ($matrixX[$alt->id][$critCode] ** 2);
            }
            $dividers[$critCode] = $sumSq > 0 ? sqrt($sumSq) : 1.0;
        }

        $matrixR = [];
        foreach ($alternatives as $alt) {
            foreach ($criterias as $critCode => $crit) {
                $matrixR[$alt->id][$critCode] =
                    $matrixX[$alt->id][$critCode] / $dividers[$critCode];
            }
        }

        // ─────────────────────────────────────────────────────────────────
        // LANGKAH 4 — Pembobotan Matriks Ternormalisasi
        //   y_{ij} = w_j × r_{ij}
        // ─────────────────────────────────────────────────────────────────
        $matrixY = [];
        foreach ($alternatives as $alt) {
            foreach ($criterias as $critCode => $crit) {
                $weight = $this->weights[$critCode] ?? 0.0;
                $matrixY[$alt->id][$critCode] =
                    $matrixR[$alt->id][$critCode] * $weight;
            }
        }

        // ─────────────────────────────────────────────────────────────────
        // LANGKAH 5 — Tentukan Solusi Ideal Positif (A+) & Negatif (A-)
        //   Untuk kriteria benefit : A+_j = max(y_{ij}), A-_j = min(y_{ij})
        //   Untuk kriteria cost    : A+_j = min(y_{ij}), A-_j = max(y_{ij})
        // ─────────────────────────────────────────────────────────────────
        $idealPos = [];
        $idealNeg = [];
        foreach ($criterias as $critCode => $crit) {
            $colValues = array_column(
                array_map(fn ($alt) => $matrixY[$alt->id], $alternatives->all()),
                $critCode
            );

            $isBenefit = ($crit->attribute !== 'cost');

            $idealPos[$critCode] = $isBenefit ? max($colValues) : min($colValues);
            $idealNeg[$critCode] = $isBenefit ? min($colValues) : max($colValues);
        }

        // ─────────────────────────────────────────────────────────────────
        // LANGKAH 6 — Hitung Jarak ke Solusi Ideal
        //   D+_i = sqrt( Σ (y_{ij} − A+_j)² )
        //   D-_i = sqrt( Σ (y_{ij} − A-_j)² )
        // ─────────────────────────────────────────────────────────────────
        $dPos       = [];
        $dNeg       = [];
        $preference = [];

        foreach ($alternatives as $alt) {
            $sumSqPos = 0.0;
            $sumSqNeg = 0.0;

            foreach ($criterias as $critCode => $crit) {
                $y         = $matrixY[$alt->id][$critCode];
                $sumSqPos += (($y - $idealPos[$critCode]) ** 2);
                $sumSqNeg += (($y - $idealNeg[$critCode]) ** 2);
            }

            $dPos[$alt->id] = sqrt($sumSqPos);
            $dNeg[$alt->id] = sqrt($sumSqNeg);

            // ─────────────────────────────────────────────────────────────
            // LANGKAH 7 — Nilai Preferensi
            //   Vi = D-_i / (D+_i + D-_i)
            // ─────────────────────────────────────────────────────────────
            $total                = $dPos[$alt->id] + $dNeg[$alt->id];
            $preference[$alt->id] = $total > 0
                ? ($dNeg[$alt->id] / $total)
                : 0.0;
        }

        // ─────────────────────────────────────────────────────────────────
        // LANGKAH 8 — Susun & Urutkan Hasil Perangkingan
        // ─────────────────────────────────────────────────────────────────
        $rankingResults = [];
        foreach ($alternatives as $alt) {
            $rankingResults[] = [
                'id'    => $alt->id,
                'code'  => $alt->code,
                'name'  => $alt->name,
                'score' => $preference[$alt->id],
                'd_pos' => $dPos[$alt->id],
                'd_neg' => $dNeg[$alt->id],
            ];
        }

        // Urutkan berdasarkan Vi terbesar ke terkecil
        usort($rankingResults, static fn ($a, $b) => $b['score'] <=> $a['score']);

        // Tambahkan atribut rank (1, 2, 3, …)
        foreach ($rankingResults as $index => &$res) {
            $res['rank'] = $index + 1;
        }
        unset($res);

        $bestMenu = !empty($rankingResults) ? $rankingResults[0] : null;

        return [
            'rankingResults' => $rankingResults,
            'bestMenu'       => $bestMenu,
            'steps'          => [
                'matrixX'  => $matrixX,
                'dividers' => $dividers,
                'matrixR'  => $matrixR,
                'matrixY'  => $matrixY,
                'idealPos' => $idealPos,
                'idealNeg' => $idealNeg,
                'dPos'     => $dPos,
                'dNeg'     => $dNeg,
            ],
        ];
    }

    /**
     * Getter bobot AHP yang digunakan.
     *
     * @return array<string, float>
     */
    public function getWeights(): array
    {
        return $this->weights;
    }
}
