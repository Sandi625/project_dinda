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
    Schema::create('penilaiansiswa', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('siswa_id');     // FK ke siswa
        $table->unsignedBigInteger('mapel_id');     // FK ke mapel
        $table->integer('nilai');                   // Nilai siswa dalam bentuk integer
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
        $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaiansiswa');
    }
};
