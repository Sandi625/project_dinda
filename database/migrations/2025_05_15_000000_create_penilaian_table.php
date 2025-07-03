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
        $table->unsignedBigInteger('id_user'); // ✅ Tambahkan ini
        $table->string('periode', 20)->nullable();
        $table->date('tanggal')->nullable();
        $table->timestamps();

        $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade'); // ✅ Tambahkan ini
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
