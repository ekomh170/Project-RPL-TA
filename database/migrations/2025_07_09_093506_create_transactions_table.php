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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code', 30)->unique(); // TRX-YYYYMMDD-XXXX

            // Foreign keys
            $table->foreignId('job_order_id')->constrained('job_orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Payment details
            $table->decimal('amount', 10, 2);
            $table->decimal('admin_fee', 10, 2)->default(5000);
            $table->decimal('total_amount', 10, 2); // amount + admin_fee

            $table->enum('payment_method', [
                'tunai',
                'transfer_bank',
                'dompet_digital',
                'qris'
            ]);

            $table->enum('status', [
                'menunggu',
                'lunas',
                'gagal',
                'dikembalikan',
                'kadaluarsa'
            ])->default('menunggu');

            // Payment tracking
            $table->datetime('paid_at')->nullable();
            $table->datetime('expired_at')->nullable();
            $table->text('payment_details')->nullable(); // JSON untuk detail gateway
            $table->string('payment_reference')->nullable(); // Ref dari payment gateway

            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk payment tracking
            $table->index('transaction_code', 'idx_transactions_code');
            $table->index(['user_id', 'status'], 'idx_transactions_user_status');
            $table->index(['job_order_id', 'status'], 'idx_transactions_order_status');
            $table->index('status', 'idx_transactions_status');
            $table->index('paid_at', 'idx_transactions_paid_at');
            $table->index('payment_method', 'idx_transactions_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
