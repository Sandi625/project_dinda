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
        Schema::create('jadwal_mengajar', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel guru
            $table->unsignedBigInteger('id_guru');

                    $table->unsignedBigInteger('id_user');


            // Relasi ke tabel mapel (boleh redundant jika mau eksplisit, atau bisa ambil dari tabel guru)
            $table->unsignedBigInteger('id_mapel');

            // Relasi ke kelas
            $table->unsignedBigInteger('id_kelas');

            // Hari & jam ke
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->unsignedTinyInteger('jam_ke'); // dari 1 s.d 10

            $table->timestamps();

            // Foreign keys
                    $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

            $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_mengajar');
    }
};
