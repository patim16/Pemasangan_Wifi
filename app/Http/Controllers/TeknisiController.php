<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instalasi;
use App\Models\KelolaPesanan;
use App\Models\Pemesanan;
use App\Models\Survei;
use App\Models\Pemasangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TagihanBulanan;
use Carbon\Carbon;

class TeknisiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
  public function dashboard()
{
    $teknisiId = Auth::id();

    // =============================
    // KPI
    // =============================
  $jadwalSurveiHariIni = Pemesanan::where('teknisi_id', $teknisiId)
    ->whereDate('jadwal_survei', today())
    ->where('status','menunggu_survei')
    ->count();

   $jadwalInstalasiHariIni = Pemesanan::where('teknisi_id', $teknisiId)
    ->whereDate('jadwal_instalasi', today())
    ->whereIn('status',['jadwal_instalasi','siap_instalasi'])
    ->count();


    $tugasSelesai = Pemesanan::where('teknisi_id', $teknisiId)
        ->where('status', 'selesai')
        ->whereMonth('updated_at', now()->month)
        ->count();

    $totalTugasBulanIni = Pemesanan::where('teknisi_id', $teknisiId)
        ->whereMonth('created_at', now()->month)
        ->count();

    $tugasDalamProses = Pemesanan::where('teknisi_id', $teknisiId)
        ->whereIn('status', [
            'menunggu_survei',
            'jadwal_survei',
            'survei_selesai',
            'jadwal_instalasi'
        ])
        ->count();

    // =============================
    // Jadwal Hari Ini (TABLE)
    // =============================
   $todaySchedules = Pemesanan::with('pelanggan')
    ->where('teknisi_id', $teknisiId)
    ->where(function ($q) {
        $q->whereDate('jadwal_survei', today())
          ->orWhereDate('jadwal_instalasi', today());
    })
    ->get()
    ->map(function ($p) {
        if ($p->jadwal_survei && Carbon::parse($p->jadwal_survei)->isToday()) {
            $p->jenis = 'survei';
            $p->jadwal = $p->jadwal_survei;
        } else {
            $p->jenis = 'instalasi';
            $p->jadwal = $p->jadwal_instalasi;
        }
        return $p;
    });


    // =============================
    // Chart 7 Hari
    // =============================
    $last7Days = collect(range(6, 0))->map(function ($i) {
        return now()->subDays($i)->translatedFormat('D');
    });

    $completionData = collect(range(6, 0))->map(function ($i) use ($teknisiId) {
        return Pemesanan::where('teknisi_id', $teknisiId)
            ->where('status', 'selesai')
            ->whereDate('updated_at', now()->subDays($i))
            ->count();
    });

    $avgCompletionRate = round($completionData->avg() ?? 0);

    // =============================
    // Riwayat Terbaru
    // =============================
    $recentJobs = Pemesanan::with('pelanggan')
        ->where('teknisi_id', $teknisiId)
        ->latest()
        ->limit(5)
        ->get();

    return view('teknisi.dashboard', compact(
        'jadwalSurveiHariIni',
        'jadwalInstalasiHariIni',
        'tugasSelesai',
        'tugasDalamProses',
        'totalTugasBulanIni',
        'todaySchedules',
        'last7Days',
        'completionData',
        'avgCompletionRate',
        'recentJobs'
    ));
}


    /*
    |--------------------------------------------------------------------------
    | JADWAL SURVEI (FIX UTAMA)
    |--------------------------------------------------------------------------
    */
 public function jadwalSurvei()
{
    $pesanan = Pemesanan::with(['pelanggan','paket'])
        ->where('status', 'jadwal_survei')
        ->paginate(20);

    return view('teknisi.jadwal-survei', compact('pesanan'));
}

 public function jadwalSurveyTeknisi()
{
    $teknisi = Auth::user();

    if (!$teknisi || $teknisi->role !== 'teknisi') {
        abort(403, 'Session teknisi tidak ditemukan');
    }

    $pesanan = Pemesanan::with(['pelanggan', 'paket'])
        ->where('teknisi_id', $teknisi->id)
        ->whereNotNull('jadwal_survei')
        ->orderBy('jadwal_survei', 'asc')
        ->paginate(20);

    return view('teknisi.jadwal-survei', compact('pesanan'));
}



    /*
    |--------------------------------------------------------------------------
    | DETAIL SURVEI
    |--------------------------------------------------------------------------
    */
  public function detailSurvei($id)
{
    // LIST (biar header & table aman)
    $pesanan = Pemesanan::with(['pelanggan','paket'])
        ->where('teknisi_id', Auth::id())
        ->whereNotNull('jadwal_survei')
        ->orderBy('jadwal_survei','asc')
        ->paginate(20);

    // DETAIL (untuk modal / panel detail)
    $detail = Pemesanan::with(['pelanggan','paket'])
        ->where('id', $id)
        ->where('teknisi_id', Auth::id())
        ->firstOrFail();

    return view('teknisi.jadwal-survei', compact('pesanan','detail'));
}


    /*
    |--------------------------------------------------------------------------
    | FORM SURVEI
    |--------------------------------------------------------------------------
    */
    public function formSurvei($id)
    {
        $data = Pemesanan::findOrFail($id);
        return view('teknisi.form-survei', compact('data'));
    }

    

    /*
    |--------------------------------------------------------------------------
    | JADWAL PEMASANGAN
    |--------------------------------------------------------------------------
    */
 public function jadwalPemasangan()
{
    $teknisiId = session('user.id');

    if (!$teknisiId) {
        abort(403, 'Teknisi belum login');
    }

    $pemasangan = Pemesanan::with(['pelanggan', 'paket'])
        ->where('teknisi_id', $teknisiId)
        ->where('status', 'jadwal_instalasi')
        ->whereNotNull('jadwal_instalasi')
        ->orderBy('jadwal_instalasi', 'asc')
        ->get();

    return view('teknisi.jadwal-pemasangan', compact('pemasangan'));
}




    /*
    |--------------------------------------------------------------------------
    | DETAIL PEMASANGAN
    |--------------------------------------------------------------------------
    */
 public function detailPemasangan($id)
{
    $teknisiId = session('user.id');

    $pemasangan = Pemesanan::where('id', $id)
        ->where('teknisi_id', $teknisiId)
        ->firstOrFail();

    return view('teknisi.detail-pemasangan', compact('pemasangan'));
}


    //LAPORAN

      // tampilkan jadwal survei teknisi
    public function formLaporan()
    {
        $pesanan = Pemesanan::where('teknisi_id', Auth::id())
            ->where('status', 'menunggu_survei')
            ->get();

        return view('teknisi.kirim-laporan', compact('pesanan'));
    }

    // simpan laporan
