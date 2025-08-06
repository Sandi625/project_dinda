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
        Schema::create('semester', function (Blueprint $table) {
            $table->id();

            // ENUM untuk semester: ganjil atau genap
            $table->enum('semester', ['ganjil', 'genap']);

            // ENUM untuk tahun ajaran: 2023 sampai 2027
            $table->enum('tahun', ['2023', '2024', '2025', '2026', '2027']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester');
    }
};
