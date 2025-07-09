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
    Schema::create('siswa', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 100);
        $table->string('nis', 30)->unique();

        $table->unsignedBigInteger('id_kelas'); // foreign key ke kelas
        $table->unsignedBigInteger('id_mapel'); // foreign key ke mapel

        $table->integer('nilai')->nullable(); // ← sekarang nilai berupa integer
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('id_kelas')->references('id')->on('mapel')->onDelete('cascade');
        $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('cascade');
    });
}




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
