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
    Schema::create('guru', function (Blueprint $table) {
        $table->id('id_guru');
        $table->unsignedBigInteger('id_user');
        $table->string('nip', 20)->nullable();
        $table->string('nama', 100);
        $table->text('alamat')->nullable();

        // Foreign key ke tabel mapel
        // $table->unsignedBigInteger('id_mapel')->nullable();

        // Foreign key ke tabel kelas
        // $table->unsignedBigInteger('id_kelas')->nullable();

        // ✅ Foreign key ke tabel prodi
        // $table->unsignedBigInteger('id_prodi')->nullable();

        // $table->unsignedBigInteger('id_semester');           // ✅ Foreign key ke tabel semester

        $table->timestamps();

        // Foreign key ke tabel users
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

        // Foreign key ke tabel mapel
        // $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('set null');

        // Foreign key ke tabel kelas
        // $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('set null');

        // ✅ Foreign key ke tabel prodi
        // $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('set null');
        // $table->foreign('id_semester')->references('id')->on('semester')->onDelete('cascade');

    });
}




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
