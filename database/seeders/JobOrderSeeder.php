<?php

namespace Database\Seeders;

use App\Models\JobOrder;
use App\Models\User;
use App\Models\Service;
use App\Models\PenyediaJasa;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JobOrderSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk job orders.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil data yang diperlukan
        $users = User::where('role', 'pengguna')->where('status', 'aktif')->get();
        $services = Service::where('status', 'tersedia')->get();
        $providers = PenyediaJasa::whereHas('user', function ($query) {
            $query->where('status', 'aktif');
        })->get();

        if ($users->isEmpty() || $services->isEmpty() || $providers->isEmpty()) {
            $this->command->error('❌ Insufficient data for JobOrder seeding. Please run Users, Services, and PenyediaJasa seeders first.');
            return;
        }

        // Generate 30 job orders dengan berbagai status
        for ($i = 1; $i <= 30; $i++) {
            $user = $users->random();
            $service = $services->random();
            $status = $faker->randomElement(['menunggu', 'diterima', 'dikerjakan', 'selesai', 'dibatalkan']);

            // Provider hanya assigned jika status bukan menunggu
            $provider = $status === 'menunggu' ? null : $providers->random();

            // Hitung harga
            $basePrice = $service->price;
            $finalPrice = $provider && $faker->boolean(30)
                ? $faker->numberBetween($basePrice * 0.9, $basePrice * 1.1)
                : $basePrice;
            $adminFee = 5000;

            // Tanggal scheduling
            $scheduledAt = $faker->dateTimeBetween('-7 days', '+30 days');
            $startedAt = null;
            $completedAt = null;

            if (in_array($status, ['dikerjakan', 'selesai'])) {
                // Untuk yang sudah dimulai, pastikan scheduled date di masa lalu
                if ($scheduledAt > now()) {
                    $scheduledAt = $faker->dateTimeBetween('-7 days', 'now');
                }
                $startedAt = $faker->dateTimeBetween($scheduledAt, 'now');
            }

            if ($status === 'selesai') {
                $completedAt = $faker->dateTimeBetween($startedAt, 'now');
            }

            // Rating dan review hanya untuk yang selesai
            $rating = null;
            $review = null;
            if ($status === 'selesai' && $faker->boolean(70)) {
                $rating = $faker->numberBetween(3, 5);
                $review = $faker->paragraph(2);
            }

            JobOrder::create([
                'user_id' => $user->id,
                'service_id' => $service->id,
                'provider_id' => $provider?->id,
                'description' => $faker->optional(0.8)->paragraph(1),
                'address' => $faker->address,
                'customer_phone' => $user->phone,
                'status' => $status,
                'base_price' => $basePrice,
                'final_price' => $finalPrice,
                'admin_fee' => $adminFee,
                'scheduled_at' => $scheduledAt,
                'started_at' => $startedAt,
                'completed_at' => $completedAt,
                'rating' => $rating,
                'review' => $review,
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }

        // Generate beberapa order khusus untuk testing
        $this->generateTestOrders($faker, $users, $services, $providers);

        $this->command->info('✅ JobOrder seeded successfully with new migration structure!');
    }

    private function generateTestOrders($faker, $users, $services, $providers)
    {
        // Order menunggu (untuk testing workflow)
        JobOrder::create([
            'user_id' => $users->first()->id,
            'service_id' => $services->first()->id,
            'provider_id' => null,
            'description' => 'Order untuk testing - status menunggu',
            'address' => 'Jl. Testing No. 123, Jakarta',
            'customer_phone' => $users->first()->phone,
            'status' => 'menunggu',
            'base_price' => $services->first()->price,
            'final_price' => $services->first()->price,
            'admin_fee' => 5000,
            'scheduled_at' => now()->addDays(3),
        ]);

        // Order dalam progress (untuk testing)
        JobOrder::create([
            'user_id' => $users->first()->id,
            'service_id' => $services->skip(1)->first()->id,
            'provider_id' => $providers->first()->id,
            'description' => 'Order untuk testing - sedang dikerjakan',
            'address' => 'Jl. Testing No. 456, Jakarta',
            'customer_phone' => $users->first()->phone,
            'status' => 'dikerjakan',
            'base_price' => $services->skip(1)->first()->price,
            'final_price' => $services->skip(1)->first()->price,
            'admin_fee' => 5000,
            'scheduled_at' => now()->subDays(1),
            'started_at' => now()->subHours(2),
        ]);
    }
}
