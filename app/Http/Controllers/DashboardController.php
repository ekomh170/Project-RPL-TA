<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobOrder;
use App\Models\Service;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Statistik untuk dashboard
        $totalUsers = User::count();
        $totalJobOrders = JobOrder::count();
        $totalServices = Service::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('amount'); // Jika transaksi memiliki field 'amount'

        // Return view dengan data
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalJobOrders',
            'totalServices',
            'totalTransactions',
            'totalRevenue'
        ));
    }
}