public function kirimLaporanPemasangan(Request $request)
{
    $request->validate([
        'pemesanan_id'     => 'required|exists:pemesanan,id',
        'hasil'            => 'required|in:diterima,ditolak',
        'alasan_penolakan' => 'nullable|string'
    ]);

    // 🔥 pastikan paket ikut diload
    $pesanan = Pemesanan::with('paket')->findOrFail($request->pemesanan_id);

    if ($request->hasil === 'diterima') {

        // ================= FIX UTAMA =================
        // pastikan paket ADA dan harga TIDAK NULL
        if ($pesanan->paket && $pesanan->paket->harga > 0) {
           $pesanan->total_bayar = 
    ($pesanan->paket->harga ?? 0)
  + ($pesanan->paket->biaya_pemasangan ?? 0);

        } else {
            // safety net biar gak pernah 0 lagi
            return back()->with('error', 'Harga paket tidak ditemukan, hubungi admin');
        }
        // ============================================

        $pesanan->status = 'menunggu_tagihan_awal';
        $pesanan->laporan_teknisi = 'Survei diterima';
        $pesanan->alasan_penolakan = null;

    } else {

        $pesanan->status = 'ditolak_survei';
        $pesanan->laporan_teknisi = 'Survei ditolak';
        $pesanan->alasan_penolakan = $request->alasan_penolakan;
    }

    $pesanan->save();

    return back()->with('success', 'Laporan survei berhasil dikirim');
}




    /*
    |--------------------------------------------------------------------------
    | STATUS INSTALASI
    |--------------------------------------------------------------------------
    */
    public function updateStatus()
    {
        $instalasi = Instalasi::where('teknisi_id', Auth::id())
            ->latest()
            ->get();

        return view('teknisi.update-status', compact('instalasi'));
    }

    public function updateStatusSubmit(Request $request)
    {
        $request->validate([
            'instalasi_id' => 'required|exists:instalasi,id',
            'status'       => 'required|string|max:50'
        ]);

        $instalasi = Instalasi::findOrFail($request->instalasi_id);
        $instalasi->status = $request->status;
        $instalasi->save();

        return back()->with('success', 'Status instalasi berhasil diperbarui!');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL INSTALASI
    |--------------------------------------------------------------------------
    */
    public function detailInstalasi($id)
    {
        $instalasi = Instalasi::findOrFail($id);
        return view('teknisi.detail-instalasi', compact('instalasi'));
    }

public function selesaiInstalasi($id)
{
    $pesanan = Pemesanan::with(['paket'])
        ->where('id', $id)
        ->where('teknisi_id', Auth::id())
        ->firstOrFail();

    DB::transaction(function () use ($pesanan) {

        // 1️⃣ Update status pemesanan
        $pesanan->update([
            'status' => 'selesai'
        ]);

        // 2️⃣ BUAT TAGIHAN BULANAN (INI KUNCI 🔥)
        TagihanBulanan::firstOrCreate(
            [
                'pelanggan_id' => $pesanan->user_id,
                'bulan'        => Carbon::now()->format('Y-m'),
            ],
            [
                'paket_id'    => $pesanan->paket_id,
                'nominal'     => $pesanan->paket->harga,
                'jatuh_tempo' => Carbon::now()->addDays(10),
                'status'      => 'belum_bayar',
            ]
        );

    });

    return back()->with('success', 'Instalasi selesai & tagihan bulanan berhasil dibuat');
}


public function riwayatInstalasi()
{
    $riwayat = Pemesanan::with(['pelanggan', 'paket'])
        ->where('teknisi_id', Auth::id())
        ->where('status', 'selesai')
        ->orderBy('updated_at', 'desc')
        ->paginate(20);

    return view('teknisi.riwayat-instalasi', compact('riwayat'));
}

    
}
