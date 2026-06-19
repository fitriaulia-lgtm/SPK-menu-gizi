<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TopsisService;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\AlternativeValue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopsisTest extends TestCase
{
    /**
     * Uji apakah TopsisService menghasilkan perhitungan dan urutan peringkat yang akurat.
     */
    public function test_topsis_calculation_accuracy_and_ranking(): void
    {
        $service = new TopsisService();
        $results = $service->calculate();

        // 1. Pastikan data tidak kosong
        $this->assertNotEmpty($results['rankingResults'], 'Hasil ranking TOPSIS tidak boleh kosong.');
        $this->assertNotNull($results['bestMenu'], 'Alternatif terbaik tidak boleh null.');

        $ranking = $results['rankingResults'];

        // 2. Verifikasi ranking pertama adalah A10 (sesuai spesifikasi)
        $this->assertEquals('A10', $ranking[0]['code'], 'Peringkat 1 harus A10.');
        
        // 3. Verifikasi ranking kedua adalah A12
        $this->assertEquals('A12', $ranking[1]['code'], 'Peringkat 2 harus A12.');

        // 4. Verifikasi ranking terakhir adalah A9
        $lastIndex = count($ranking) - 1;
        $this->assertEquals('A9', $ranking[$lastIndex]['code'], 'Peringkat terakhir harus A9.');

        // 5. Verifikasi nilai preferensi (V_i) berada di antara 0 dan 1
        foreach ($ranking as $res) {
            $this->assertGreaterThanOrEqual(0, $res['score'], 'Nilai preferensi tidak boleh negatif.');
            $this->assertLessThanOrEqual(1, $res['score'], 'Nilai preferensi tidak boleh lebih besar dari 1.');
        }
    }
}
