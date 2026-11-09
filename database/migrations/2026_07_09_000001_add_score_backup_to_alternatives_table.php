<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alternatives', function (Blueprint $table) {
            $table->double('score_backup')->nullable()->after('score');
        });
    }

    public function down(): void
    {
        Schema::table('alternatives', function (Blueprint $table) {
            $table->dropColumn('score_backup');
        });
    }
};
