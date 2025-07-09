<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use App\Models\JobOrder;
use App\Models\Transaction;
use Faker\Factory as Faker;

class NotificationsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $users = User::all();
        $jobOrders = JobOrder::all();
        $transactions = Transaction::all();

        if ($users->isEmpty()) {
            $this->command->error('❌ No users found. Please run UsersTableSeeder first.');
            return;
        }

        // Notifikasi berdasarkan job orders yang ada
        foreach ($jobOrders->take(15) as $jobOrder) {
            // Notifikasi untuk customer
            $this->createJobOrderNotifications($jobOrder, $faker);

            // Notifikasi untuk provider (jika ada)
            if ($jobOrder->provider_id) {
                $this->createProviderNotifications($jobOrder, $faker);
            }
        }

        // Notifikasi berdasarkan transactions
        foreach ($transactions->take(10) as $transaction) {
            $this->createTransactionNotifications($transaction, $faker);
        }

        // Notifikasi umum untuk semua user
        foreach ($users->take(20) as $user) {
            $this->createGeneralNotifications($user, $faker);
        }

        $this->command->info('✅ Notifications seeded successfully with new migration structure!');
    }

    private function createJobOrderNotifications($jobOrder, $faker)
    {
        $notifications = [
            [
                'title' => 'Pesanan Dibuat',
                'message' => "Pesanan #{$jobOrder->order_code} untuk layanan {$jobOrder->service->name} telah dibuat.",
                'type' => 'update_pesanan',
                'data' => ['job_order_id' => $jobOrder->id, 'order_code' => $jobOrder->order_code],
            ]
        ];

        if ($jobOrder->status === 'diterima') {
            $notifications[] = [
                'title' => 'Pesanan Diterima',
                'message' => "Pesanan #{$jobOrder->order_code} telah diterima oleh penyedia jasa.",
                'type' => 'update_pesanan',
                'data' => ['job_order_id' => $jobOrder->id, 'order_code' => $jobOrder->order_code],
            ];
        }

        if ($jobOrder->status === 'dikerjakan') {
            $notifications[] = [
                'title' => 'Pekerjaan Dimulai',
                'message' => "Penyedia jasa telah memulai mengerjakan pesanan #{$jobOrder->order_code}.",
                'type' => 'update_pesanan',
                'data' => ['job_order_id' => $jobOrder->id, 'order_code' => $jobOrder->order_code],
            ];
        }

        if ($jobOrder->status === 'selesai') {
            $notifications[] = [
                'title' => 'Pesanan Selesai',
                'message' => "Pesanan #{$jobOrder->order_code} telah selesai dikerjakan. Mohon berikan rating dan review.",
                'type' => 'berhasil',
                'data' => ['job_order_id' => $jobOrder->id, 'order_code' => $jobOrder->order_code],
            ];
        }

        foreach ($notifications as $notifData) {
            Notification::create([
                'user_id' => $jobOrder->user_id,
                'title' => $notifData['title'],
                'message' => $notifData['message'],
                'type' => $notifData['type'],
                'data' => $notifData['data'],
                'read_at' => $faker->boolean(40) ? $faker->dateTimeBetween($jobOrder->created_at, 'now') : null,
                'created_at' => $jobOrder->created_at,
            ]);
        }
    }

    private function createProviderNotifications($jobOrder, $faker)
    {
        if (!$jobOrder->provider || !$jobOrder->provider->user) return;

        Notification::create([
            'user_id' => $jobOrder->provider->user_id,
            'title' => 'Pesanan Baru',
            'message' => "Ada pesanan baru untuk layanan {$jobOrder->service->name} di area {$jobOrder->address}.",
            'type' => 'update_pesanan',
            'data' => ['job_order_id' => $jobOrder->id, 'order_code' => $jobOrder->order_code],
            'read_at' => $faker->boolean(60) ? $faker->dateTimeBetween($jobOrder->created_at, 'now') : null,
            'created_at' => $jobOrder->created_at,
        ]);
    }

    private function createTransactionNotifications($transaction, $faker)
    {
        $notifications = [];

        if ($transaction->status === 'lunas') {
            $notifications[] = [
                'title' => 'Pembayaran Berhasil',
                'message' => "Pembayaran sebesar {$transaction->getFormattedTotalAmount()} untuk transaksi #{$transaction->transaction_code} telah berhasil.",
                'type' => 'update_pembayaran',
            ];
        } elseif ($transaction->status === 'gagal') {
            $notifications[] = [
                'title' => 'Pembayaran Gagal',
                'message' => "Pembayaran untuk transaksi #{$transaction->transaction_code} gagal diproses. Silakan coba lagi.",
                'type' => 'error',
            ];
        } elseif ($transaction->status === 'kadaluarsa') {
            $notifications[] = [
                'title' => 'Pembayaran Kadaluarsa',
                'message' => "Waktu pembayaran untuk transaksi #{$transaction->transaction_code} telah habis.",
                'type' => 'peringatan',
            ];
        }

        foreach ($notifications as $notifData) {
            Notification::create([
                'user_id' => $transaction->user_id,
                'title' => $notifData['title'],
                'message' => $notifData['message'],
                'type' => $notifData['type'],
                'data' => [
                    'transaction_id' => $transaction->id,
                    'transaction_code' => $transaction->transaction_code,
                    'job_order_id' => $transaction->job_order_id,
                ],
                'read_at' => $faker->boolean(50) ? $faker->dateTimeBetween($transaction->created_at, 'now') : null,
                'created_at' => $transaction->created_at,
            ]);
        }
    }

    private function createGeneralNotifications($user, $faker)
    {
        $generalNotifications = [
            [
                'title' => 'Selamat Datang di HandyGo!',
                'message' => 'Terima kasih telah bergabung dengan HandyGo. Jelajahi berbagai layanan yang tersedia.',
                'type' => 'informasi',
            ],
            [
                'title' => 'Tips Menggunakan HandyGo',
                'message' => 'Lengkapi profil Anda untuk mendapatkan layanan yang lebih personal.',
                'type' => 'informasi',
            ],
            [
                'title' => 'Promo Spesial',
                'message' => 'Dapatkan diskon 20% untuk pemesanan pertama Anda!',
                'type' => 'informasi',
            ],
        ];

        // Hanya buat 1-2 notifikasi general per user
        $selectedNotifications = $faker->randomElements($generalNotifications, $faker->numberBetween(1, 2));

        foreach ($selectedNotifications as $notifData) {
            Notification::create([
                'user_id' => $user->id,
                'title' => $notifData['title'],
                'message' => $notifData['message'],
                'type' => $notifData['type'],
                'data' => null,
                'read_at' => $faker->boolean(30) ? $faker->dateTimeBetween('-30 days', 'now') : null,
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }
    }
}
