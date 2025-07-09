<?php

namespace Database\Seeders;

use App\Models\PenyediaJasa;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PenyediaJasaSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk penyedia jasa.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua user dengan role penyedia_jasa yang aktif
        $penyediaUsers = User::where('role', 'penyedia_jasa')
            ->where('status', 'aktif')
            ->get();

        foreach ($penyediaUsers as $user) {
            // Buat profil penyedia jasa
            $penyediaJasa = PenyediaJasa::create([
                'user_id' => $user->id,
                'verification_status' => $faker->randomElement(['pending', 'verified', 'rejected']),
                'verification_documents' => $faker->sentence(10),
                'experience' => $faker->paragraph(3),
                'rating_average' => $faker->randomFloat(2, 3.0, 5.0),
                'total_reviews' => $faker->numberBetween(0, 50),
            ]);

            // Assign beberapa service random ke penyedia ini (many-to-many)
            $services = Service::where('status', 'tersedia')
                ->inRandomOrder()
                ->limit($faker->numberBetween(2, 5))
                ->get();

            foreach ($services as $service) {
                // Attach service dengan pivot data
                $penyediaJasa->services()->attach($service->id, [
                    'custom_price' => $faker->boolean(70) ? $faker->numberBetween(
                        $service->price * 0.8,
                        $service->price * 1.2
                    ) : null,
                    'is_available' => $faker->boolean(85), // 85% available
                    'notes' => $faker->boolean(50) ? $faker->sentence(8) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Buat beberapa penyedia jasa tambahan untuk user pending
        $pendingUsers = User::where('role', 'penyedia_jasa')
            ->where('status', 'pending')
            ->limit(5)
            ->get();

        foreach ($pendingUsers as $user) {
            PenyediaJasa::create([
                'user_id' => $user->id,
                'verification_status' => 'pending',
                'verification_documents' => 'Dokumen belum lengkap',
                'experience' => $faker->paragraph(2),
                'rating_average' => 0,
                'total_reviews' => 0,
            ]);
        }

        $this->command->info('✅ PenyediaJasa seeded successfully with service relationships!');
    }
}
