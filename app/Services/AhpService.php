<?php

namespace App\Services;

/**
 * AhpService
 *
 * Menyimpan hasil perhitungan AHP (Analytic Hierarchy Process) yang telah
 * dilakukan secara manual/offline berdasarkan perbandingan berpasangan para
 * pakar gizi. Bobot vektor prioritas berikut bersifat tetap dan digunakan
 * sebagai input pembobotan pada proses TOPSIS.
 *
 * Kriteria yang digunakan (semua berjenis Benefit):
 *   C1 – Energi       : 0.2897
 *   C2 – Protein      : 0.2897
 *   C3 – Lemak        : 0.1331
 *   C4 – Karbohidrat  : 0.1924
 *   C5 – Serat        : 0.0951
 *
 * Rasio Konsistensi (CR) = 0.0247 < 0.10  → Konsisten (dapat diterima)
 */
class AhpService
{
    /**
     * Matriks Perbandingan Berpasangan (Pairwise Comparison Matrix)
     * Skala Saaty 1–9: 1=sama penting, 3=sedikit lebih, 5=lebih, 7=sangat lebih, 9=mutlak lebih
     *
     * Urutan kriteria: [C1-Energi, C2-Protein, C3-Lemak, C4-Karbohidrat, C5-Serat]
     */
    private array $pairwiseMatrix = [
        // C1     C2     C3     C4     C5
        [1,    0.333, 2,    0.5,   0.333],  // C1 – Energi
        [3,    1,     5,    1,     1      ],  // C2 – Protein
        [0.5,  0.2,   1,    0.333, 0.2   ],  // C3 – Lemak
        [2,    1,     3,    1,     0.5   ],  // C4 – Karbohidrat
        [3,    1,     5,    2,     1     ],  // C5 – Serat
    ];

    /**
     * Nilai Random Index (RI) untuk n = 1 s/d 10
     * digunakan pada penghitungan Consistency Ratio (CR)
     */
    private array $randomIndex = [0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];

    /**
     * Bobot vektor prioritas AHP yang telah dihitung (fixed weights)
     */
    private array $weights = [
        'C1' => 0.2897,
        'C2' => 0.2897,
        'C3' => 0.1331,
        'C4' => 0.1924,
        'C5' => 0.0951,
    ];

    /**
     * Mengembalikan bobot vektor prioritas AHP yang sudah dihitung.
     *
     * @return array<string, float>
     */
    public function getWeights(): array
    {
        return $this->weights;
    }

    /**
     * Menghitung ulang bobot AHP dari matriks perbandingan berpasangan.
     * Mengembalikan array lengkap termasuk bobot, lambda max, CI, dan CR.
     *
     * @return array
     */
    public function compute(): array
    {
        $n      = count($this->pairwiseMatrix);
        $matrix = $this->pairwiseMatrix;

        // 1. Hitung jumlah tiap kolom
        $colSums = array_fill(0, $n, 0.0);
        foreach ($matrix as $row) {
            foreach ($row as $j => $val) {
                $colSums[$j] += $val;
            }
        }

        // 2. Normalisasi kolom → rata-rata tiap baris = vektor prioritas (bobot)
        $normalised = [];
        $computedWeights = [];
        for ($i = 0; $i < $n; $i++) {
            $rowSum = 0.0;
            for ($j = 0; $j < $n; $j++) {
                $normalised[$i][$j] = $matrix[$i][$j] / $colSums[$j];
                $rowSum += $normalised[$i][$j];
            }
            $computedWeights[$i] = $rowSum / $n;
        }

        // 3. Hitung lambda max
        $lambdaMax = 0.0;
        for ($j = 0; $j < $n; $j++) {
            $wColProduct = 0.0;
            for ($i = 0; $i < $n; $i++) {
                $wColProduct += $matrix[$i][$j] * $computedWeights[$i];
            }
            $lambdaMax += $wColProduct / $computedWeights[$j];
        }
        $lambdaMax /= $n;

        // 4. Consistency Index (CI) dan Consistency Ratio (CR)
        $ci = ($lambdaMax - $n) / ($n - 1);
        $ri = $this->randomIndex[$n - 1] ?? 1.0;
        $cr = $ri > 0 ? $ci / $ri : 0.0;

        // 5. Mapping kode kriteria → bobot
        $criteriaCodes = ['C1', 'C2', 'C3', 'C4', 'C5'];
        $weightMap     = [];
        foreach ($criteriaCodes as $idx => $code) {
            $weightMap[$code] = round($computedWeights[$idx], 4);
        }

        return [
            'weights'         => $weightMap,
            'lambda_max'      => round($lambdaMax, 4),
            'ci'              => round($ci, 4),
            'cr'              => round($cr, 4),
            'is_consistent'   => $cr < 0.10,
            'pairwise_matrix' => $matrix,
            'col_sums'        => $colSums,
        ];
    }

    /**
     * Mengembalikan detail lengkap hasil AHP untuk ditampilkan di halaman kriteria.
     *
     * @return array
     */
    public function getDetail(): array
    {
        return $this->compute();
    }
}
