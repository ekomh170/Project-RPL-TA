<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use App\Models\PenyediaJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOrderController extends Controller
{
    public function index()
    {
        $jobOrders = JobOrder::all();
        $pekerja = PenyediaJasa::all();
        return view('admin.jobOrders.index', compact('jobOrders', 'pekerja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembayaran' => 'required|string',
            'nama_pekerja' => 'required|exists:penyedia_jasa,id',  // Validasi untuk memastikan id pekerja valid
            'waktu_kerja' => 'required|string',
            'nama_jasa' => 'required|string',
            'harga_penawaran' => 'required|numeric',
            'tanggal_pelaksanaan' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',  
            'deskripsi' => 'required|string',  
            'status' => 'required|in:Setuju,Batal',  
            'nomor_telepon' => 'nullable|string|max:15',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            // Simpan file ke dalam storage
            $buktiPath = $request->file('bukti')->store('bukti_images', 'public');
        }

        $data = [
            'pembayaran' => $request->pembayaran,
            'informasi_pembayaran' => $request->informasi_pembayaran ?? 'informasi pembayaran masih kosong!',
            'nama_pekerja' => $request->nama_pekerja,
            'waktu_kerja' => $request->waktu_kerja,
            'nama_jasa' => $request->nama_jasa,
            'harga_penawaran' => $request->harga_penawaran,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'waktu' => $request->waktu_kerja,  
            'gender' => $request->gender,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'nomor_telepon' => $request->nomor_telepon,
            'bukti' => $buktiPath,
            'user_id' => $user->id,
        ];

        JobOrder::create($data);

        return redirect()->back()->with('success', 'Job order created successfully.');
    }


    public function destroy($id)
    {
        $jobOrder = JobOrder::findOrFail($id);
        $jobOrder->delete();

        return redirect()->back()->with('success', 'Job order deleted successfully.');
    }
}
