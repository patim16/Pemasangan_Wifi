<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

use App\Models\PaketLayanan;
use App\Models\MetodePembayaran;
use Carbon\Carbon;

class UserController extends Controller
{
    /* =========================
       DASHBOARD PER ROLE
    ========================== */

   public function superAdminDashboard()
{
    // =====================
    // USER STATISTIC
    // =====================
    $totalAdmin     = User::where('role', 'admin')->count();
    $totalPelanggan = User::where('role', 'pelanggan')->count();
    $totalTeknisi   = User::where('role', 'teknisi')->count();

    // =====================
    // PENGHASILAN BULAN INI
    // =====================
    $totalPenghasilan = Transaksi::where('status', 'lunas')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total');

    // =====================
    // STATUS PESANAN
    // =====================
    $orderStats = Pemesanan::select('status')
        ->selectRaw('count(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $totalOrders = Pemesanan::count();

    // =====================
    // PAKET TERPOPULER
    // =====================
    $popularPackages = PaketLayanan::withCount('pemesanan')
        ->orderBy('pemesanan_count', 'desc')
        ->take(5)
        ->get()
        ->map(function ($paket) use ($totalPelanggan) {
            return [
                'name' => $paket->nama,
                'count' => $paket->pemesanan_count,
                'percentage' => $totalPelanggan > 0
                    ? round(($paket->pemesanan_count / $totalPelanggan) * 100)
                    : 0
            ];
        });

    // =====================
    // METODE PEMBAYARAN
    // =====================
    $paymentMethods = MetodePembayaran::withCount('transaksi')
        ->get()
        ->map(function ($method) {
            return [
                'name' => $method->nama,
                'count' => $method->transaksi_count,
                'percentage' => 0
            ];
        });

    // =====================
    // AKTIVITAS TERBARU (DUMMY AMAN)
    // =====================
    $recentActivities = [
        [
            'title' => 'Pelanggan baru mendaftar',
            'user'  => 'Sistem',
            'time'  => 'Baru saja',
            'icon'  => 'user-plus',
            'color' => 'success'
        ],
        [
            'title' => 'Pesanan diverifikasi',
            'user'  => 'Admin',
            'time'  => '10 menit lalu',
            'icon'  => 'check-circle',
            'color' => 'primary'
        ],
    ];

    // =====================
    // LOG SISTEM (DUMMY)
    // =====================
    $systemLogs = [
        [
            'message' => 'Sistem berjalan normal',
            'level'   => 'info',
            'time'    => 'Hari ini'
        ]
    ];

    return view('superadmin.dashboard', compact(
        'totalAdmin',
        'totalPelanggan',
        'totalTeknisi',
        'totalPenghasilan',
        'popularPackages',
        'paymentMethods',
        'orderStats',
        'totalOrders',
        'recentActivities',
        'systemLogs'
    ));
}

   public function adminDashboard()
{
    // =====================
    // TOTAL DATA
    // =====================
    $totalPelanggan = User::where('role', 'pelanggan')->count();
    $totalTeknisi   = User::where('role', 'teknisi')->count();

    // =====================
    // PENDAPATAN BULAN INI
    // =====================
   $totalPenghasilan = Transaksi::where('status', 'lunas')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total');

    // =====================
    // PAYMENT
    // =====================
    $paymentPending = Transaksi::where('status', 'menunggu')->count();
    $totalPayment   = Transaksi::count();

    // =====================
    // PESANAN
    // =====================
    $totalOrders = Pemesanan::count();

    $newOrders = Pemesanan::with(['pelanggan', 'paket'])
        ->latest()
        ->limit(5)
        ->get();

    // =====================
    // STATISTIK STATUS PESANAN
    // =====================
    $orderStats = Pemesanan::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    // =====================
    // GRAFIK 6 BULAN TERAKHIR (SAMA DENGAN PAYMENT)
    // =====================
    $last6Months = [];
    $revenueData = [];

    for ($i = 5; $i >= 0; $i--) {
        $month = now()->subMonths($i);

        // label bulan
        $last6Months[] = $month->format('M');

        // pendapatan per bulan (VALID SAJA)
        $revenueData[] = Transaksi::where('status', 'lunas')
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->sum('total');
    }

    // =====================
    // AKTIVITAS TERBARU (DUMMY)
    // =====================
    $recentActivities = [
        [
            'title' => 'Pesanan baru masuk',
            'time'  => 'Baru saja',
            'icon'  => 'shopping-cart',
            'color' => 'primary'
        ],
        [
            'title' => 'Pembayaran diverifikasi',
            'time'  => '10 menit lalu',
            'icon'  => 'check-circle',
            'color' => 'success'
        ],
        [
            'title' => 'Teknisi menyelesaikan instalasi',
            'time'  => '1 jam lalu',
            'icon'  => 'tools',
            'color' => 'info'
        ],
    ];

    // =====================
    // TEKNISI TERBAIK
    // =====================
    $topTechnicians = User::where('role', 'teknisi')
        ->withCount([
            'pemesanan as completed' => function ($q) {
                $q->where('status', 'selesai');
            }
        ])
        ->orderByDesc('completed')
        ->limit(3)
        ->get()
        ->map(function ($t) {
            return [
                'name'      => $t->nama,
                'completed' => $t->completed,
                'rating'    => rand(45, 50) / 10
            ];
        });

    return view('admin.dashboard', compact(
        'totalPelanggan',
        'totalTeknisi',
        'totalPenghasilan',
        'paymentPending',
        'totalPayment',
        'totalOrders',
        'newOrders',
        'orderStats',
        'last6Months',
        'revenueData',
        'recentActivities',
        'topTechnicians'
    ));
}




    public function teknisiDashboard()
    {
        return view('teknisi.dashboard');
    }

    public function pelangganDashboard()
    {
        return view('pelanggan.dashboard');
    }

    /* =========================
       KELOLA ADMIN
    ========================== */

    public function indexAdmin(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $admins = $query->paginate(20)->withQueryString();
        return view('superadmin.kelolaadmin', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'admin',
        ]);

        return back()->with('success', 'Admin berhasil ditambahkan');
    }

    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        User::findOrFail($id)->update(
            $request->only('nama','email','no_hp','alamat')
        );

