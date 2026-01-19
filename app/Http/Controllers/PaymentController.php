<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TagihanBulanan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;
use PDF;
use App\Models\Pemesanan;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;


class PaymentController extends Controller
{
public function dashboard()
{
    // ================= STATISTIK DASAR =================
    $totalHariIni = Transaksi::whereDate('created_at', today())->count();

    $menunggu = Transaksi::where('status', 'menunggu')->count();

    $valid = Transaksi::where('status', 'lunas')->count();

    $invalid = Transaksi::where('status', 'ditolak')->count();


    // ================= PENDAPATAN =================
    $pendapatanHariIni = Transaksi::whereDate('created_at', today())
        ->where('status', 'lunas')
        ->sum('total');

    $pendapatanBulanan = Transaksi::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->where('status', 'lunas')
        ->sum('total');

    $pendapatanAwal = Transaksi::where('jenis', 'awal')
        ->where('status', 'lunas')
        ->sum('total');


    // ================= TRANSAKSI TERBARU =================
    $recentTransactions = Transaksi::with('pelanggan')
        ->where('status', 'lunas')
        ->latest()
        ->take(5)
        ->get();


    // ================= GRAFIK 6 BULAN TERAKHIR =================
    $last6Months = [];
    $revenueData = [];

    for ($i = 5; $i >= 0; $i--) {
        $bulan = Carbon::now()->subMonths($i);

        // label bulan
        $last6Months[] = $bulan->translatedFormat('M');

        // pendapatan per bulan (FINAL: lunas only)
        $revenueData[] = Transaksi::whereYear('created_at', $bulan->year)
            ->whereMonth('created_at', $bulan->month)
            ->where('status', 'lunas')
            ->sum('total');
    }


    // ================= METODE PEMBAYARAN (AMAN DUMMY) =================
    $paymentMethods = [
        [
            'name' => 'Transfer',
            'count' => Transaksi::where('status', 'lunas')->count(),
            'total' => $pendapatanBulanan,
            'percentage' => 100
        ]
    ];


    return view('payment.dashboard', compact(
        'totalHariIni',
        'menunggu',
        'valid',
        'invalid',
        'pendapatanHariIni',
        'pendapatanBulanan',
        'pendapatanAwal',
        'recentTransactions',
        'last6Months',
        'revenueData',
        'paymentMethods'
    ));
}

    public function list()
{
    // TAGIHAN AWAL YANG BENAR-BENAR MENUNGGU
    $tagihanAwal = Tagihan::with(['pelanggan','paket'])
        ->whereIn('status', ['pending','menunggu','menunggu_verifikasi'])
        ->get()
        ->map(function($t){
            $t->jenis = 'awal';
            $t->bukti = $t->bukti_pembayaran;
            return $t;
        });

    // TAGIHAN BULANAN
    $tagihanBulanan = TagihanBulanan::with(['pelanggan','paket'])
        ->where('status', 'menunggu_verifikasi')
        ->get()
        ->map(function($t){
            $t->jenis = 'bulanan';
            $t->bukti = $t->bukti_pembayaran;
            return $t;
        });

    // GABUNGKAN
 $data = $tagihanAwal->concat($tagihanBulanan)
    ->sortByDesc('created_at')
    ->values();

// PAGINATION MANUAL
$page = request()->get('page', 1);
$perPage = 10; // jumlah item per halaman
$paginatedData = new LengthAwarePaginator(
    $data->forPage($page, $perPage), // ambil item sesuai page
    $data->count(), // total item
    $perPage,
    $page,
    ['path' => request()->url(), 'query' => request()->query()]
);

return view('payment.list', ['data' => $paginatedData]);
}


    public function detail($id)
    {
        $trx = Transaksi::findOrFail($id);
        return view('payment.detail', compact('trx'));
    }

