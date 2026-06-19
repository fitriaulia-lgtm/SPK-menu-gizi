<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Admin & Petugas)
        \App\Models\User::create([
            'name' => 'Administrator SPK',
            'email' => 'admin@nutridss.go.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Petugas Pelayanan Gizi',
            'email' => 'petugas@nutridss.go.id',
            'password' => bcrypt('password'),
            'role' => 'petugas',
        ]);

        // 2. Seed Criterias (Energi, Protein, Lemak, Karbohidrat, Serat)
        $criterias = [
            ['code' => 'C1', 'name' => 'Energi', 'attribute' => 'benefit'],
            ['code' => 'C2', 'name' => 'Protein', 'attribute' => 'benefit'],
            ['code' => 'C3', 'name' => 'Lemak', 'attribute' => 'benefit'],
            ['code' => 'C4', 'name' => 'Karbohidrat', 'attribute' => 'benefit'],
            ['code' => 'C5', 'name' => 'Serat', 'attribute' => 'benefit'],
        ];

        $criteriaIds = [];
        foreach ($criterias as $c) {
            $created = \App\Models\Criteria::create($c);
            $criteriaIds[$c['code']] = $created->id;
        }

        // 3. Seed Alternatives
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

        // Nilai gizi alternatif C1 - C5
        $values = [
            'A1'  => ['C1' => 512, 'C2' => 18.5, 'C3' => 14.8, 'C4' => 74.2, 'C5' => 3.2],
            'A2'  => ['C1' => 430, 'C2' => 13.8, 'C3' => 11.2, 'C4' => 66.5, 'C5' => 1.8],
            'A3'  => ['C1' => 445, 'C2' => 14.2, 'C3' => 10.5, 'C4' => 68.0, 'C5' => 1.9],
            'A4'  => ['C1' => 490, 'C2' => 17.6, 'C3' => 13.5, 'C4' => 71.0, 'C5' => 2.9],
            'A5'  => ['C1' => 480, 'C2' => 16.8, 'C3' => 12.8, 'C4' => 70.2, 'C5' => 2.6],
            'A6'  => ['C1' => 470, 'C2' => 16.2, 'C3' => 12.0, 'C4' => 69.5, 'C5' => 2.4],
            'A7'  => ['C1' => 460, 'C2' => 15.5, 'C3' => 11.0, 'C4' => 68.4, 'C5' => 2.2],
            'A8'  => ['C1' => 505, 'C2' => 18.2, 'C3' => 14.0, 'C4' => 73.8, 'C5' => 3.1],
            'A9'  => ['C1' => 410, 'C2' => 12.0, 'C3' => 9.8,  'C4' => 63.2, 'C5' => 1.5],
            'A10' => ['C1' => 550, 'C2' => 21.5, 'C3' => 16.5, 'C4' => 78.4, 'C5' => 4.2],
            'A11' => ['C1' => 450, 'C2' => 14.8, 'C3' => 11.5, 'C4' => 67.2, 'C5' => 2.2],
            'A12' => ['C1' => 530, 'C2' => 19.8, 'C3' => 15.2, 'C4' => 76.5, 'C5' => 3.8],
        ];

        foreach ($alternatives as $alt) {
            $createdAlt = \App\Models\Alternative::create($alt);
            foreach ($values[$alt['code']] as $cCode => $val) {
                \App\Models\AlternativeValue::create([
                    'alternative_id' => $createdAlt->id,
                    'criteria_id' => $criteriaIds[$cCode],
                    'value' => $val,
                ]);
            }
        }
    }
}
