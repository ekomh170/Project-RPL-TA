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
            $table->string('order_code', 20)->unique(); // Kode unik order: JO-YYYYMMDD-XXXX

            // Foreign keys dengan relasi yang jelas
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('provider_id')->nullable()->constrained('penyedia_jasa')->onDelete('set null');

            // Detail order
            $table->text('description')->nullable();
            $table->text('address');
            $table->string('customer_phone', 20);

            // Status dan workflow
            $table->enum('status', [
                'menunggu',     // Menunggu provider
                'diterima',     // Provider terima
                'dikerjakan',   // Sedang dikerjakan
                'selesai',      // Selesai
                'dibatalkan'    // Dibatalkan
            ])->default('menunggu');

            // Pricing
            $table->decimal('base_price', 10, 2); // Harga dari service
            $table->decimal('final_price', 10, 2); // Harga final (bisa custom dari provider)
            $table->decimal('admin_fee', 10, 2)->default(5000);

            // Scheduling
            $table->datetime('scheduled_at');
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();

            // Review dan rating
            $table->integer('rating')->nullable()->comment('1-5 stars');
            $table->text('review')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Essential indexes untuk performa
            $table->index('order_code', 'idx_job_orders_code');
            $table->index(['user_id', 'status'], 'idx_job_orders_user_status');
            $table->index(['provider_id', 'status'], 'idx_job_orders_provider_status');
            $table->index(['service_id', 'status'], 'idx_job_orders_service_status');
            $table->index('status', 'idx_job_orders_status');
            $table->index('scheduled_at', 'idx_job_orders_scheduled');
            $table->index(['status', 'scheduled_at'], 'idx_job_orders_status_scheduled');
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