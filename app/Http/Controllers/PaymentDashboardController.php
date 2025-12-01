<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;

class PaymentDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        return view('payment.dashboard', [
            'totalHariIni' => Transaksi::whereDate('created_at', $today)->count(),
            'menunggu' => Transaksi::where('status', 'menunggu')->count(),
            'terverifikasi' => Transaksi::where('status', 'terverifikasi')->count(),
            'ditolak' => Transaksi::where('status', 'ditolak')->count(),
            'pendapatanHariIni' => Transaksi::where('status', 'terverifikasi')
                ->whereDate('created_at', $today)
                ->sum('total'),
        ]);
    }
}
