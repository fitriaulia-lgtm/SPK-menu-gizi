<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\AlternativeValue;

class AlternativesSeeder extends Seeder
{
    public function run(): void
    {
        $criterias = Criteria::orderBy('id')->get()->keyBy('code');
        $fieldMap = [
            'C1' => 'energi',
            'C2' => 'protein',
            'C3' => 'lemak',
            'C4' => 'karbohidrat',
            'C5' => 'serat',
        ];

        $alternatives = [
            ['code' => 'A1', 'name' => 'Nasi kuning, abon ayam, tempe orek telur dadar suwir, anggur, timun tomat', 'score' => 0.6878, 'energi' => 468.00, 'protein' => 27.86, 'lemak' => 15.96, 'karbohidrat' => 56.30, 'serat' => 3.80],
            ['code' => 'A2', 'name' => 'Nasi putih, ayam goreng lengkuas, kuah, sayur asam, semangka', 'score' => 0.3445, 'energi' => 441.00, 'protein' => 13.32, 'lemak' => 22.51, 'karbohidrat' => 58.07, 'serat' => 2.20],
            ['code' => 'A3', 'name' => 'Nasi putih, kuah bakso, jeruk baby, tempe goreng, tumis jagung', 'score' => 0.2842, 'energi' => 429.00, 'protein' => 14.22, 'lemak' => 16.88, 'karbohidrat' => 57.23, 'serat' => 2.60],
            ['code' => 'A4', 'name' => 'Nasi putih, ayam goreng, tumis tahu kubis, jeruk baby', 'score' => 0.5517, 'energi' => 512.00, 'protein' => 19.25, 'lemak' => 22.16, 'karbohidrat' => 64.10, 'serat' => 4.80],
            ['code' => 'A5', 'name' => 'Nasi putih, ayam katsu, vegetable curry, tahu goreng, buah naga', 'score' => 0.5178, 'energi' => 523.00, 'protein' => 18.51, 'lemak' => 18.13, 'karbohidrat' => 71.95, 'serat' => 4.40],
            ['code' => 'A6', 'name' => 'Nasi putih, tahu, ayam goreng, capcay, melon', 'score' => 0.7318, 'energi' => 561.00, 'protein' => 26.20, 'lemak' => 20.56, 'karbohidrat' => 65.25, 'serat' => 2.80],
            ['code' => 'A7', 'name' => 'Nasi bunga telang, chicken nugget, tahu goreng, tumis pelangi, semangka', 'score' => 0.4401, 'energi' => 488.00, 'protein' => 17.20, 'lemak' => 19.20, 'karbohidrat' => 59.06, 'serat' => 3.90],
            ['code' => 'A8', 'name' => 'Onigiri, chicken strip, salad sayur, bola-bola tahu, buah kelengkeng', 'score' => 0.7951, 'energi' => 506.00, 'protein' => 30.67, 'lemak' => 19.76, 'karbohidrat' => 61.76, 'serat' => 3.30],
            ['code' => 'A9', 'name' => 'Nasi putih, fuyunghai saus, tempe goreng, timun selada, melon', 'score' => 0.0279, 'energi' => 329.00, 'protein' => 13.98, 'lemak' => 6.77, 'karbohidrat' => 52.16, 'serat' => 1.80],
            ['code' => 'A10', 'name' => 'Nasi putih, fried chicken, tahu pong, mix vegetable, buah naga', 'score' => 0.6089, 'energi' => 478.00, 'protein' => 23.92, 'lemak' => 12.40, 'karbohidrat' => 67.66, 'serat' => 5.40],
            ['code' => 'A11', 'name' => 'Nasi putih, ayam katsu, tahu pong, salad sayur, jeruk baby', 'score' => 0.3133, 'energi' => 443.00, 'protein' => 14.50, 'lemak' => 15.39, 'karbohidrat' => 61.57, 'serat' => 3.70],
            ['code' => 'A12', 'name' => 'Nasi kuning, telur dadar suwir, abon ayam, acar timun wortel, buah apel', 'score' => 0.6008, 'energi' => 459.00, 'protein' => 24.19, 'lemak' => 13.81, 'karbohidrat' => 62.32, 'serat' => 5.00],
        ];

        foreach ($alternatives as $altData) {
            $score = $altData['score'];
            $values = [];
            foreach ($fieldMap as $code => $field) {
                $values[$code] = $altData[$field] ?? 0;
            }

            $alternative = Alternative::updateOrCreate(
                ['code' => $altData['code']],
                ['name' => $altData['name'], 'score' => $score]
            );

            foreach ($criterias as $code => $crit) {
                AlternativeValue::updateOrCreate(
                    ['alternative_id' => $alternative->id, 'criteria_id' => $crit->id],
                    ['value' => $values[$code] ?? 0]
                );
            }
        }
    }
}
