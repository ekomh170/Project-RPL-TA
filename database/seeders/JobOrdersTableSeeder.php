<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobOrdersTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('job_orders')->insert([
                'pembayaran' => 'Cash',
                'nama_pekerja' => "Pekerja $i",
                'waktu_kerja' => rand(1, 8) . " Jam",
                'nama_jasa' => "Jasa $i",
                'harga_penawaran' => rand(100000, 500000),
                'tanggal_pelaksanaan' => now()->addDays(rand(1, 10)),
                'waktu' => rand(8, 18) . ":00",
                'gender' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                'deskripsi' => "Deskripsi pekerjaan untuk jasa $i",
                'informasi_pembayaran' => 'Detail pembayaran',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
