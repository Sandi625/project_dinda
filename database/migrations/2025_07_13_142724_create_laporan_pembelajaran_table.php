<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('laporan_pembelajaran', function (Blueprint $table) {
        $table->id('id_laporan');

        $table->unsignedBigInteger('id_guru');
        $table->unsignedBigInteger('id_kelas');
        $table->unsignedBigInteger('id_mapel');

        $table->string('bulan');
        $table->text('materi');
        $table->text('metode');
        $table->integer('jumlah_pertemuan');
        $table->integer('rata_kehadiran');
        $table->text('evaluasi');
        $table->text('kendala');
        $table->text('solusi');
        $table->text('catatan')->nullable();
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
        $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
        $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('cascade');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pembelajaran');
    }
};
