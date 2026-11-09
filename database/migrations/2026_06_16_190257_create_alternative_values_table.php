<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternative_values', function (Blueprint $table) {
            $table->id();
            $table->integer('alternative_id');
            $table->foreign('alternative_id')->references('Id_alternatif')->on('alternatives')->onDelete('cascade');
            $table->integer('criteria_id');
            $table->foreign('criteria_id')->references('Id_kriteria')->on('criterias')->onDelete('cascade');
            $table->double('value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternative_values');
    }
};