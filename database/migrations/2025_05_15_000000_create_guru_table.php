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
    $table->timestamps();

    $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
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
