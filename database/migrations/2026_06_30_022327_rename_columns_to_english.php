<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alternative_values', function (Blueprint $table) {
            $table->dropForeign(['criteria_id']);
            $table->dropForeign(['alternative_id']);
        });

        DB::statement("ALTER TABLE criterias CHANGE Id_kriteria id INT(11) NOT NULL AUTO_INCREMENT, CHANGE Kode_kriteria code VARCHAR(25) NOT NULL, CHANGE Nama_Parameter name VARCHAR(25) NOT NULL, CHANGE Atribut attribute ENUM('benefit', 'cost') NOT NULL DEFAULT 'benefit'");

        DB::statement("ALTER TABLE alternatives CHANGE Id_alternatif id INT(11) NOT NULL AUTO_INCREMENT, CHANGE Kode_alternatif code VARCHAR(5) NOT NULL, CHANGE Komposisi_menu name TEXT NOT NULL");

        Schema::table('alternative_values', function (Blueprint $table) {
            $table->foreign('criteria_id')->references('id')->on('criterias')->onDelete('cascade');
            $table->foreign('alternative_id')->references('id')->on('alternatives')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('alternative_values', function (Blueprint $table) {
            $table->dropForeign(['criteria_id']);
            $table->dropForeign(['alternative_id']);
        });

        DB::statement("ALTER TABLE criterias CHANGE id Id_kriteria INT(11) NOT NULL AUTO_INCREMENT, CHANGE code Kode_kriteria VARCHAR(25) NOT NULL, CHANGE name Nama_Parameter VARCHAR(25) NOT NULL, CHANGE attribute Atribut ENUM('benefit', 'cost') NOT NULL DEFAULT 'benefit'");

        DB::statement("ALTER TABLE alternatives CHANGE id Id_alternatif INT(11) NOT NULL AUTO_INCREMENT, CHANGE code Kode_alternatif VARCHAR(5) NOT NULL, CHANGE name Komposisi_menu TEXT NOT NULL");

        Schema::table('alternative_values', function (Blueprint $table) {
            $table->foreign('criteria_id')->references('Id_kriteria')->on('criterias')->onDelete('cascade');
            $table->foreign('alternative_id')->references('Id_alternatif')->on('alternatives')->onDelete('cascade');
        });
    }
};
