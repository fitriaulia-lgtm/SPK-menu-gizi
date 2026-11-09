<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $scores = [
            'A8'  => 0.7951,
            'A6'  => 0.7318,
            'A1'  => 0.6878,
            'A10' => 0.6089,
            'A12' => 0.6008,
            'A4'  => 0.5517,
            'A5'  => 0.5178,
            'A7'  => 0.4401,
            'A2'  => 0.3445,
            'A11' => 0.3133,
            'A3'  => 0.2842,
            'A9'  => 0.0279,
        ];

        foreach ($scores as $code => $score) {
            DB::table('alternatives')->where('code', $code)->update(['score' => $score]);
        }
    }

    public function down(): void
    {
        //
    }
};
