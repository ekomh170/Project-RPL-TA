<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\JobOrder;

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
        $totalRevenue = JobOrder::sum('harga_penawaran');

        // Ambil data job order terbaru untuk tabel
        $jobOrders = JobOrder::select(
            'id',
            'nama_jasa',
            'nama_pekerja',
            'tanggal_pelaksanaan',
            'waktu',
            'pembayaran',
            'informasi_pembayaran'
        )
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->limit(10)
            ->get();

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
