<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();

        /* ================= STATISTIK ================= */
        $totalHariIni = Transaksi::whereDate('created_at', $today)->count();

        $menunggu = Transaksi::where('status', 'menunggu_verifikasi')->count();
        $lunas    = Transaksi::where('status', 'lunas')->count();
        $ditolak  = Transaksi::where('status', 'ditolak')->count();

        /* ================= PENDAPATAN ================= */
        $pendapatanHariIni = Transaksi::where('status', 'lunas')
            ->whereDate('created_at', $today)
            ->sum('total');

        $pendapatanBulanan = Transaksi::where('status', 'lunas')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        /* ================= TRANSAKSI TERBARU ================= */
        $recentTransactions = Transaksi::with('pelanggan')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        /* ================= GRAFIK 6 BULAN ================= */
        $last6Months = [];
        $revenueData = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);

            $last6Months[] = $bulan->translatedFormat('M');

            $revenueData[] = Transaksi::where('status', 'lunas')
                ->whereYear('created_at', $bulan->year)
                ->whereMonth('created_at', $bulan->month)
                ->sum('total');
        }

        return view('payment.dashboard', compact(
            'totalHariIni',
            'menunggu',
            'lunas',
            'ditolak',
            'pendapatanHariIni',
            'pendapatanBulanan',
            'recentTransactions',
            'last6Months',
            'revenueData'
        ));
    }
}
