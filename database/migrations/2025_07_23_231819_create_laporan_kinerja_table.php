<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKinerjaTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_kinerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_semester'); // foreign key
            $table->timestamps();

            $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
            $table->foreign('id_semester')->references('id')->on('semester')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('laporan_kinerja');
    }
}
