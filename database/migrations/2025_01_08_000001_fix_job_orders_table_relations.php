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
        Schema::table('job_orders', function (Blueprint $table) {
            // Ubah nama field nama_pekerja menjadi penyedia_jasa_id untuk konsistensi
            $table->renameColumn('nama_pekerja', 'penyedia_jasa_id');

            // Tambah foreign key service_id
            $table->unsignedBigInteger('service_id')->nullable()->after('nama_jasa');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');

            // Tambah foreign key constraint yang benar untuk penyedia_jasa_id
            $table->foreign('penyedia_jasa_id')->references('id')->on('penyedia_jasa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_orders', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['service_id']);
            $table->dropForeign(['penyedia_jasa_id']);

            // Hapus kolom service_id
            $table->dropColumn('service_id');

            // Kembalikan nama field ke asli
            $table->renameColumn('penyedia_jasa_id', 'nama_pekerja');
        });
    }
};
