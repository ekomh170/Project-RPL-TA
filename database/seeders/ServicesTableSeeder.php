<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        // Menggunakan Faker dengan lokal id_ID
        $faker = Faker::create('id_ID'); // Tentukan locale untuk Indonesia

        // Loop untuk memasukkan beberapa record
        for ($i = 1; $i <= 20; $i++) {
            DB::table('services')->insert([
                'nama_jasa' => $faker->randomElement([
                    'Jasa Pembersihan',
                    'Jasa Antar Barang',
                    'Jasa Desain Grafis',
                    'Jasa Perbaikan Elektronik',
                    'Jasa Pemasangan AC',
                    'Jasa Fotografi',
                    'Jasa Laundry',
                    'Jasa Pengerjaan Rumah',
                    'Jasa Keamanan',
                    'Jasa Pengiriman',
                    'Jasa Renovasi',
                    'Jasa Pembuatan Website',
                    'Jasa Konsultasi Keuangan',
                    'Jasa Penulisan Artikel',
                    'Jasa Pembuatan Konten Sosial Media',
                    'Jasa Pelatihan',
                    'Jasa Pengelolaan Media Sosial',
                    'Jasa Pemasaran Digital',
                    'Jasa Desain Interior'
                ]),
                'kategori' => $faker->randomElement([
                    'Pembersihan',
                    'Pengiriman',
                    'Desain',
                    'Perbaikan',
                    'Renovasi',
                    'Keamanan',
                    'Fotografi',
                    'Konsultasi',
                    'Pelatihan',
                    'Pemasaran Digital',
                    'Layanan Umum'
                ]),
                'harga' => rand(100000, 500000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
