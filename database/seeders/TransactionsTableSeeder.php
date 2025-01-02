<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('transactions')->insert([
                'user_id' => rand(1, 20),
                'penyedia_jasa_id' => rand(1, 20),
                'metode_pembayaran' => 'Transfer Bank',
                'tanggal' => now()->subDays(rand(1, 30)),
                'tipe' => 'Layanan',
                'status' => rand(0, 1) ? 'Selesai' : 'Proses',
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