    public function valid($id)
{
    $tagihan = Tagihan::with(['pesanan','paket'])->findOrFail($id);

    $tagihan->update([
        'status' => 'lunas',
        'alasan_penolakan' => null
    ]);

    // ✅ UPDATE PESANAN
    if ($tagihan->pesanan) {
        $tagihan->pesanan->update([
            'status' => 'siap_instalasi'
        ]);
    }

    // 🔥 UPDATE TRANSAKSI TOTAL (INI YANG KURANG)
    Transaksi::where('pelanggan_id', $tagihan->pelanggan_id)
        ->where('paket_id', $tagihan->paket_id)
        ->where('jenis', 'awal')
        ->update([
            'status' => 'lunas',
            'total'  => $tagihan->nominal // ⬅️ PAKAI TOTAL + BIAYA PASANG
        ]);

    return back()->with('success', 'Pembayaran diterima & pesanan siap instalasi');
}


    public function invalid(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $tagihan = Tagihan::findOrFail($id);

        $tagihan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return back()->with('success', 'Pembayaran berhasil ditolak');
    }

    public function invalidBulanan(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $tagihan = TagihanBulanan::findOrFail($id);

        $tagihan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return back()->with('success', 'Pembayaran berhasil ditolak');
    }

    // ================= TAGIHAN BULANAN =================

   public function tagihanBulanan()
{
    $data = TagihanBulanan::with(['pelanggan','paket'])
        ->orderBy('created_at', 'desc')
        ->get();

    // untuk tampilan utama
    $bulanan = $data;

    return view('payment.tagihan.bulanan', compact('data','bulanan'));
}
    public function tagihanDetail($id)
    {
        $tagihan = TagihanBulanan::with(['pelanggan', 'paket'])
            ->findOrFail($id);

        return view('payment.tagihan.detail', compact('tagihan'));
    }

