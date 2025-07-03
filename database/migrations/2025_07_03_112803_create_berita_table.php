<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->string('gambar')->nullable(); // path gambar
            $table->text('ringkasan'); // ringkasan atau kutipan berita
            $table->longText('isi_berita'); // isi lengkap
            $table->boolean('status')->default(true); // true = tampil
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Optional foreign key ke tabel users (kalau user login)
            $table->foreign('created_by')->references('id_user')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id_user')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
}
