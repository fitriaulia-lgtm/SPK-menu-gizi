<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternatives', function (Blueprint $table) {
            $table->integer('Id_alternatif', 4);
            $table->string('Kode_alternatif', 5)->unique(); // A1, A2, A3, dst.
            $table->text('Komposisi_menu');                 // Detail menu makanan
            $table->double('Nilai_energi')->nullable();     // Energi (kkal)
            $table->double('Nilai_protein')->nullable();    // Protein (gram)
            $table->double('Nilai_lemak')->nullable();      // Lemak (gram)
            $table->double('Nilai_karbohidrat')->nullable(); // Karbohidrat (gram)
            $table->double('Nilai_serat')->nullable();      // Serat (gram)
            $table->double('score')->nullable();            // Nilai preferensi V_i (TOPSIS)
            $table->primary('Id_alternatif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternatives');
    }
};