<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\AlternativeValue;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CriteriasSeeder::class,
            AlternativesSeeder::class,
        ]);
    }
}
