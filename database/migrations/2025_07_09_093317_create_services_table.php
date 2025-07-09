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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->string('image')->nullable();
            $table->enum('category', [
                'kebersihan',
                'perbaikan',
                'teknologi',
                'perawatan',
                'transportasi',
                'lainnya'
            ]);
            $table->integer('duration_hours')->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk optimasi query
            $table->index(['category', 'status'], 'idx_services_category_status');
            $table->index('status', 'idx_services_status');
            $table->index('price', 'idx_services_price');
            $table->index('name', 'idx_services_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
