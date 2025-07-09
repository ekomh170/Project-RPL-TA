<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\PenyediaJasa;
use App\Models\JobOrder;
use App\Models\Transaction;
use App\Models\Notification;
use Faker\Factory as Faker;

class RealisticDataSeeder extends Seeder
{
    /**
     * Seed realistic data untuk testing aplikasi HandyGo.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Scenario 1: Complete flow dari order sampai transaction
        $this->createCompleteOrderFlow($faker);

        // Scenario 2: Multiple orders untuk satu user
        $this->createMultipleOrdersForUser($faker);

        // Scenario 3: Busy provider dengan banyak order
        $this->createBusyProviderScenario($faker);

        $this->command->info('✅ Realistic test data seeded successfully!');
    }

    private function createCompleteOrderFlow($faker)
    {
        $customer = User::where('role', 'pengguna')->where('status', 'aktif')->first();
        $provider = PenyediaJasa::whereHas('user', function ($q) {
            $q->where('status', 'aktif');
        })->first();
        $service = Service::where('status', 'tersedia')->first();

        if (!$customer || !$provider || !$service) {
            $this->command->warn('⚠️ Insufficient data for complete order flow scenario');
            return;
        }

        // 1. Buat Job Order yang sudah selesai
        $jobOrder = JobOrder::create([
            'user_id' => $customer->id,
            'service_id' => $service->id,
            'provider_id' => $provider->id,
            'description' => 'Pembersihan rumah 2 lantai, termasuk kamar mandi dan dapur. Kondisi rumah cukup kotor karena baru renovasi.',
            'address' => 'Jl. Merdeka No. 123, RT 05/RW 12, Menteng, Jakarta Pusat',
            'customer_phone' => $customer->phone,
            'status' => 'selesai',
            'base_price' => $service->price,
            'final_price' => $service->price,
            'admin_fee' => 5000,
            'scheduled_at' => now()->subDays(1),
            'started_at' => now()->subDays(1)->addHours(8),
            'completed_at' => now()->subDays(1)->addHours(12),
            'rating' => 5,
            'review' => 'Pelayanan sangat memuaskan! Rumah menjadi sangat bersih dan pekerjaan dilakukan dengan teliti.',
            'created_at' => now()->subDays(2),
        ]);

        // 2. Buat Transaction untuk order ini
        $transaction = Transaction::create([
            'job_order_id' => $jobOrder->id,
            'user_id' => $customer->id,
            'amount' => $jobOrder->final_price,
            'admin_fee' => $jobOrder->admin_fee,
            'total_amount' => $jobOrder->final_price + $jobOrder->admin_fee,
            'payment_method' => 'transfer_bank',
            'status' => 'lunas',
            'paid_at' => now()->subDays(1)->subHours(2),
            'payment_reference' => 'PAY-' . strtoupper($faker->bothify('??##??##')),
            'payment_details' => [
                'bank' => 'BCA',
                'account_number' => '1234567890',
                'account_name' => 'HandyGo Payment Gateway'
            ],
            'created_at' => now()->subDays(2)->addHour(),
        ]);

        // 3. Buat notifikasi untuk customer
        Notification::createJobOrderNotification(
            $customer->id,
            $jobOrder,
            'Pesanan Anda telah selesai dikerjakan dengan baik. Terima kasih telah menggunakan HandyGo!',
            'berhasil'
        );

        // 4. Buat notifikasi untuk provider
        Notification::createJobOrderNotification(
            $provider->user_id,
            $jobOrder,
            'Selamat! Anda telah menyelesaikan pesanan dan mendapat rating 5 bintang.',
            'berhasil'
        );

        // 5. Update rating provider
        $provider->updateRatingAverage();
    }

    private function createMultipleOrdersForUser($faker)
    {
        $customer = User::where('role', 'pengguna')->where('status', 'aktif')->skip(1)->first();
        if (!$customer) return;

        $services = Service::where('status', 'tersedia')->limit(4)->get();
        $providers = PenyediaJasa::whereHas('user', function ($q) {
            $q->where('status', 'aktif');
        })->limit(3)->get();

        if ($services->isEmpty() || $providers->isEmpty()) return;

        $statuses = ['menunggu', 'diterima', 'dikerjakan', 'selesai'];

        foreach ($services as $index => $service) {
            $provider = $providers[$index % $providers->count()];
            $status = $statuses[$index % count($statuses)];

            // Tentukan provider berdasarkan status
            $assignedProvider = $status === 'menunggu' ? null : $provider;

            $scheduledDate = $faker->dateTimeBetween('-7 days', '+14 days');
            $startedAt = null;
            $completedAt = null;
            $rating = null;
            $review = null;

            if (in_array($status, ['dikerjakan', 'selesai'])) {
                // Pastikan scheduled date di masa lalu untuk order yang sudah dimulai
                if ($scheduledDate > now()) {
                    $scheduledDate = $faker->dateTimeBetween('-7 days', 'now');
                }
                $startedAt = $faker->dateTimeBetween($scheduledDate, 'now');
            }

            if ($status === 'selesai') {
                $completedAt = $faker->dateTimeBetween($startedAt, 'now');
                $rating = $faker->numberBetween(4, 5);
                $review = $faker->randomElement([
                    'Pelayanan sangat baik dan profesional',
                    'Pekerjaan rapi dan sesuai ekspektasi',
                    'Recommended! Akan menggunakan lagi',
                    'Kualitas kerja memuaskan, datang tepat waktu'
                ]);
            }

            $jobOrder = JobOrder::create([
                'user_id' => $customer->id,
                'service_id' => $service->id,
                'provider_id' => $assignedProvider?->id,
                'description' => $faker->paragraph(1),
                'address' => $faker->address,
                'customer_phone' => $customer->phone,
                'status' => $status,
                'base_price' => $service->price,
                'final_price' => $assignedProvider ? $faker->numberBetween($service->price * 0.95, $service->price * 1.05) : $service->price,
                'admin_fee' => 5000,
                'scheduled_at' => $scheduledDate,
                'started_at' => $startedAt,
                'completed_at' => $completedAt,
                'rating' => $rating,
                'review' => $review,
                'created_at' => $faker->dateTimeBetween('-10 days', 'now'),
            ]);

            // Buat transaction jika bukan menunggu
            if ($status !== 'menunggu') {
                $transactionStatus = match ($status) {
                    'diterima' => $faker->randomElement(['menunggu', 'lunas']),
                    'dikerjakan', 'selesai' => 'lunas',
                    default => 'menunggu'
                };

                Transaction::create([
                    'job_order_id' => $jobOrder->id,
                    'user_id' => $customer->id,
                    'amount' => $jobOrder->final_price,
                    'admin_fee' => $jobOrder->admin_fee,
                    'total_amount' => $jobOrder->final_price + $jobOrder->admin_fee,
                    'payment_method' => $faker->randomElement(['transfer_bank', 'dompet_digital', 'qris']),
                    'status' => $transactionStatus,
                    'paid_at' => $transactionStatus === 'lunas' ? $faker->dateTimeBetween($jobOrder->created_at, 'now') : null,
                    'payment_reference' => $transactionStatus === 'lunas' ? 'PAY-' . strtoupper($faker->bothify('??##??##')) : null,
                    'created_at' => $jobOrder->created_at->addMinutes(30),
                ]);
            }

            // Buat notifikasi sesuai status
            $this->createStatusNotification($jobOrder, $customer, $assignedProvider, $faker);
        }
    }

    private function createBusyProviderScenario($faker)
    {
        $busyProvider = PenyediaJasa::whereHas('user', function ($q) {
            $q->where('status', 'aktif');
        })->first();

        if (!$busyProvider) return;

        $customers = User::where('role', 'pengguna')->where('status', 'aktif')->limit(5)->get();
        $services = Service::where('status', 'tersedia')->limit(3)->get();

        // Buat multiple orders untuk provider ini
        foreach ($customers->take(3) as $customer) {
            $service = $services->random();

            $jobOrder = JobOrder::create([
                'user_id' => $customer->id,
                'service_id' => $service->id,
                'provider_id' => $busyProvider->id,
                'description' => $faker->paragraph(1),
                'address' => $faker->address,
                'customer_phone' => $customer->phone,
                'status' => 'diterima',
                'base_price' => $service->price,
                'final_price' => $service->price,
                'admin_fee' => 5000,
                'scheduled_at' => $faker->dateTimeBetween('now', '+7 days'),
                'created_at' => $faker->dateTimeBetween('-3 days', 'now'),
            ]);

            // Notification untuk provider yang busy
            Notification::create([
                'user_id' => $busyProvider->user_id,
                'title' => 'Pesanan Baru Diterima',
                'message' => "Anda telah menerima pesanan baru untuk {$service->name}. Total pesanan aktif: 3",
                'type' => 'update_pesanan',
                'data' => ['job_order_id' => $jobOrder->id, 'order_code' => $jobOrder->order_code],
                'created_at' => $jobOrder->created_at->addMinutes(5),
            ]);
        }
    }

    private function createStatusNotification($jobOrder, $customer, $provider, $faker)
    {
        $messages = [
            'menunggu' => 'Pesanan Anda sedang menunggu penyedia jasa. Kami akan segera mencarikan yang terbaik untuk Anda.',
            'diterima' => 'Pesanan Anda telah diterima dan akan dikerjakan sesuai jadwal.',
            'dikerjakan' => 'Penyedia jasa sedang mengerjakan pesanan Anda. Mohon menunggu hingga selesai.',
            'selesai' => 'Pesanan Anda telah selesai dikerjakan. Silakan berikan rating dan review.'
        ];

        if (isset($messages[$jobOrder->status])) {
            Notification::createJobOrderNotification(
                $customer->id,
                $jobOrder,
                $messages[$jobOrder->status],
                $jobOrder->status === 'selesai' ? 'berhasil' : 'update_pesanan'
            );
        }

        // Notifikasi untuk provider jika ada
        if ($provider && $jobOrder->status === 'diterima') {
            Notification::createJobOrderNotification(
                $provider->user_id,
                $jobOrder,
                "Anda telah menerima pesanan baru untuk {$jobOrder->service->name}.",
                'update_pesanan'
            );
        }
    }
}