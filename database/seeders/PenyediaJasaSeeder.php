<?php

namespace Database\Seeders;

use App\Models\PenyediaJasa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PenyediaJasaSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk penyedia jasa.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia untuk Faker

        // Loop untuk memasukkan beberapa record
        foreach (range(1, 10) as $index) {
            // Memastikan memilih pengguna dengan role 'penyedia_jasa' yang valid
            $user = User::where('role', 'penyedia_jasa')->inRandomOrder()->first();

            if ($user) {
                DB::table('penyedia_jasa')->insert([
                    'nama' => $faker->name, // Nama acak dari Faker
                    'foto' => $faker->imageUrl(), // Foto acak dari Faker
                    'user_id' => $user->id,  // Mengambil user_id dari pengguna dengan role penyedia_jasa
                    'email' => $faker->unique()->safeEmail, // Email acak dari Faker
                    'telpon' => $faker->phoneNumber, // Nomor telepon acak dari Faker
                    'gender' => $faker->randomElement(['Laki-Laki', 'Perempuan']), // Gender acak
                    'alamat' => $faker->address, // Alamat acak
                    'tanggal_lahir' => $faker->date(), // Tanggal lahir acak
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
