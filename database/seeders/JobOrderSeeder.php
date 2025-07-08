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
            // Ambil service secara acak
            $service = \App\Models\Service::inRandomOrder()->first();
            $penyediaJasa = \App\Models\PenyediaJasa::inRandomOrder()->first();

            DB::table('job_orders')->insert([
                'pembayaran' => $faker->randomElement(['Tunai', 'Transfer Bank']),
                'penyedia_jasa_id' => $penyediaJasa->id,  // Gunakan nama field yang baru
                'service_id' => $service->id,  // Tambah relasi ke service
                'user_id' => \App\Models\User::where('role', 'pengguna')->inRandomOrder()->first()->id,  // Hanya pengguna biasa
                'waktu_kerja' => $faker->time(),
                'nama_jasa' => $service->nama_jasa,  // Ambil dari service yang dipilih
                'harga_penawaran' => $service->harga + $faker->randomFloat(2, -50000, 100000),  // Variasi dari harga service
                'tanggal_pelaksanaan' => $faker->dateTimeBetween('now', '+30 days'),
                'gender' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'deskripsi' => $faker->paragraph(2),
                'informasi_pembayaran' => $faker->sentence,
                'nomor_telepon' => $faker->phoneNumber,
                'bukti' => $faker->optional(0.3)->imageUrl(640, 480, 'business'),  // 30% chance ada bukti
                'status' => $faker->randomElement(['Pending', 'Diterima', 'Dalam Proses', 'Selesai', 'Dibatalkan']),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