    // pelanggan upload bukti
    public function tagihanKonfirmasi(Request $request, $id)
    {
        $tagihan = TagihanBulanan::findOrFail($id);

        $request->validate([
            'bukti_pembayaran' => 'required|image|max:2048'
        ]);

        $path = $request->file('bukti_pembayaran')
            ->store('bukti_pembayaran', 'public');

      // 🔥 GENERATE INVOICE KALAU BELUM ADA
    if (!$tagihan->invoice_code) {
        $tagihan->invoice_code = 'INV-BLN-' . now()->format('Ym') . '-' . str_pad($tagihan->id, 4, '0', STR_PAD_LEFT);
    }


        $tagihan->update([
            'bukti_pembayaran' => $path,
            'status' => 'menunggu_verifikasi'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload');
    }

    // admin kirim tagihan → status awal
    public function kirimTagihan($id)
    {
        $tagihan = TagihanBulanan::findOrFail($id);

        $tagihan->update([
            'status' => 'belum_bayar'
        ]);

        return back()->with(
            'success',
            'Tagihan bulanan berhasil dikirim ke pelanggan'
        );
    }

    public function verifikasiTagihanIndex()
    {
        $data = TagihanBulanan::with(['pelanggan','paket'])
            ->where('status', 'menunggu_verifikasi')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('payment.tagihan.verifikasi', compact('data'));
    }

    public function verifikasiTagihanTerima($id)
    {
        TagihanBulanan::findOrFail($id)->update([
            'status' => 'lunas',
            'tanggal_bayar' => now()
        ]);

        return back()->with('success', 'Tagihan berhasil diverifikasi');
    }

    public function verifikasiTagihanTolak(Request $request, $id)
    {
        $request->validate(['alasan' => 'required']);

        TagihanBulanan::findOrFail($id)->update([
            'status' => 'belum_bayar',
            'alasan_penolakan' => $request->alasan
        ]);

        return back()->with('success', 'Tagihan ditolak');
    }

    // ================= TAGIHAN AWAL =================

    public function tagihanAwal()
    {
        $pesanan = Pemesanan::with(['pelanggan','paket'])
            ->where('status', 'menunggu_tagihan_awal')
            ->get();

        $bulanan = TagihanBulanan::with(['pelanggan','paket'])
            ->orderBy('id', 'desc')
            ->get();

        return view('payment.tagihan.awal', compact('pesanan','bulanan'));
    }

    public function kirimTagihanAwal($id)
{
    $pemesanan = Pemesanan::with('paket')->findOrFail($id);

    $total =
        ($pemesanan->paket->harga ?? 0)
      + ($pemesanan->paket->biaya_pemasangan ?? 0);

    Tagihan::create([
        'pesanan_id'   => $pemesanan->id,
        'pelanggan_id' => $pemesanan->user_id,
        'paket_id'     => $pemesanan->paket_id,
        'nominal'      => $total, // ✅ 299000 + 20000
        'status'       => 'pending',
    ]);

    $pemesanan->update([
        'status' => 'menunggu_pembayaran_awal',
        'total_bayar' => $total // 🔥 INI PENTING
    ]);

    return back()->with('success', 'Tagihan awal berhasil dikirim ke pelanggan');
}



    public function verifikasiPembayaran()
    {
        $data = Tagihan::with(['pelanggan','paket','metodePembayaran'])
            ->where('status', 'menunggu')
            ->orderBy('created_at','desc')
            ->paginate(20);

        return view('admin.verifikasi.tagihan', compact('data'));
    }

    public function approve($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        $tagihan->update([
            'status' => 'diterima'
        ]);

        Transaksi::where('pelanggan_id', $tagihan->pelanggan_id)
            ->where('paket_id', $tagihan->paket_id)
            ->whereIn('status', ['menunggu','terverifikasi'])
            ->update(['status' => 'lunas']);

        return back()->with('success','Pembayaran berhasil diverifikasi');
    }

    public function verifikasiBulananTerima($id)
{
    $tagihan = TagihanBulanan::findOrFail($id);

    // 1️⃣ update status tagihan bulanan
    $tagihan->update([
        'status' => 'lunas',
        'tanggal_bayar' => now(),
        'alasan_penolakan' => null
    ]);

    // 2️⃣ update transaksi terkait (PENTING)
    Transaksi::where('pelanggan_id', $tagihan->pelanggan_id)
        ->where('paket_id', $tagihan->paket_id)
        ->where('jenis', 'tagihan_bulanan')
        ->where('status', 'menunggu')
        ->update([
            'status' => 'lunas'
        ]);

    return back()->with('success', 'Pembayaran bulanan berhasil diverifikasi');
}


    public function verifikasiBulananTolak(Request $request, $id)
{
    $request->validate([
        'alasan_penolakan' => 'required'
    ]);

    $tagihan = TagihanBulanan::findOrFail($id);

    $tagihan->update([
        'status' => 'ditolak',
        'alasan_penolakan' => $request->alasan_penolakan
    ]);

    return back()->with('success', 'Pembayaran bulanan ditolak & dikembalikan ke pelanggan.');
}


public function rekapIndex(Request $request)
{
    $start = $request->start_date;
    $end   = $request->end_date;

    // ================= BASE QUERY =================
    $baseQuery = Transaksi::where('transaksis.status', 'lunas');

    if ($start && $end) {
        $baseQuery->whereBetween('transaksis.created_at', [
            $start . ' 00:00:00',
            $end . ' 23:59:59'
        ]);
    }

    // ================= DATA TRANSAKSI =================
    $data = $baseQuery
        ->with(['pelanggan','paket','metodePembayaran'])
        ->orderBy('transaksis.created_at','desc')
        ->get();

    // ================= TOTAL PENDAPATAN =================
    $totalPendapatan = $data->sum('total');

    // ================= REKAP METODE PEMBAYARAN =================
    $paymentMethods = Transaksi::where('transaksis.status', 'lunas')
        ->when($start && $end, function ($q) use ($start, $end) {
            $q->whereBetween('transaksis.created_at', [
                $start.' 00:00:00',
                $end.' 23:59:59'
            ]);
        })
        ->join('metode_pembayaran', 'transaksis.metode_pembayaran_id', '=', 'metode_pembayaran.id')
        ->select(
            'metode_pembayaran.nama_metode as name',
            DB::raw('COUNT(transaksis.id) as count'),
            DB::raw('SUM(transaksis.total) as total')
        )
        ->groupBy('metode_pembayaran.nama_metode')
        ->get();

    // ================= PERSENTASE =================
    $grandTotal = $paymentMethods->sum('total');

    $paymentMethods = $paymentMethods->map(function ($item) use ($grandTotal) {
        $item->percentage = $grandTotal > 0
            ? round(($item->total / $grandTotal) * 100)
            : 0;
        return $item;
    });

    // ================= REKAP KHUSUS DANA & SEABANK =================
    $paymentDana = Transaksi::where('transaksis.status', 'lunas')
        ->join('metode_pembayaran', 'transaksis.metode_pembayaran_id', '=', 'metode_pembayaran.id')
        ->where('metode_pembayaran.nama_metode', 'Dana')
        ->when($start && $end, function ($q) use ($start, $end) {
            $q->whereBetween('transaksis.created_at', [
                $start.' 00:00:00',
                $end.' 23:59:59'
            ]);
        })
        ->select(
            DB::raw('COUNT(transaksis.id) as count'),
            DB::raw('SUM(transaksis.total) as total')
        )
        ->first();

    $paymentSeaBank = Transaksi::where('transaksis.status', 'lunas')
        ->join('metode_pembayaran', 'transaksis.metode_pembayaran_id', '=', 'metode_pembayaran.id')
        ->where('metode_pembayaran.nama_metode', 'SeaBank')
        ->when($start && $end, function ($q) use ($start, $end) {
            $q->whereBetween('transaksis.created_at', [
                $start.' 00:00:00',
                $end.' 23:59:59'
            ]);
        })
        ->select(
            DB::raw('COUNT(transaksis.id) as count'),
            DB::raw('SUM(transaksis.total) as total')
        )
        ->first();

    // ================= RETURN VIEW =================
    return view('payment.rekap.index', compact(
        'data',
        'start',
        'end',
        'totalPendapatan',
        'paymentMethods',
        'paymentDana',
        'paymentSeaBank'
    ));
}



public function rekapPDF(Request $request)
{
    $start = $request->start_date 
        ? Carbon::parse($request->start_date)->startOfDay() 
        : Transaksi::min('created_at');
    $end   = $request->end_date 
        ? Carbon::parse($request->end_date)->endOfDay() 
        : Transaksi::max('created_at');

    // ================= DATA TRANSAKSI =================
    $data = Transaksi::with(['pelanggan','paket','metodePembayaran'])
        ->where('status', 'lunas')
        ->whereBetween('created_at', [$start, $end])
        ->orderBy('created_at', 'desc')
        ->get();

    // ================= TOTAL PENDAPATAN =================
    $totalPendapatan = $data->sum('total');

    // ================= REKAP METODE PEMBAYARAN =================
    $paymentMethods = Transaksi::where('transaksis.status', 'lunas')
    ->whereBetween('transaksis.created_at', [$start, $end])
    ->join('metode_pembayaran', 'transaksis.metode_pembayaran_id', '=', 'metode_pembayaran.id')
    ->select(
        'metode_pembayaran.nama_metode as name',
        DB::raw('COUNT(transaksis.id) as count'),
        DB::raw('SUM(transaksis.total) as total')
    )
    ->groupBy('metode_pembayaran.nama_metode')
    ->get();


    // ================= HITUNG PERSENTASE =================
    $grandTotal = $paymentMethods->sum('total');
    $paymentMethods = $paymentMethods->map(function($item) use ($grandTotal) {
        $item->percentage = $grandTotal > 0 ? round(($item->total / $grandTotal) * 100) : 0;
        return $item;
    });

    // ================= GENERATE PDF =================
    $pdf = PDF::loadView('payment.rekap.pdf', compact(
        'data',
        'start',
        'end',
        'totalPendapatan',
        'paymentMethods'  // kirim ke blade
    ))->setPaper('a4', 'landscape');

    return $pdf->download('rekap-pembayaran.pdf');
}



public function exportPdf(Request $request)
{
    $start = $request->start;
    $end   = $request->end;

    $data = Transaksi::whereBetween('created_at', [$start, $end])->get();

    return Pdf::loadView('payment.export_pdf', compact(
        'data',
        'start',
        'end'
    ))->download('laporan-payment.pdf');
}
public function exportExcel(Request $request)
{
    $start = Carbon::parse($request->start_date)->startOfDay();
    $end   = Carbon::parse($request->end_date)->endOfDay();

    return Excel::download(new RekapExport($start, $end), 'rekap-pembayaran.xlsx');
}




}
