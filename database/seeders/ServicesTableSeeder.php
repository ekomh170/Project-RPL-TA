<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Faker\Factory as Faker;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Daftar service dengan kategori yang sesuai migration
        $servicesData = [
            // Kategori Kebersihan
            [
                'name' => 'Pembersihan Rumah',
                'description' => 'Layanan pembersihan rumah menyeluruh termasuk lantai, jendela, dan furnitur.',
                'price' => 150000,
                'category' => 'kebersihan',
                'duration_hours' => 3,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Pembersihan Kantor',
                'description' => 'Pembersihan ruang kantor, meja kerja, dan area umum.',
                'price' => 200000,
                'category' => 'kebersihan',
                'duration_hours' => 4,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Cuci Mobil',
                'description' => 'Layanan cuci mobil lengkap dengan wax dan vacuum interior.',
                'price' => 75000,
                'category' => 'kebersihan',
                'duration_hours' => 2,
                'status' => 'tersedia',
            ],

            // Kategori Perbaikan
            [
                'name' => 'Servis AC',
                'description' => 'Perbaikan dan perawatan AC rumah tangga dan komersial.',
                'price' => 180000,
                'category' => 'perbaikan',
                'duration_hours' => 2,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Perbaikan Elektronik',
                'description' => 'Reparasi perangkat elektronik seperti TV, radio, dan peralatan rumah.',
                'price' => 120000,
                'category' => 'perbaikan',
                'duration_hours' => 3,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Perbaikan Plumbing',
                'description' => 'Perbaikan pipa air, keran, dan sistem sanitasi.',
                'price' => 160000,
                'category' => 'perbaikan',
                'duration_hours' => 2,
                'status' => 'tersedia',
            ],

            // Kategori Teknologi
            [
                'name' => 'Pembuatan Website',
                'description' => 'Jasa pembuatan website profesional untuk bisnis dan personal.',
                'price' => 2500000,
                'category' => 'teknologi',
                'duration_hours' => 40,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Instalasi Software',
                'description' => 'Instalasi dan konfigurasi software komputer dan aplikasi.',
                'price' => 100000,
                'category' => 'teknologi',
                'duration_hours' => 2,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Maintenance Komputer',
                'description' => 'Perawatan dan optimasi komputer untuk performa maksimal.',
                'price' => 150000,
                'category' => 'teknologi',
                'duration_hours' => 3,
                'status' => 'tersedia',
            ],

            // Kategori Perawatan
            [
                'name' => 'Perawatan Taman',
                'description' => 'Pemangkasan tanaman, penyiraman, dan perawatan landscape.',
                'price' => 120000,
                'category' => 'perawatan',
                'duration_hours' => 3,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Grooming Hewan',
                'description' => 'Layanan grooming dan perawatan hewan peliharaan.',
                'price' => 80000,
                'category' => 'perawatan',
                'duration_hours' => 2,
                'status' => 'tersedia',
            ],

            // Kategori Transportasi
            [
                'name' => 'Antar Jemput',
                'description' => 'Layanan antar jemput untuk keperluan sehari-hari.',
                'price' => 50000,
                'category' => 'transportasi',
                'duration_hours' => 1,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Delivery Barang',
                'description' => 'Pengiriman barang dalam kota dengan aman dan cepat.',
                'price' => 25000,
                'category' => 'transportasi',
                'duration_hours' => 1,
                'status' => 'tersedia',
            ],

            // Kategori Lainnya
            [
                'name' => 'Jasa Fotografi',
                'description' => 'Layanan fotografi untuk acara, wedding, dan corporate.',
                'price' => 500000,
                'category' => 'lainnya',
                'duration_hours' => 6,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Les Privat',
                'description' => 'Les privat untuk berbagai mata pelajaran dan skill.',
                'price' => 100000,
                'category' => 'lainnya',
                'duration_hours' => 2,
                'status' => 'tersedia',
            ],
        ];

        // Insert predefined services
        foreach ($servicesData as $serviceData) {
            Service::create($serviceData);
        }

        // Generate additional random services
        for ($i = 1; $i <= 10; $i++) {
            Service::create([
                'name' => $faker->randomElement([
                    'Jasa Konsultasi Bisnis',
                    'Pembuatan Konten Media Sosial',
                    'Desain Grafis',
                    'Jasa Catering',
                    'Massage Therapy',
                    'Personal Trainer',
                    'Jasa Makeup',
                    'Event Organizer',
                    'Translator',
                    'Jasa Accounting'
                ]),
                'description' => $faker->paragraph(2),
                'price' => $faker->numberBetween(50000, 800000),
                'category' => $faker->randomElement(['kebersihan', 'perbaikan', 'teknologi', 'perawatan', 'transportasi', 'lainnya']),
                'duration_hours' => $faker->numberBetween(1, 8),
                'status' => $faker->randomElement(['tersedia', 'tidak_tersedia']),
            ]);
        }

        $this->command->info('✅ Services seeded successfully with new migration structure!');
    }
}