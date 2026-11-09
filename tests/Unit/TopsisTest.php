<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * TopsisTest — Unit test validasi akurasi matematis TOPSIS
 *
 * Test ini berjalan sepenuhnya dalam memori (tanpa database / framework)
 * untuk memverifikasi kebenaran tiap langkah perhitungan TOPSIS secara isolasi.
 *
 * Data yang digunakan adalah subset 4 alternatif menu MBG dengan
 * nilai gizi yang telah diketahui hasil akhirnya secara manual.
 */
class TopsisTest extends TestCase
{
    // ─────────────────────────────────────────────────────────────────
    //  Bobot AHP tetap (sama persis dengan TopsisService)
    // ─────────────────────────────────────────────────────────────────
    private array $weights = [
        'C1' => 0.2897,
        'C2' => 0.2897,
        'C3' => 0.1331,
        'C4' => 0.1924,
        'C5' => 0.0951,
    ];

    /**
     * Dataset kecil 4 alternatif untuk verifikasi manual.
     * Dipilih A9 (terendah), A10 (tertinggi), A1, A2 sebagai sampel.
     *
     * @return array  matriks keputusan [altCode => [C1..C5 => value]]
     */
    private function sampleMatrix(): array
    {
        return [
            'A9'  => ['C1' => 410,  'C2' => 12.0, 'C3' => 9.8,  'C4' => 63.2, 'C5' => 1.5],
            'A10' => ['C1' => 550,  'C2' => 21.5, 'C3' => 16.5, 'C4' => 78.4, 'C5' => 4.2],
            'A1'  => ['C1' => 512,  'C2' => 18.5, 'C3' => 14.8, 'C4' => 74.2, 'C5' => 3.2],
            'A2'  => ['C1' => 430,  'C2' => 13.8, 'C3' => 11.2, 'C4' => 66.5, 'C5' => 1.8],
        ];
    }

    /**
     * Menjalankan kalkulasi TOPSIS pada dataset sampel.
     * Mengembalikan rankingResults yang sudah diurutkan.
     */
    private function runTopsis(array $matrix): array
    {
        $critCodes  = ['C1', 'C2', 'C3', 'C4', 'C5'];
        $attributes = array_fill_keys($critCodes, 'benefit'); // semua benefit

        // 1. Normalisasi — euclidean divider per kolom
        $dividers = [];
        foreach ($critCodes as $c) {
            $sumSq = 0.0;
            foreach ($matrix as $values) {
                $sumSq += ($values[$c] ** 2);
            }
            $dividers[$c] = $sumSq > 0 ? sqrt($sumSq) : 1.0;
        }

        // 2. Matriks Ternormalisasi R
        $matrixR = [];
        foreach ($matrix as $altCode => $values) {
            foreach ($critCodes as $c) {
                $matrixR[$altCode][$c] = $values[$c] / $dividers[$c];
            }
        }

        // 3. Matriks Berbobot Y
        $matrixY = [];
        foreach ($matrix as $altCode => $values) {
            foreach ($critCodes as $c) {
                $matrixY[$altCode][$c] = $matrixR[$altCode][$c] * $this->weights[$c];
            }
        }

        // 4. Solusi Ideal Positif (A+) dan Negatif (A-)
        $idealPos = [];
        $idealNeg = [];
        foreach ($critCodes as $c) {
            $col = array_column(
                array_map(fn ($v) => [$c => $v[$c]], $matrixY),
                $c
            );
            $idealPos[$c] = ($attributes[$c] === 'benefit') ? max($col) : min($col);
            $idealNeg[$c] = ($attributes[$c] === 'benefit') ? min($col) : max($col);
        }

        // 5. Jarak D+, D- dan Nilai Preferensi Vi
        $results = [];
        foreach ($matrix as $altCode => $values) {
            $sumSqPos = 0.0;
            $sumSqNeg = 0.0;
            foreach ($critCodes as $c) {
                $y         = $matrixY[$altCode][$c];
                $sumSqPos += (($y - $idealPos[$c]) ** 2);
                $sumSqNeg += (($y - $idealNeg[$c]) ** 2);
            }
            $dPos  = sqrt($sumSqPos);
            $dNeg  = sqrt($sumSqNeg);
            $total = $dPos + $dNeg;
            $vi    = $total > 0 ? ($dNeg / $total) : 0.0;

            $results[] = [
                'code'  => $altCode,
                'd_pos' => $dPos,
                'd_neg' => $dNeg,
                'score' => $vi,
            ];
        }

        // 6. Urutkan Vi terbesar ke terkecil
        usort($results, static fn ($a, $b) => $b['score'] <=> $a['score']);

        foreach ($results as $i => &$r) {
            $r['rank'] = $i + 1;
        }
        unset($r);

        return $results;
    }