        return back()->with('success', 'Admin berhasil diperbarui');
    }

    public function deleteAdmin($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Admin berhasil dihapus');
    }

    /* =========================
       KELOLA TEKNISI
    ========================== */

    public function indexTeknisi(Request $request)
    {
        $query = User::where('role', 'teknisi');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }

        $teknisis = $query->paginate(20)->withQueryString();
        return view('superadmin.kelolateknisi', compact('teknisis'));
    }

    public function storeTeknisi(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'teknisi',
        ]);

        return back()->with('success', 'Teknisi berhasil ditambahkan');
    }

    public function updateTeknisi(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        User::findOrFail($id)->update(
            $request->only('nama','email','no_hp','alamat')
        );

        return back()->with('success', 'Teknisi berhasil diperbarui');
    }

    public function deleteTeknisi($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Teknisi berhasil dihapus');
    }

    /* =========================
       KELOLA PAYMENT
    ========================== */

    public function indexPayment(Request $request)
    {
        $query = User::where('role', 'payment');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }

        $payments = $query->paginate(20)->withQueryString();
        return view('superadmin.kelolapayment', compact('payments'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'payment',
        ]);

        return back()->with('success', 'Payment staff berhasil ditambahkan');
    }

    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        User::findOrFail($id)->update(
            $request->only('nama','email','no_hp','alamat')
        );

        return back()->with('success', 'Payment staff berhasil diperbarui');
    }

    public function deletePayment($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Payment staff berhasil dihapus');
    }

    /* =========================
       KELOLA PELANGGAN
    ========================== */

    public function indexPelanggan(Request $request)
    {
        $query = User::where('role', 'pelanggan');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }

        $pelanggans = $query->paginate(20)->withQueryString();
        return view('superadmin.kelolapelanggan', compact('pelanggans'));
    }

    public function terimaPelanggan($id)
    {
        User::findOrFail($id)->update([
            'status' => 'accepted',
            'alasan_penolakan' => null
        ]);

        return back()->with('success', 'Pelanggan diterima!');
    }

    public function tolakPelanggan(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required'
        ]);

        User::findOrFail($id)->update([
            'status' => 'rejected',
            'alasan_penolakan' => $request->alasan
        ]);

        return back()->with('success', 'Pelanggan ditolak.');
    }
    
    public function deletePelanggan($id)
{
    User::findOrFail($id)->delete();

    return back()->with('success', 'Pelanggan berhasil dihapus');
}

public function updatePelanggan(Request $request, $id)
{
    $request->validate([
        'nama'   => 'required',
        'email'  => 'required|email',
        'no_hp'  => 'required',
        'alamat' => 'required',
    ]);

    $user = User::findOrFail($id);

    // update data dasar
    $user->update([
        'nama'   => $request->nama,
        'email'  => $request->email,
        'no_hp'  => $request->no_hp,
        'alamat' => $request->alamat,
    ]);

    // jika upload foto KTP baru
    if ($request->hasFile('foto_ktp')) {

       
        $path = $request->file('foto_ktp')->store('ktp');
        $user->update(['foto_ktp' => $path]);
    }

    return back()->with('success', 'Data pelanggan berhasil diperbarui');
}




}