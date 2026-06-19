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
            // Foreign Key ke tabel alternatives dan criterias
            $table->foreignId('alternative_id')->constrained('alternatives')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criterias')->onDelete('cascade');
            // Menggunakan double karena data gizi makro memiliki pecahan desimal
            $table->double('value'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternative_values');
    }
};