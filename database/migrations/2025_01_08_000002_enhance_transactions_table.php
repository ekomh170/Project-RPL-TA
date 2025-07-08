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
            // Tambah job_order_id untuk tracking transaksi per pesanan
            $table->unsignedBigInteger('job_order_id')->nullable()->after('penyedia_jasa_id');
            $table->foreign('job_order_id')->references('id')->on('job_orders')->onDelete('cascade');

            // Tambah field total_amount
            $table->decimal('total_amount', 10, 2)->nullable()->after('bukti');

            // Tambah foreign key constraint yang benar untuk penyedia_jasa_id
            $table->foreign('penyedia_jasa_id')->references('id')->on('penyedia_jasa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['job_order_id']);
            $table->dropForeign(['penyedia_jasa_id']);

            // Hapus kolom yang ditambahkan
            $table->dropColumn(['job_order_id', 'total_amount']);
        });
    }
};
