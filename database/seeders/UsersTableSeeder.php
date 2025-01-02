<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $roles = ['admin', 'penyedia_jasa', 'pengguna'];

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

        // Menambahkan 20 akun dummy lainnya
        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'username' => "user$i",
                'name' => "Nama Pengguna $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'nomor_wa' => '08123456789' . $i,
                'alamat_lengkap' => "Alamat $i",
                'role' => $roles[array_rand($roles)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
