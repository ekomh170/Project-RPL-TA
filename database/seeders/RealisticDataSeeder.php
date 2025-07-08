<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        // Scenario 3: Notifications untuk berbagai scenarios
        $this->createRealisticNotifications($faker);
    }

    private function createCompleteOrderFlow($faker)
    {
        // Ambil user pengguna
        $customer = \App\Models\User::where('role', 'pengguna')->first();
        $provider = \App\Models\PenyediaJasa::first();
        $service = \App\Models\Service::where('nama_jasa', 'Jasa Pembersihan')->first();

        if (!$customer || !$provider || !$service) return;

        // 1. Buat Job Order
        $jobOrder = DB::table('job_orders')->insertGetId([
            'pembayaran' => 'Transfer Bank',
            'penyedia_jasa_id' => $provider->id,
            'service_id' => $service->id,
            'user_id' => $customer->id,
            'waktu_kerja' => '08:00',
            'nama_jasa' => $service->nama_jasa,
            'harga_penawaran' => 150000,
            'tanggal_pelaksanaan' => now()->addDays(2),
            'gender' => 'Laki-laki',
            'deskripsi' => 'Pembersihan rumah 2 lantai, termasuk kamar mandi dan dapur',
            'informasi_pembayaran' => 'Transfer ke rekening BCA 1234567890',
            'nomor_telepon' => '081234567890',
            'status' => 'Diterima',
            'created_at' => now()->subHours(2),
            'updated_at' => now()->subHours(1),
        ]);

        // 2. Buat Transaction terkait
        DB::table('transactions')->insert([
            'user_id' => $customer->id,
            'penyedia_jasa_id' => $provider->id,
            'job_order_id' => $jobOrder,
            'metode_pembayaran' => 'Transfer Bank',
            'tanggal' => now()->subHours(1),
            'tipe' => 'Pembayaran Layanan',
            'status' => 'Berhasil',
            'bukti' => 'bukti_transfer_' . $jobOrder . '.jpg',
            'total_amount' => 150000,
            'created_at' => now()->subHours(1),
            'updated_at' => now(),
        ]);

        // 3. Buat Notifications untuk flow ini
        DB::table('notifications')->insert([
            [
                'user_id' => $customer->id,
                'penyedia_jasa_id' => $provider->id,
                'pesan' => 'Pesanan pembersihan rumah Anda telah diterima dan akan dikerjakan besok',
                'status' => 'Aktif',
                'notification_type' => 'job_order',
                'is_read' => false,
                'created_at' => now()->subHours(1),
                'updated_at' => now()->subHours(1),
            ],
            [
                'user_id' => $customer->id,
                'penyedia_jasa_id' => $provider->id,
                'pesan' => 'Pembayaran sebesar Rp 150.000 telah dikonfirmasi',
                'status' => 'Aktif',
                'notification_type' => 'payment',
                'is_read' => false,
                'created_at' => now()->subMinutes(30),
                'updated_at' => now()->subMinutes(30),
            ]
        ]);
    }

    private function createMultipleOrdersForUser($faker)
    {
        $customer = \App\Models\User::where('role', 'pengguna')->skip(1)->first();
        if (!$customer) return;

        $services = \App\Models\Service::limit(3)->get();
        $providers = \App\Models\PenyediaJasa::limit(2)->get();

        foreach ($services as $index => $service) {
            $provider = $providers[$index % 2];
            $status = $faker->randomElement(['Pending', 'Diterima', 'Selesai']);

            $jobOrder = DB::table('job_orders')->insertGetId([
                'pembayaran' => $faker->randomElement(['Transfer Bank', 'E-Wallet']),
                'penyedia_jasa_id' => $provider->id,
                'service_id' => $service->id,
                'user_id' => $customer->id,
                'waktu_kerja' => $faker->time('H:i'),
                'nama_jasa' => $service->nama_jasa,
                'harga_penawaran' => $service->harga + $faker->randomFloat(2, -20000, 50000),
                'tanggal_pelaksanaan' => $faker->dateTimeBetween('now', '+14 days'),
                'gender' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'deskripsi' => $faker->paragraph(2),
                'informasi_pembayaran' => 'Transfer ke rekening BCA ' . $faker->bankAccountNumber,
                'nomor_telepon' => $faker->phoneNumber,
                'status' => $status,
                'created_at' => $faker->dateTimeBetween('-7 days', 'now'),
                'updated_at' => now(),
            ]);

            // Buat transaction jika status bukan pending
            if ($status !== 'Pending') {
                DB::table('transactions')->insert([
                    'user_id' => $customer->id,
                    'penyedia_jasa_id' => $provider->id,
                    'job_order_id' => $jobOrder,
                    'metode_pembayaran' => $faker->randomElement(['Transfer Bank', 'E-Wallet']),
                    'tanggal' => $faker->dateTimeBetween('-6 days', 'now'),
                    'tipe' => 'Pembayaran Layanan',
                    'status' => $status === 'Selesai' ? 'Berhasil' : 'Pending',
                    'bukti' => $faker->optional(0.8)->passthrough('bukti_' . $jobOrder . '.jpg'),
                    'total_amount' => $service->harga,
                    'created_at' => $faker->dateTimeBetween('-6 days', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function createRealisticNotifications($faker)
    {
        $users = \App\Models\User::where('role', 'pengguna')->limit(5)->get();
        $providers = \App\Models\PenyediaJasa::limit(3)->get();

        $realisticMessages = [
            'job_order' => [
                'Pesanan Anda telah diterima dan akan dikerjakan hari ini jam 14:00',
                'Penyedia jasa sedang dalam perjalanan ke lokasi Anda',
                'Pekerjaan telah selesai. Silakan berikan rating untuk layanan ini',
                'Pesanan Anda telah dibatalkan karena penyedia jasa berhalangan'
            ],
            'payment' => [
                'Pembayaran sebesar Rp 250.000 telah dikonfirmasi',
                'Menunggu konfirmasi pembayaran dari Anda',
                'Refund sebesar Rp 100.000 telah diproses ke rekening Anda',
                'Pembayaran gagal diproses. Silakan coba lagi'
            ],
            'status_update' => [
                'Penyedia jasa telah sampai di lokasi',
                'Pekerjaan sedang berlangsung (50% selesai)',
                'Pekerjaan akan dimulai dalam 15 menit',
                'Silakan berikan review untuk layanan yang telah selesai'
            ],
            'reminder' => [
                'Jangan lupa, layanan Anda dijadwalkan besok jam 10:00',
                'Anda memiliki 2 pesanan yang menunggu konfirmasi',
                'Ingat untuk menyiapkan area kerja sebelum penyedia jasa datang',
                'Masih ada pesanan yang belum Anda review'
            ]
        ];

        foreach ($users as $user) {
            $provider = $providers[array_rand($providers->toArray())];
            $notificationType = array_rand($realisticMessages);
            $message = $realisticMessages[$notificationType][array_rand($realisticMessages[$notificationType])];

            DB::table('notifications')->insert([
                'user_id' => $user->id,
                'penyedia_jasa_id' => $provider->id,
                'pesan' => $message,
                'status' => 'Aktif',
                'notification_type' => $notificationType,
                'is_read' => $faker->boolean(20), // 20% sudah dibaca
                'created_at' => $faker->dateTimeBetween('-5 days', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
