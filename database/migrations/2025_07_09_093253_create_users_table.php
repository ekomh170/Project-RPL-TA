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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['pengguna', 'penyedia_jasa']);
            $table->enum('status', ['pending', 'aktif', 'nonaktif'])->default('pending');
            $table->text('address')->nullable();
            $table->string('profile_picture')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // Essential indexes untuk optimasi query
            $table->index(['email', 'status'], 'idx_users_email_status');
            $table->index('role', 'idx_users_role');
            $table->index('status', 'idx_users_status');
            $table->index('phone', 'idx_users_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
