
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->integer('Id_kriteria');
            $table->string('Kode_kriteria', 25)->unique();
            $table->string('Nama_Parameter', 25);
            $table->enum('Atribut', ['benefit', 'cost'])->default('benefit');
            $table->double('Bobot_ahp')->nullable();

            $table->primary('Id_kriteria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criterias');
    }
};
