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
        $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');
        $table->timestamps();

        $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
    });
}


    public function down()
    {
        Schema::dropIfExists('laporan_kinerja');
    }
}
