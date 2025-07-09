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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Notification content
            $table->string('title');
            $table->text('message');
            $table->enum('type', [
                'informasi',
                'peringatan',
                'berhasil',
                'error',
                'update_pesanan',
                'update_pembayaran'
            ]);

            // Additional data (JSON untuk menyimpan data terkait seperti job_order_id, etc)
            $table->json('data')->nullable();

            // Notification status
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_pushed')->default(false); // untuk push notification

            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk notifikasi
            $table->index(['user_id', 'read_at'], 'idx_notifications_user_read');
            $table->index(['user_id', 'type'], 'idx_notifications_user_type');
            $table->index('type', 'idx_notifications_type');
            $table->index('created_at', 'idx_notifications_created');
            $table->index(['user_id', 'created_at'], 'idx_notifications_user_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
