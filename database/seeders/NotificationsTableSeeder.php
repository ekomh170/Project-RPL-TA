<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NotificationsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Daftar template pesan berdasarkan tipe
        $notificationTemplates = [
            'job_order' => [
                'Pesanan baru: {service_name}',
                'Pesanan Anda telah diterima oleh penyedia jasa',
                'Status pesanan Anda telah diupdate',
                'Pesanan telah selesai dikerjakan'
            ],
            'payment' => [
                'Pembayaran sebesar Rp {amount} telah diterima',
                'Menunggu konfirmasi pembayaran',
                'Pembayaran Anda sedang diproses',
                'Pembayaran berhasil dikonfirmasi'
            ],
            'status_update' => [
                'Penyedia jasa sedang dalam perjalanan',
                'Pekerjaan sedang dalam proses',
                'Pekerjaan akan segera dimulai',
                'Silakan berikan rating untuk layanan ini'
            ],
            'system' => [
                'Selamat datang di HandyGo!',
                'Profile Anda telah diverifikasi',
                'Jangan lupa untuk melengkapi profile Anda',
                'Ada promosi menarik untuk Anda!'
            ],
            'reminder' => [
                'Jangan lupa jadwal layanan Anda besok',
                'Masih ada pesanan yang menunggu konfirmasi',
                'Waktu untuk memberikan review layanan',
                'Update terakhir untuk pesanan Anda'
            ]
        ];

        for ($i = 1; $i <= 30; $i++) {
            $user = \App\Models\User::inRandomOrder()->first();
            $penyediaJasa = \App\Models\PenyediaJasa::inRandomOrder()->first();
            $notificationType = $faker->randomElement(['job_order', 'payment', 'status_update', 'system', 'reminder']);
            $message = $faker->randomElement($notificationTemplates[$notificationType]);

            DB::table('notifications')->insert([
                'user_id' => $user->id,
                'penyedia_jasa_id' => $faker->optional(0.8)->passthrough($penyediaJasa->id),  // 80% chance ada penyedia jasa
                'pesan' => $message,
                'status' => $faker->randomElement(['Aktif', 'Nonaktif', 'Pending']),
                'notification_type' => $notificationType,  // Field baru
                'is_read' => $faker->boolean(30),  // 30% sudah dibaca, field baru
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
