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
            $table->unsignedBigInteger('nama_pekerja');
            $table->foreign('nama_pekerja')->references('id')->on('penyedia_jasa')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('waktu_kerja');
            $table->string('nama_jasa');
            $table->decimal('harga_penawaran', 10, 2);
            $table->date('tanggal_pelaksanaan');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('deskripsi');
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
