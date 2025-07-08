<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TransactionsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 20; $i++) {
            // Ambil job order yang ada
            $jobOrder = \App\Models\JobOrder::inRandomOrder()->first();
            $user = \App\Models\User::where('role', 'pengguna')->inRandomOrder()->first();
            $penyediaJasa = \App\Models\PenyediaJasa::inRandomOrder()->first();

            DB::table('transactions')->insert([
                'user_id' => $user->id,
                'penyedia_jasa_id' => $penyediaJasa->id,  // Relasi ke PenyediaJasa, bukan User
                'job_order_id' => $jobOrder ? $jobOrder->id : null,  // Relasi ke JobOrder
                'metode_pembayaran' => $faker->randomElement(['Transfer Bank', 'E-Wallet', 'Cash', 'Kartu Kredit']),
                'tanggal' => $faker->dateTimeBetween('-30 days', 'now'),
                'tipe' => $faker->randomElement(['Pembayaran Layanan', 'Refund', 'Deposit', 'Bonus']),
                'status' => $faker->randomElement(['Pending', 'Berhasil', 'Gagal', 'Dibatalkan']),
                'bukti' => $faker->optional(0.7)->imageUrl(640, 480, 'business'),  // 70% chance ada bukti
                'total_amount' => $jobOrder ? $jobOrder->harga_penawaran : $faker->randomFloat(2, 50000, 1000000),  // Field baru
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