    // ═════════════════════════════════════════════════════════════════
    //  T E S T   C A S E S
    // ═════════════════════════════════════════════════════════════════

    /**
     * TC-01: A10 harus menempati peringkat 1 pada dataset sampel
     * karena memiliki nilai gizi tertinggi di seluruh kriteria benefit.
     */
    public function test_A10_ranks_first(): void
    {
        $results = $this->runTopsis($this->sampleMatrix());
        $this->assertEquals('A10', $results[0]['code'],
            'A10 harus menempati peringkat 1 karena nilai gizi tertinggi.');
    }

    /**
     * TC-02: A9 harus menempati peringkat terakhir karena memiliki
     * nilai gizi terendah di semua kriteria.
     */
    public function test_A9_ranks_last(): void
    {
        $results  = $this->runTopsis($this->sampleMatrix());
        $lastCode = end($results)['code'];
        $this->assertEquals('A9', $lastCode,
            'A9 harus di peringkat terakhir karena nilai gizi terendah.');
    }

    /**
     * TC-03: Semua nilai preferensi Vi harus berada di rentang [0, 1].
     */
    public function test_preference_values_in_range_0_to_1(): void
    {
        $results = $this->runTopsis($this->sampleMatrix());
        foreach ($results as $res) {
            $this->assertGreaterThanOrEqual(0.0, $res['score'],
                "{$res['code']}: Vi tidak boleh negatif.");
            $this->assertLessThanOrEqual(1.0, $res['score'],
                "{$res['code']}: Vi tidak boleh lebih dari 1.");
        }
    }

    /**
     * TC-04: Verifikasi akurasi normalisasi euclidean — jumlah kuadrat
     * nilai ternormalisasi per kolom harus ≈ 1.0.
     */
    public function test_euclidean_normalization_column_norm_equals_one(): void
    {
        $matrix    = $this->sampleMatrix();
        $critCodes = ['C1', 'C2', 'C3', 'C4', 'C5'];

        // Hitung dividers
        $dividers = [];
        foreach ($critCodes as $c) {
            $sumSq = 0.0;
            foreach ($matrix as $values) {
                $sumSq += ($values[$c] ** 2);
            }
            $dividers[$c] = sqrt($sumSq);
        }

        // Normalisasi
        $matrixR = [];
        foreach ($matrix as $altCode => $values) {
            foreach ($critCodes as $c) {
                $matrixR[$altCode][$c] = $values[$c] / $dividers[$c];
            }
        }

        // Σ r_{ij}² per kolom harus = 1.0
        foreach ($critCodes as $c) {
            $sumSq = 0.0;
            foreach ($matrixR as $r) {
                $sumSq += ($r[$c] ** 2);
            }
            $this->assertEqualsWithDelta(1.0, $sumSq, 0.0001,
                "Jumlah kuadrat kolom {$c} setelah normalisasi harus ≈ 1.0.");
        }
    }

    /**
     * TC-05: Verifikasi bobot AHP — total semua bobot harus ≈ 1.0.
     */
    public function test_ahp_weights_sum_to_one(): void
    {
        $sum = array_sum($this->weights);
        $this->assertEqualsWithDelta(1.0, $sum, 0.001,
            'Total bobot AHP (C1–C5) harus berjumlah 1.0 (100%).');
    }

