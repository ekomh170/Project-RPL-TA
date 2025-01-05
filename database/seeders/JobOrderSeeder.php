<?php

namespace Database\Seeders;

use App\Models\JobOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobOrderSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk job orders.
     */
    public function run(): void
    {
        // Menggunakan Faker dengan lokal id_ID
        $faker = Faker::create('id_ID'); // Tentukan locale untuk Indonesia

        // Daftar nama jasa yang sudah ditentukan
        $namaJasaList = [
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
        ];

        // Loop untuk memasukkan beberapa record
        foreach (range(1, 10) as $index) {
            DB::table('job_orders')->insert([
                'pembayaran' => $faker->randomElement(['Tunai', 'Transfer Bank']),
                'nama_pekerja' => \App\Models\PenyediaJasa::inRandomOrder()->first()->id,  // Ambil penyedia jasa secara acak
                'user_id' => \App\Models\User::inRandomOrder()->first()->id,  // Ambil user_id secara acak dari tabel 'users'
                'waktu_kerja' => $faker->time(),
                'nama_jasa' => $faker->randomElement($namaJasaList),  // Pilih nama jasa secara acak dari daftar yang diberikan
                'harga_penawaran' => $faker->randomFloat(2, 100000, 1000000),
                'tanggal_pelaksanaan' => $faker->date(),
                'gender' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'deskripsi' => $faker->sentence,
                'informasi_pembayaran' => $faker->sentence,
                'nomor_telepon' => $faker->phoneNumber,
                'bukti' => $faker->imageUrl(),
                'status' => $faker->randomElement(['Selesai', 'Batal']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
