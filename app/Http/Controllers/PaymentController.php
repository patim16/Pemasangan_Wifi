<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
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
    // REKAP HARIAN & BULANAN (GABUNG)
    // ============================================================
    public function rekapIndex(Request $request)
    {
        $mode = $request->mode ?? 'harian';
        $tanggal = $request->tanggal;
        $bulan   = $request->bulan;

        $data = collect([]);
        $totalPendapatan = 0;

        // ======================= HARIAN =======================
        if ($mode == 'harian' && $tanggal) {
            $data = Transaksi::whereDate('created_at', $tanggal)
                ->with(['pelanggan', 'paket'])
                ->get();

            $totalPendapatan = Transaksi::whereDate('created_at', $tanggal)
                ->where('status', 'terverifikasi')
                ->sum('total');
        }

        // ======================= BULANAN =======================
        if ($mode == 'bulanan' && $bulan) {
            $tahun = substr($bulan, 0, 4);
            $bln   = substr($bulan, 5, 2);

            $data = Transaksi::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bln)
                ->with(['pelanggan', 'paket'])
                ->get();

            $totalPendapatan = Transaksi::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bln)
                ->where('status', 'terverifikasi')
                ->sum('total');
        }

        return view('payment.rekap.index', [
            'mode'            => $mode,
            'tanggal'         => $tanggal,
            'bulan'           => $bulan,
            'data'            => $data,
            'totalPendapatan' => $totalPendapatan,
        ]);
    }

    // ============================================================
    // EXPORT PDF
    // ============================================================
    public function rekapPDF(Request $request)
    {
        $mode = $request->mode;
        $tanggal = $request->tanggal;
        $bulan = $request->bulan;

        $data = collect([]);

        if ($mode == 'harian' && $tanggal) {
            $data = Transaksi::whereDate('created_at', $tanggal)
                ->with(['pelanggan', 'paket'])
                ->get();

            return PDF::loadView('payment.rekap.pdf', [
                'mode' => 'harian',
                'tanggal' => $tanggal,
                'data' => $data
            ])->download('rekap-harian-'.$tanggal.'.pdf');
        }

        if ($mode == 'bulanan' && $bulan) {
            $tahun = substr($bulan, 0, 4);
            $bln   = substr($bulan, 5, 2);

            $data = Transaksi::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bln)
                ->with(['pelanggan', 'paket'])
                ->get();

            return PDF::loadView('payment.rekap.pdf', [
                'mode' => 'bulanan',
                'bulan' => $bulan,
                'data' => $data
            ])->download('rekap-bulanan-'.$bulan.'.pdf');
        }
    }
}
