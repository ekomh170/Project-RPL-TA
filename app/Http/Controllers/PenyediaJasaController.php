<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use App\Models\PenyediaJasa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenyediaJasaController extends Controller
{
    public function index () {
        $user = Auth::user();
        $allPekerja = PenyediaJasa::all();

        if($user->role === 'admin') {
            return view('penyediajasa.admin', compact('allPekerja'));
        };

        $penyediajasa = PenyediaJasa::where('user_id', $user->id)->get();
        $penyediajasa1 = PenyediaJasa::where('user_id', $user->id)->first();
        $jobOrders = JobOrder::where('nama_pekerja', $penyediajasa1->id)->get();




        return view('penyediajasa.index', compact('penyediajasa','jobOrders','penyediajasa1'));
    }
    public function index2 () {
        $user = Auth::user();
        $penyediajasa = PenyediaJasa::where('user_id', $user->id)->get();
        $penyediajasa1 = PenyediaJasa::where('user_id', $user->id)->first();
        $jobOrders = JobOrder::where('nama_pekerja', $penyediajasa1->id)->get();




        return view('penyediajasa.transaksi', compact('penyediajasa','jobOrders','penyediajasa1'));
    }
    public function index3 () {
        $user = Auth::user();
        $penyediajasa = PenyediaJasa::where('user_id', $user->id)->get();
        $penyediajasa1 = PenyediaJasa::where('user_id', $user->id)->first();
        $jobOrders = JobOrder::where('nama_pekerja', $penyediajasa1->id)->get();




        return view('penyediajasa.history', compact('penyediajasa','jobOrders','penyediajasa1'));
    }
    public function index4 () {
        $user = Auth::user();
        $penyediajasa1 = PenyediaJasa::where('user_id', $user->id)->get();

        return view('penyediajasa.informasipribadi', compact('penyediajasa1'));
    }

    public function store(Request $request) {
        


        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'telpon' => 'required',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto', 'public'); 
            }
        
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'penyedia_jasa',
            ]); 

        PenyediaJasa::create([
            'nama' => $request->nama,
            'user_id' => $user->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telpon' => $request->telpon,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('penyediajasa');

    }
    public function update(Request $request, PenyediaJasa $penyediaJasa) {
        
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'telpon' => 'required',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto', 'public'); 
            }
        
            $penyediaJasa->user->update([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]); 


        $penyediaJasa->update([
            'nama' => $request->nama,
            'user_id' => $user->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telpon' => $request->telpon,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('penyediajasa');

    }


    public function show($penyediajasa)
    {
        $pekerja = PenyediaJasa::findOrFail($penyediajasa)->get();
        $jobOrders = JobOrder::where('nama_pekerja', $penyediajasa)->paginate(5);

        return view('penyediajasa.detail', compact('pekerja', 'jobOrders'));
    }

    public function destroy(PenyediaJasa $penyediaJasa) {
        $penyediaJasa->delete();
        return redirect()->route('penyediajasa');
    }
}
