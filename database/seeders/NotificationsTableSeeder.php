<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('notifications')->insert([
                'user_id' => rand(1, 20),
                'penyedia_jasa_id' => rand(1, 20),
                'pesan' => "Notifikasi untuk pengguna $i",
                'status' => rand(0, 1) ? 'Belum Dibaca' : 'Dibaca',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
