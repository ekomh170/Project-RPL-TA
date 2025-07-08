<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Urutan seeding sangat penting karena foreign key dependencies
        $this->call([
            // 1. Users harus pertama (karena semua tabel lain bergantung pada users)
            UsersTableSeeder::class,

            // 2. Services (independent table)
            ServicesTableSeeder::class,

            // 3. PenyediaJasa (depends on users)
            PenyediaJasaSeeder::class,

            // 4. JobOrders (depends on users, penyedia_jasa, services)
            JobOrderSeeder::class,

            // 5. Transactions (depends on users, penyedia_jasa, job_orders)
            TransactionsTableSeeder::class,

            // 6. Notifications (depends on users, penyedia_jasa)
            NotificationsTableSeeder::class,

            // 7. Realistic scenario data untuk testing
            RealisticDataSeeder::class,
        ]);

        $this->command->info('✅ Seeding completed with updated database structure!');
        $this->command->info('📊 Database statistics:');
        $this->command->info('   Users: ' . \App\Models\User::count());
        $this->command->info('   Services: ' . \App\Models\Service::count());
        $this->command->info('   Providers: ' . \App\Models\PenyediaJasa::count());
        $this->command->info('   Job Orders: ' . \App\Models\JobOrder::count());
        $this->command->info('   Transactions: ' . \App\Models\Transaction::count());
        $this->command->info('   Notifications: ' . \App\Models\Notification::count());
    }
}
