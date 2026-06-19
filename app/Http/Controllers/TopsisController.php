<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopsisController extends Controller
{
    /**
     * Membuka portal utama (Landing Page) yang berisi seluruh data SPK riil bab IV
     */
    public function index()
    {
        // 1. Data daftar alternatif menu (Sesuai Tabel 4.9 Data Alternatif)[cite: 1]
        $alternatives = [
            ['code' => 'A1', 'name' => 'Nasi kuning, abon ayam, tempe orek, telur dadar suwir, anggur, timun, tomat'],
            ['code' => 'A2', 'name' => 'Nasi putih, ayam goreng lengkuas, kuah, sayur asam, semangka'],
            ['code' => 'A3', 'name' => 'Nasi putih, kuah bakso, jeruk baby, tempe goreng, tumis jagung'],
            ['code' => 'A4', 'name' => 'Nasi putih, ayam goreng, tumis tahu kubis, jeruk baby'],
            ['code' => 'A5', 'name' => 'Nasi putih, ayam katsu, vegetable curry, tahu goreng, buah naga'],
            ['code' => 'A6', 'name' => 'Nasi putih, tahu, ayam goreng, capcay, melon'],
            ['code' => 'A7', 'name' => 'Nasi bunga telang, chicken nugget, tahu goreng, tumis pelangi, semangka'],
            ['code' => 'A8', 'name' => 'Onigiri, chicken strip, salad sayur, bola-bola tahu, buah kelengkeng'],
            ['code' => 'A9', 'name' => 'Nasi putih, fuyunghai saus, tempe goreng, timun selada, melon'],
            ['code' => 'A10', 'name' => 'Nasi putih, fried chicken, tahu pong, mix vegetable, buah naga'],
            ['code' => 'A11', 'name' => 'Nasi putih, ayam katsu, tahu pong, salad sayur, jeruk baby'],
            ['code' => 'A12', 'name' => 'Nasi kuning, telur dadar suwir, abon ayam, acar timun wortel, buah apel'],
        ];

        // 2. Data preferensi akhir perangkingan TOPSIS (Sesuai Tabel 4.16 Lanjutan)[cite: 1]
        $rankingResults = [
            ['rank' => 1, 'code' => 'A10', 'name' => 'Nasi putih, fried chicken, tahu pong, mix vegetable, buah naga', 'score' => 0.7536],
            ['rank' => 2, 'code' => 'A12', 'name' => 'Nasi kuning, telur dadar suwir, abon ayam, acar timun wortel, buah apel', 'score' => 0.7270],
            ['rank' => 3, 'code' => 'A1', 'name' => 'Nasi kuning, abon ayam, tempe orek, telur dadar suwir, anggur, timun, tomat', 'score' => 0.6450],
            ['rank' => 4, 'code' => 'A8', 'name' => 'Onigiri, chicken strip, salad sayur, bola-bola tahu, buah kelengkeng', 'score' => 0.6311],
            ['rank' => 5, 'code' => 'A4', 'name' => 'Nasi putih, ayam goreng, tumis tahu kubis, jeruk baby', 'score' => 0.5964],
            ['rank' => 6, 'code' => 'A5', 'name' => 'Nasi putih, ayam katsu, vegetable curry, tahu goreng, buah naga', 'score' => 0.5465],
            ['rank' => 7, 'code' => 'A6', 'name' => 'Nasi putih, tahu, ayam goreng, capcay, melon', 'score' => 0.5076],
            ['rank' => 8, 'code' => 'A7', 'name' => 'Nasi bunga telang, chicken nugget, tahu goreng, tumis pelangi, semangka', 'score' => 0.4367],
            ['rank' => 9, 'code' => 'A11', 'name' => 'Nasi putih, ayam katsu, tahu pong, salad sayur, jeruk baby', 'score' => 0.3631],
            ['rank' => 10, 'code' => 'A3', 'name' => 'Nasi putih, kuah bakso, jeruk baby, tempe goreng, tumis jagung', 'score' => 0.1893],
            ['rank' => 11, 'code' => 'A2', 'name' => 'Nasi putih, ayam goreng lengkuas, kuah, sayur asam, semangka', 'score' => 0.1616],
            ['rank' => 12, 'code' => 'A9', 'name' => 'Nasi putih, fuyunghai saus, tempe goreng, timun selada, melon', 'score' => 0.0245],
        ];

        // Alternatif terbaik untuk dipasang di banner utama (Juara 1)[cite: 1]
        $bestMenu = $rankingResults[0];

        return view('user.dashboard', compact('alternatives', 'rankingResults', 'bestMenu'));
    }
}