<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('services')->insert([
                'nama_jasa' => "Jasa $i",
                'kategori' => "Kategori $i",
                'harga' => rand(100000, 500000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
