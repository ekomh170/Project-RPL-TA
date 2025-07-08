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
        Schema::table('notifications', function (Blueprint $table) {
            // Tambah tipe notifikasi untuk kategorisasi yang lebih baik
            $table->enum('notification_type', [
                'job_order',
                'payment',
                'status_update',
                'system',
                'reminder'
            ])->default('system')->after('pesan');

            // Tambah status is_read
            $table->boolean('is_read')->default(false)->after('notification_type');

            // Tambah foreign key constraint yang benar untuk penyedia_jasa_id
            $table->foreign('penyedia_jasa_id')->references('id')->on('penyedia_jasa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['penyedia_jasa_id']);

            // Hapus kolom yang ditambahkan
            $table->dropColumn(['notification_type', 'is_read']);
        });
    }
};
