<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5)->unique(); // C1, C2, C3, dst.
            $table->string('name');              // Energi, Protein, Lemak, dst.
            $table->enum('attribute', ['benefit', 'cost'])->default('benefit');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criterias');
    }
};