<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropColumn('teacher_id');
        });
    }
};
