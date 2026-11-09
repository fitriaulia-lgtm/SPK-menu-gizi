<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\AlternativeValue;

class CriteriasSeeder extends Seeder
{
    public function run(): void
    {
        $criterias = [
            ['code' => 'C1', 'name' => 'Energi', 'attribute' => 'benefit', 'weight' => 0.2897],
            ['code' => 'C2', 'name' => 'Protein', 'attribute' => 'benefit', 'weight' => 0.2897],
            ['code' => 'C3', 'name' => 'Lemak', 'attribute' => 'benefit', 'weight' => 0.1331],
            ['code' => 'C4', 'name' => 'Karbohidrat', 'attribute' => 'benefit', 'weight' => 0.1924],
            ['code' => 'C5', 'name' => 'Serat', 'attribute' => 'benefit', 'weight' => 0.0951],
        ];

        foreach ($criterias as $crit) {
            Criteria::create($crit);
        }
    }
}
