<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobOrder;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view with statistics and job order details.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Statistik untuk dashboard
        $totalUsers = User::count(); // Total semua pengguna
        $totalMitra = User::where('role', 'penyedia_jasa')->count(); // Total pengguna dengan role penyedia jasa
        $totalJobOrders = JobOrder::count(); // Total pesanan pekerjaan
        $totalCompleted = Transaction::where('status', 'completed')->count(); // Total transaksi yang selesai

        // Total pendapatan (jika transaksi memiliki kolom 'harga_penawaran' pada job_orders)
        $totalRevenue = JobOrder::sum('harga_penawaran'); // Menghitung total pendapatan berdasarkan harga penawaran

        // Ambil data job order terbaru untuk tabel dengan eager loading
        $jobOrders = JobOrder::with(['user', 'penyediaJasa']) // Eager load relasi user dan penyedia jasa
            ->select(
                'id',
                'nama_jasa',
                'nama_pekerja',
                'tanggal_pelaksanaan',
                'waktu_kerja',
                'pembayaran',
                'informasi_pembayaran',
                'status' // Pastikan status juga diambil
            )
            ->orderBy('tanggal_pelaksanaan', 'desc') // Mengurutkan berdasarkan tanggal pelaksanaan
            ->limit(10) // Ambil 10 job order terbaru
            ->get();

        // \dd($jobOrders);

        // Return view dengan data
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalMitra',
            'totalJobOrders',
            'totalCompleted',
            'totalRevenue',
            'jobOrders'
        ));
    }
}
