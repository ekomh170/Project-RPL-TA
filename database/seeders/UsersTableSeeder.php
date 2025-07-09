<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Menggunakan Faker dengan lokal Indonesia
        $faker = Faker::create('id_ID');

        // Akun khusus untuk testing dan development
        User::create([
            'name' => 'Eko Muchamad Haryono',
            'email' => 'ekomh13@example.com',
            'phone' => '081234567891',
            'password' => Hash::make('admin2829'),
            'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
            'role' => 'pengguna',
            'status' => 'aktif',
        ]);

        User::create([
            'name' => 'Sofi Penyedia Jasa',
            'email' => 'sofi@example.com',
            'phone' => '081234567892',
            'password' => Hash::make('jasa2829'),
            'address' => 'Jl. Sudirman No. 456, Jakarta Selatan',
            'role' => 'penyedia_jasa',
            'status' => 'aktif',
        ]);

        User::create([
            'name' => 'Andhika Pengguna',
            'email' => 'andhika@example.com',
            'phone' => '081234567893',
            'password' => Hash::make('pengguna2829'),
            'address' => 'Jl. Thamrin No. 789, Jakarta Pusat',
            'role' => 'pengguna',
            'status' => 'aktif',
        ]);

        // Generate 20 pengguna (customers) dengan data Indonesia
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => "pengguna{$i}@example.com",
                'phone' => '0812345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'password' => Hash::make('password123'),
                'address' => $faker->address,
                'role' => 'pengguna',
                'status' => $faker->randomElement(['aktif', 'pending']),
            ]);
        }

        // Generate 15 penyedia jasa dengan data Indonesia
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => "provider{$i}@example.com",
                'phone' => '0812345679' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'password' => Hash::make('password123'),
                'address' => $faker->address,
                'role' => 'penyedia_jasa',
                'status' => $faker->randomElement(['aktif', 'pending', 'nonaktif']),
            ]);
        }

        $this->command->info('✅ Users seeded successfully with new migration structure!');
    }
}