    /**
     * TC-06: Solusi ideal positif A+ harus ≥ semua nilai kolom pada
     * matriks berbobot, dan A- harus ≤ semua nilai kolom.
     */
    public function test_ideal_solutions_are_correct_bounds(): void
    {
        $matrix    = $this->sampleMatrix();
        $critCodes = ['C1', 'C2', 'C3', 'C4', 'C5'];

        // Hitung dividers dan Y
        $dividers = [];
        foreach ($critCodes as $c) {
            $sumSq = 0.0;
            foreach ($matrix as $values) {
                $sumSq += ($values[$c] ** 2);
            }
            $dividers[$c] = sqrt($sumSq);
        }

        $matrixY = [];
        foreach ($matrix as $altCode => $values) {
            foreach ($critCodes as $c) {
                $matrixY[$altCode][$c] =
                    ($values[$c] / $dividers[$c]) * $this->weights[$c];
            }
        }

        foreach ($critCodes as $c) {
            $col = array_column(
                array_map(fn ($v) => [$c => $v[$c]], $matrixY),
                $c
            );
            $idealPos = max($col);
            $idealNeg = min($col);

            foreach ($col as $val) {
                $this->assertGreaterThanOrEqual($val, $idealPos + 1e-9,
                    "A+[{$c}] harus ≥ semua nilai kolom.");
                $this->assertLessThanOrEqual($val + 1e-9, $idealNeg,
                    "A-[{$c}] harus ≤ semua nilai kolom.");
            }
        }
    }

    /**
     * TC-07: Alternatif identik dengan nilai ideal harus memiliki Vi = 1.0
     * (jarak ke ideal negatif = total jarak, jarak ke ideal positif = 0).
     */
    public function test_ideal_alternative_has_vi_equal_to_one(): void
    {
        // Kita buat dataset di mana A_BEST mendominasi semua kriteria
        $matrix = [
            'A_BEST' => ['C1' => 1000, 'C2' => 100, 'C3' => 50, 'C4' => 200, 'C5' => 30],
            'A_WORST'=> ['C1' => 1,    'C2' => 1,   'C3' => 1,  'C4' => 1,   'C5' => 1 ],
        ];

        $results = $this->runTopsis($matrix);

        $bestResult = collect($results)->firstWhere('code', 'A_BEST');
        $this->assertNotNull($bestResult);
        $this->assertEqualsWithDelta(1.0, $bestResult['score'], 0.0001,
            'Alternatif terbaik yang mendominasi semua kriteria harus memiliki Vi = 1.0.');
    }

    /**
     * TC-08: Alternatif terburuk harus memiliki Vi = 0.0
     */
    public function test_worst_alternative_has_vi_equal_to_zero(): void
    {
        $matrix = [
            'A_BEST' => ['C1' => 1000, 'C2' => 100, 'C3' => 50, 'C4' => 200, 'C5' => 30],
            'A_WORST'=> ['C1' => 1,    'C2' => 1,   'C3' => 1,  'C4' => 1,   'C5' => 1 ],
        ];

        $results = $this->runTopsis($matrix);

        $worstResult = collect($results)->firstWhere('code', 'A_WORST');
        $this->assertNotNull($worstResult);
        $this->assertEqualsWithDelta(0.0, $worstResult['score'], 0.0001,
            'Alternatif terburuk yang mendominasi semua kriteria harus memiliki Vi = 0.0.');
    }

    /**
     * TC-09: Verifikasi output memiliki field yang diperlukan.
     */
    public function test_ranking_results_have_required_fields(): void
    {
        $results        = $this->runTopsis($this->sampleMatrix());
        $requiredFields = ['code', 'd_pos', 'd_neg', 'score', 'rank'];

        foreach ($results as $res) {
            foreach ($requiredFields as $field) {
                $this->assertArrayHasKey($field, $res,
                    "Field '{$field}' harus ada di setiap hasil ranking.");
            }
        }
    }

    /**
     * TC-10: Rank harus berurutan dari 1 tanpa lompatan.
     */
    public function test_ranks_are_sequential(): void
    {
        $results = $this->runTopsis($this->sampleMatrix());

        foreach ($results as $i => $res) {
            $this->assertEquals($i + 1, $res['rank'],
                "Rank harus berurutan: posisi {$i} harus memiliki rank " . ($i + 1) . '.');
        }
    }
}
