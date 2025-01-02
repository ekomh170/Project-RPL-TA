<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    public function index()
    {
        $jobOrders = JobOrder::all();
        return view('admin.jobOrders.index', compact('jobOrders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pembayaran' => 'required|string',
            'nama_pekerja' => 'required|string',
            'waktu_kerja' => 'required|string',
            'nama_jasa' => 'required|string',
            'harga_penawaran' => 'required|numeric',
            'tanggal_pelaksanaan' => 'required|date',
        ]);

        JobOrder::create($validated);

        return redirect()->back()->with('success', 'Job order created successfully.');
    }

    public function destroy($id)
    {
        $jobOrder = JobOrder::findOrFail($id);
        $jobOrder->delete();

        return redirect()->back()->with('success', 'Job order deleted successfully.');
    }
}
