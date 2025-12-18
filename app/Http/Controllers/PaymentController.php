<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TagihanBulanan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;
use PDF;

class PaymentController extends Controller
{
    public function dashboard()
    {
        $totalHariIni = Transaksi::whereDate('created_at', today())->count();
        $menunggu     = Transaksi::where('status', 'menunggu')->count();
        $valid        = Transaksi::where('status', 'terverifikasi')->count();
        $invalid      = Transaksi::where('status', 'ditolak')->count();

        return view('payment.dashboard', compact(
            'totalHariIni', 'menunggu', 'valid', 'invalid'
        ));
    }

    public function list()
    {
        $data = Transaksi::where('status', 'menunggu')->get();
        return view('payment.list', compact('data'));
    }

    public function detail($id)
    {
        $trx = Transaksi::findOrFail($id);
        return view('payment.detail', compact('trx'));
    }

    public function valid($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'status' => 'terverifikasi',
            'alasan_penolakan' => null
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi (VALID)');
    }

    public function invalid(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan
        ]);

        return back()->with('success', 'Pembayaran ditolak (INVALID)');
    }

    public function statusPage()
    {
        $data = Transaksi::with(['pelanggan', 'paket'])->get();
        return view('payment.status', compact('data'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required']);

        Transaksi::findOrFail($id)->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    // ============================================================
    // REKAP TRANSAKSI
    // ============================================================
    public function rekapIndex(Request $request)
{
    $start = $request->start_date;
    $end   = $request->end_date;

    $data = collect([]);
    $totalPendapatan = 0;

    if ($start && $end) {
        $data = Transaksi::with(['pelanggan', 'paket'])
            ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
            ->orderBy('created_at', 'asc')
            ->get();

        $totalPendapatan = Transaksi::where('status', 'terverifikasi')
            ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
            ->sum('total');
    }

    return view('payment.rekap.index', compact(
        'start', 'end', 'data', 'totalPendapatan'
    ));
}


    public function rekapPDF(Request $request)
{
    $start = $request->start_date;
    $end   = $request->end_date;

    if (!$start || !$end) {
        return back()->with('error', 'Pilih tanggal terlebih dahulu!');
    }

    $data = Transaksi::with(['pelanggan', 'paket'])
        ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
        ->orderBy('created_at', 'asc')
        ->get();

    $totalPendapatan = Transaksi::where('status', 'terverifikasi')
        ->whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])
        ->sum('total');

    $pdf = \PDF::loadView('payment.rekap.pdf', [
        'start' => $start,
        'end'   => $end,
        'data'  => $data,
        'totalPendapatan' => $totalPendapatan,
    ])->setPaper('a4', 'portrait');

    return $pdf->download("Rekap-Transaksi-$start-sampai-$end.pdf");

}
public function exportExcel(Request $request)
{
    $start = $request->start_date;
    $end   = $request->end_date;

    return Excel::download(new RekapExport($start, $end), 'rekap-transaksi.xlsx');
}



    // ============================================================
    // TAGIHAN BULANAN
    // ============================================================
    public function tagihanBulanan()
{
    $tagihan = TagihanBulanan::with(['pelanggan', 'paket'])
                ->orderBy('created_at', 'desc')
                ->get();

    return view('payment.tagihan.bulanan', compact('tagihan'));
}

public function tagihanDetail($id)
{
    $tagihan = TagihanBulanan::with(['pelanggan', 'paket'])->findOrFail($id);

    return view('payment.tagihan.detail', compact('tagihan'));
}

public function tagihanKonfirmasi($id)
{
    $tagihan = TagihanBulanan::findOrFail($id);

    $tagihan->update([
        'status' => 'lunas',
        'tanggal_bayar' => now()
    ]);

    return back()->with('success', 'Tagihan berhasil dikonfirmasi sebagai LUNAS!');
}
public function kirimTagihan($id)
{
    $tagihan = TagihanBulanan::findOrFail($id);

    // Update status jadi "menunggu_verifikasi" atau "dikirim"
    $tagihan->update([
        'status' => 'menunggu_verifikasi'
    ]);

    // TODO: Kirim notif ke pelanggan jika sudah ada fitur notifikasi

    return back()->with('success', 'Tagihan berhasil dikirim ke pelanggan!');
}
// ===============================
// VERIFIKASI TAGIHAN BULANAN
// ===============================
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
        'status' => 'ditolak',
        'alasan_penolakan' => $request->alasan
    ]);

    return back()->with('success', 'Tagihan ditolak');
}




}
