<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKinerjaDetailTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_kinerja_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_kinerja_id')->constrained('laporan_kinerja')->onDelete('cascade');
            $table->enum('kategori', [
                'Perencanaan',
                'Pelaksanaan',
                'Penilaian',
                'Komunikasi',
                'Profesional'
            ]);
            $table->string('indikator');
            $table->text('keterangan')->nullable();
            $table->string('file_bukti')->nullable(); // disimpan sebagai path
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_kinerja_detail');
    }
}
