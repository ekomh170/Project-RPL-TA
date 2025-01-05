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
        $table->string('nomor_telepon')->nullable()->after('informasi_pembayaran');
        $table->string('bukti')->nullable()->after('nomor_telepon');
    });
}

public function down(): void
{
    Schema::table('job_orders', function (Blueprint $table) {
        $table->dropColumn(['nomor_telepon', 'bukti']);
    });
}
};
