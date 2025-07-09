<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\JobOrder;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PenggunaController extends Controller
{
    /**
     * Tampilkan form login untuk customer/pengguna
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke halaman customer
        if (Auth::check() && Auth::user()->role === 'pengguna') {
            return redirect()->route('customer.index');
        }

        // Data untuk halaman login
        $data = [
            'title' => 'Login Customer - HandyGo',
            'description' => 'Masuk ke akun HandyGo Anda untuk mengakses layanan jasa harian terpercaya',
            'services_count' => Service::count(),
            'active_providers' => User::where('role', 'penyedia_jasa')->count()
        ];

        return view('pengguna.login', $data);
    }

    /**
     * Proses login customer/pengguna
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        // Cek apakah user ada dan role-nya pengguna
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email tidak terdaftar dalam sistem',
            ]);
        }

        if ($user->role !== 'pengguna') {
            throw ValidationException::withMessages([
                'email' => 'Akun ini bukan akun customer. Silakan gunakan login yang sesuai.',
            ]);
        }

        // Attempt login
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah',
            ]);
        }

        // Login berhasil
        Auth::login($user, $request->filled('remember'));

        // Regenerate session untuk security
        $request->session()->regenerate();

        // Buat notifikasi login
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Login Berhasil',
            'message' => 'Selamat datang kembali di HandyGo! Anda berhasil login.',
            'type' => 'informasi',
        ]);

        return redirect()->route('customer.index')->with('success', 'Selamat datang di HandyGo!');
    }

    /**
     * Halaman index customer (beranda)
     */
    public function index()
    {
        $data = [
            'title' => 'HandyGo - Solusi Jasa Harian Terpercaya',
            'description' => 'Platform jasa harian terpercaya untuk berbagai kebutuhan Anda',
            'services' => Service::all(),
            'services_count' => Service::count(),
            'active_providers' => User::where('role', 'penyedia_jasa')->count(),
            'users' => User::all()
        ];

        return view('pengguna.index', $data);
    }

    /**
     * Halaman layanan untuk customer
     */
    public function layanan()
    {
        $data = [
            'title' => 'Layanan - HandyGo',
            'services' => Service::all()
        ];

        return view('pengguna.layanan', $data);
    }

    /**
     * Halaman tentang kami untuk customer
     */
    public function tentangkami()
    {
        $data = [
            'title' => 'Tentang Kami - HandyGo',
        ];

        return view('pengguna.tentangkami', $data);
    }

    /**
     * Halaman history untuk customer
     */
    public function history()
    {
        $user = Auth::user();
        $data = [
            'title' => 'History - HandyGo',
            'orders' => JobOrder::with(['service', 'penyediaJasa.user'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get()
        ];

        return view('pengguna.history', $data);
    }

    /**
     * Halaman pemesanan untuk customer
     */
    public function pemesanan()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Pemesanan - HandyGo',
            'active_orders' => JobOrder::with(['service', 'penyediaJasa.user'])
                ->where('user_id', $user->id)
                ->whereIn('status', ['Pending', 'Diproses', 'Dikerjakan'])
                ->orderBy('created_at', 'desc')
                ->get(),
            'services' => Service::all() // Tambahkan data services untuk form
        ];

        return view('pengguna.pemesanan', $data);
    }

    /**
     * Simpan pesanan baru dari customer
     */
    public function storeOrder(Request $request)
    {
        $user = Auth::user();

        // Validasi input sesuai dengan modal yang sudah diperbarui
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|regex:/^08[0-9]{8,11}$/|max:15',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string|min:10|max:500',
            'tanggal_pelaksanaan' => 'required|date|after:today',
            'waktu_kerja' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:1000',
            'pembayaran' => 'required|in:Cash,Transfer Bank,E-Wallet'
        ], [
            'service_id.required' => 'Pilih layanan terlebih dahulu',
            'service_id.exists' => 'Layanan yang dipilih tidak valid',
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi',
            'nomor_telepon.required' => 'Nomor telepon wajib diisi',
            'nomor_telepon.regex' => 'Format nomor telepon tidak valid (gunakan 08xxxxxxxxxx)',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'alamat.required' => 'Alamat lengkap wajib diisi',
            'alamat.min' => 'Alamat minimal 10 karakter',
            'alamat.max' => 'Alamat maksimal 500 karakter',
            'tanggal_pelaksanaan.required' => 'Tanggal pelaksanaan wajib diisi',
            'tanggal_pelaksanaan.after' => 'Tanggal pelaksanaan minimal H+1 dari hari ini',
            'waktu_kerja.required' => 'Waktu layanan wajib dipilih',
            'deskripsi.max' => 'Catatan maksimal 1000 karakter',
            'pembayaran.required' => 'Metode pembayaran wajib dipilih',
            'pembayaran.in' => 'Metode pembayaran tidak valid'
        ]);

        try {
            // Ambil data service
            $service = Service::findOrFail($request->service_id);

            // Hitung total harga (harga service + biaya admin)
            $adminFee = 5000;
            $totalPrice = $service->harga + $adminFee;

            // Buat job order baru dengan field yang sesuai modal
            $jobOrder = JobOrder::create([
                'user_id' => $user->id,
                'service_id' => $service->id,  // Use service_id instead of nama_jasa
                'harga_penawaran' => $service->harga,
                'total_harga' => $totalPrice,
                'biaya_admin' => $adminFee,
                'nama_pelanggan' => $request->nama_pelanggan,
                'nomor_telepon' => $request->nomor_telepon,
                'email_pelanggan' => $request->email,
                'alamat_pelanggan' => $request->alamat,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
                'waktu_kerja' => $request->waktu_kerja,
                'deskripsi' => $request->deskripsi ?: 'Tidak ada catatan khusus',
                'metode_pembayaran' => $request->pembayaran,
                'pembayaran' => $request->pembayaran, // Untuk backward compatibility
                'status' => 'Pending',
                'informasi_pembayaran' => 'Menunggu konfirmasi penyedia jasa',
                'progress_step' => 1 // Untuk progress tracking
            ]);

            // Buat notifikasi untuk user
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pesanan Berhasil Dibuat',
                'message' => "Pesanan {$service->name} berhasil dibuat dengan total Rp " . number_format($totalPrice, 0, ',', '.') . ". Kami akan mencarikan penyedia jasa terbaik untuk Anda.",
                'type' => 'update_pesanan',
                'data' => json_encode(['job_order_id' => $jobOrder->id]),
            ]);

            // Log aktivitas sistem
            Log::info('New order created', [
                'user_id' => $user->id,
                'order_id' => $jobOrder->id,
                'service' => $service->nama_jasa,
                'total_price' => $totalPrice,
                'payment_method' => $request->pembayaran
            ]);

            return redirect()->route('customer.pemesanan')
                ->with('success', 'Pesanan berhasil dibuat! Total pembayaran: Rp ' . number_format($totalPrice, 0, ',', '.') . '. Kami akan segera mencarikan penyedia jasa terbaik untuk Anda.');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Order creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi atau hubungi customer service.');
        }
    }

    /**
     * Halaman payment untuk customer
     */
    public function payment()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Payment - HandyGo',
            'services' => Service::all(),
            'user_address' => $user ? $user->address : ''
        ];

        return view('pengguna.payment', $data);
    }

    /**
     * Proses pembayaran dari form payment
     */
    public function storePayment(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string|max:500',
            'service_date' => 'required|date',
            'service_time' => 'required',
            'payment_method' => 'required|in:cash,transfer,ewallet',
        ]);

        $service = Service::findOrFail($request->service_id);
        $adminFee = 5000;
        $finalPrice = $service->price + $adminFee;

        $order = JobOrder::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'description' => $request->special_notes,
            'address' => $request->customer_address,
            'customer_phone' => $request->customer_phone,
            'status' => 'Pending',
            'base_price' => $service->price,
            'final_price' => $finalPrice,
            'scheduled_at' => $request->service_date . ' ' . $request->service_time,
        ]);

        // Notifikasi pembayaran
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Pembayaran Berhasil',
            'message' => 'Pembayaran untuk layanan ' . $service->name . ' berhasil. Total: Rp. ' . number_format($finalPrice, 0, ',', '.'),
            'type' => 'berhasil',
            'data' => json_encode(['job_order_id' => $order->id]),
        ]);

        return redirect()->route('pemesanan')->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }

    /**
     * Logout customer/pengguna
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Buat notifikasi logout
        if ($user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Logout Berhasil',
                'message' => 'Anda telah berhasil logout dari HandyGo. Terima kasih!',
                'type' => 'informasi',
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Tampilkan profil customer
     */
    public function profile()
    {
        $user = Auth::user();

        $data = [
            'title' => 'Profil Saya - HandyGo',
            'user' => $user,
            'total_orders' => JobOrder::where('user_id', $user->id)->count(),
            'completed_orders' => JobOrder::where('user_id', $user->id)
                ->where('status', 'Selesai')->count(),
            'member_since' => $user->created_at->diffForHumans()
        ];

        return view('pengguna.profile', $data);
    }

    /**
     * Update profil customer
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed'
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan pengguna lain',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        // Update menggunakan User model
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        User::where('id', $user->id)->update($userData);

        // Notifikasi update profil
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Profil Diperbarui',
            'message' => 'Profil Anda telah berhasil diperbarui.',
            'type' => 'berhasil',
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update progress pesanan
     */
    public function updateOrderProgress(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'progress_step' => 'required|integer|min:1|max:4',
            'status' => 'required|string'
        ]);

        $order = JobOrder::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $order->updateProgress($request->progress_step, $request->status);

        // Buat notifikasi update progress
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Update Progress Pesanan',
            'message' => "Status pesanan {$order->service->name} telah diperbarui menjadi: {$request->status}",
            'type' => 'update_pesanan',
            'data' => json_encode(['job_order_id' => $order->id]),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Progress pesanan berhasil diperbarui',
            'order' => $order->fresh()
        ]);
    }

    /**
     * Batalkan pesanan
     */
    public function cancelOrder(Request $request, $id)
    {
        $user = Auth::user();

        $order = JobOrder::where('id', $id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['Pending', 'Diproses'])
            ->firstOrFail();

        $order->update([
            'status' => 'Dibatalkan',
            'progress_step' => 0,
            'informasi_pembayaran' => 'Pesanan dibatalkan oleh customer'
        ]);

        // Buat notifikasi pembatalan
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Pesanan Dibatalkan',
            'message' => "Pesanan {$order->service->name} telah berhasil dibatalkan.",
            'type' => 'update_pesanan',
            'data' => json_encode(['job_order_id' => $order->id]),
        ]);

        return redirect()->route('customer.pemesanan')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Detail pesanan untuk customer
     */
    public function orderDetail($id)
    {
        $user = Auth::user();

        $order = JobOrder::with(['service', 'penyediaJasa.user'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $data = [
            'title' => 'Detail Pesanan - HandyGo',
            'order' => $order
        ];

        return view('pengguna.order-detail', $data);
    }
}
