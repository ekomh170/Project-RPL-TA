<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\JobOrder;
use App\Models\User;
use Faker\Factory as Faker;

class TransactionsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil job orders yang sudah ada
        $jobOrders = JobOrder::all();

        if ($jobOrders->isEmpty()) {
            $this->command->error('❌ No JobOrders found. Please run JobOrderSeeder first.');
            return;
        }

        // Buat transaksi untuk setiap job order
        foreach ($jobOrders as $jobOrder) {
            // Tentukan status transaksi berdasarkan status job order
            $transactionStatus = match ($jobOrder->status) {
                'menunggu' => 'menunggu',
                'diterima' => $faker->randomElement(['menunggu', 'lunas']),
                'dikerjakan' => 'lunas',
                'selesai' => 'lunas',
                'dibatalkan' => $faker->randomElement(['gagal', 'dikembalikan']),
                default => 'menunggu'
            };

            // Hitung amount dan total
            $amount = $jobOrder->final_price;
            $adminFee = $jobOrder->admin_fee;
            $totalAmount = $amount + $adminFee;

            // Payment details dan references untuk yang sudah lunas
            $paymentDetails = null;
            $paymentReference = null;
            $paidAt = null;
            $expiredAt = null;

            if ($transactionStatus === 'lunas') {
                $paidAt = $faker->dateTimeBetween($jobOrder->created_at, 'now');
                $paymentReference = 'PAY-' . strtoupper($faker->bothify('??##??##'));
                $paymentDetails = [
                    'gateway' => 'midtrans',
                    'transaction_id' => $faker->uuid,
                    'payment_type' => $faker->randomElement(['bank_transfer', 'credit_card', 'gopay', 'shopeepay'])
                ];
            } elseif ($transactionStatus === 'menunggu') {
                $expiredAt = now()->addHours(24); // 24 jam untuk bayar
            }

            Transaction::create([
                'job_order_id' => $jobOrder->id,
                'user_id' => $jobOrder->user_id,
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'total_amount' => $totalAmount,
                'payment_method' => $faker->randomElement(['tunai', 'transfer_bank', 'dompet_digital', 'qris']),
                'status' => $transactionStatus,
                'paid_at' => $paidAt,
                'expired_at' => $expiredAt,
                'payment_details' => $paymentDetails,
                'payment_reference' => $paymentReference,
                'created_at' => $jobOrder->created_at,
            ]);
        }

        // Buat beberapa transaksi tambahan untuk testing edge cases
        $this->generateTestTransactions($faker);

        $this->command->info('✅ Transactions seeded successfully with new migration structure!');
    }

    private function generateTestTransactions($faker)
    {
        $users = User::where('role', 'pengguna')->limit(3)->get();
        $completedOrders = JobOrder::where('status', 'selesai')->limit(2)->get();

        // Transaksi kadaluarsa
        if ($completedOrders->isNotEmpty()) {
            Transaction::create([
                'job_order_id' => $completedOrders->first()->id,
                'user_id' => $completedOrders->first()->user_id,
                'amount' => 100000,
                'admin_fee' => 5000,
                'total_amount' => 105000,
                'payment_method' => 'transfer_bank',
                'status' => 'kadaluarsa',
                'expired_at' => now()->subDays(1),
                'created_at' => now()->subDays(2),
            ]);
        }

        // Transaksi gagal
        if ($completedOrders->count() > 1) {
            Transaction::create([
                'job_order_id' => $completedOrders->last()->id,
                'user_id' => $completedOrders->last()->user_id,
                'amount' => 150000,
                'admin_fee' => 5000,
                'total_amount' => 155000,
                'payment_method' => 'dompet_digital',
                'status' => 'gagal',
                'payment_details' => [
                    'failure_reason' => 'Insufficient balance',
                    'error_code' => 'INSUFFICIENT_FUNDS'
                ],
                'created_at' => now()->subDays(1),
            ]);
        }
    }
}
