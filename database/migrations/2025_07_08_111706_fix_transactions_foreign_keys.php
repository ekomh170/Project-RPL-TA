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
        Schema::table('transactions', function (Blueprint $table) {
            // Hapus foreign key yang salah yang menunjuk ke tabel users
            $table->dropForeign(['penyedia_jasa_id']);

            // Tambah foreign key yang benar yang menunjuk ke tabel penyedia_jasa
            $table->foreign('penyedia_jasa_id')->references('id')->on('penyedia_jasa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Hapus foreign key yang benar
            $table->dropForeign(['penyedia_jasa_id']);

            // Kembalikan foreign key asli (yang salah)
            $table->foreign('penyedia_jasa_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
