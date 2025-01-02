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
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->string('pembayaran');
            $table->string('nama_pekerja');
            $table->string('waktu_kerja');
            $table->string('nama_jasa');
            $table->decimal('harga_penawaran', 10, 2);
            $table->date('tanggal_pelaksanaan');
            $table->string('waktu');
            $table->string('gender');
            $table->text('deskripsi');
            $table->string('informasi_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};
