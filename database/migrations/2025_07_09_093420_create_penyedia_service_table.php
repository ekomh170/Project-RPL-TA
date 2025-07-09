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
        Schema::create('penyedia_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyedia_jasa_id')->constrained('penyedia_jasa')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->decimal('custom_price', 10, 2)->nullable(); // harga khusus dari provider
            $table->boolean('is_available')->default(true);
            $table->text('notes')->nullable(); // catatan khusus provider untuk service ini
            $table->timestamps();

            // Composite unique constraint - satu provider hanya bisa punya satu entry per service
            $table->unique(['penyedia_jasa_id', 'service_id'], 'unique_penyedia_service');

            // Indexes untuk optimasi
            $table->index('penyedia_jasa_id', 'idx_penyedia_service_provider');
            $table->index('service_id', 'idx_penyedia_service_service');
            $table->index('is_available', 'idx_penyedia_service_available');
            $table->index(['service_id', 'is_available'], 'idx_service_available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia_service');
    }
};
