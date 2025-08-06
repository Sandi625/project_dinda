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
    Schema::create('penilaian', function (Blueprint $table) {
        $table->id('id_penilaian');
        $table->unsignedBigInteger('id_guru');
        $table->unsignedBigInteger('id_user');
        $table->unsignedBigInteger('id_kelas');
        $table->unsignedBigInteger('id_mapel');
        $table->unsignedBigInteger('id_semester'); // FK semester
        $table->date('tanggal')->nullable();
        $table->timestamps();

        // Foreign keys
        $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
        $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('cascade');
        $table->foreign('id_semester')->references('id')->on('semester')->onDelete('cascade');
    });
}






    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
