<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Menggunakan Faker dengan lokal Indonesia
        $faker = Faker::create('id_ID');

        // Menambahkan akun khusus untuk Eko Muchamad Haryono
        DB::table('users')->insert([
            'username' => 'ekoharyono',
            'name' => 'Eko Muchamad Haryono',
            'email' => 'ekomh13@example.com',
            'password' => Hash::make('admin2829'),
            'nomor_wa' => '081234567891',
            'alamat_lengkap' => 'Alamat Khusus Eko',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'username' => 'sofi',
            'name' => 'Sofi',
            'email' => 'sofi@example.com',
            'password' => Hash::make('jasa2829'),
            'nomor_wa' => '081234567891',
            'alamat_lengkap' => 'Alamat Khusus Fadil',
            'role' => 'penyedia_jasa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'username' => 'andhika',
            'name' => 'Andhika',
            'email' => 'andhika@example.com',
            'password' => Hash::make('pengguna2829'),
            'nomor_wa' => '081234567891',
            'alamat_lengkap' => 'Alamat Khusus Andhika',
            'role' => 'pengguna',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Menambahkan akun untuk 20 pengguna dengan nama Indonesia menggunakan Faker
        $roles = ['admin', 'penyedia_jasa', 'pengguna'];
        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'username' => "user$i",
                'name' => $faker->name, // Menggunakan Faker untuk nama acak Indonesia
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'nomor_wa' => '08123456789' . $i,
                'alamat_lengkap' => $faker->address, // Menggunakan alamat acak dari Faker
                'role' => $roles[array_rand($roles)], // Memilih role acak
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
