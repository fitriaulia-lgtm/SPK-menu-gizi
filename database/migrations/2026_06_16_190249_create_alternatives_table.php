
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternatives', function (Blueprint $table) {
            $table->integer('Id_alternatif');
            $table->string('Kode_alternatif', 5)->unique();
            $table->text('Komposisi_menu');
            $table->double('Nilai_energi')->nullable();
            $table->double('Nilai_protein')->nullable();
            $table->double('Nilai_lemak')->nullable();
            $table->double('Nilai_karbohidrat')->nullable();
            $table->double('Nilai_serat')->nullable();
            $table->double('score')->nullable();

            $table->primary('Id_alternatif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternatives');
    }
};
