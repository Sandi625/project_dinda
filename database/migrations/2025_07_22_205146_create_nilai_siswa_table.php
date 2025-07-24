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
    Schema::create('nilai_siswa', function (Blueprint $table) {
    $table->id();
    $table->string('nama_siswa', 100);
    $table->string('nisn', 20)->nullable(); // atau nis
    $table->string('kelas', 20)->nullable();
    $table->string('mapel', 100);
    $table->string('kriteria', 100); // Tugas, UTS, UAS, dll
    $table->enum('semester', ['ganjil', 'genap']);
    $table->integer('nilai');
    $table->date('tanggal')->nullable();
    $table->string('nama_guru', 100); // Tugas, UTS, UAS, dll

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_siswa');
    }
};
