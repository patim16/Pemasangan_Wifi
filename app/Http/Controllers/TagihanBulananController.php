<?php

namespace App\Http\Controllers;

use App\Models\TagihanBulanan;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagihanBulananController extends Controller
{
    // Generate otomatis setiap bulan
    public function generateTagihan()
    {
        $pelanggan = Pelanggan::with('paket')->get();

        foreach ($pelanggan as $p) {
            $tanggalDaftar = Carbon::parse($p->created_at)->day;

            if ($tanggalDaftar <= 10) $jatuh = 7;
            elseif ($tanggalDaftar <= 20) $jatuh = 17;
            else $jatuh = 27;

            TagihanBulanan::create([
                'pelanggan_id' => $p->id,
                'paket_id'     => $p->paket_id,
                'bulan'        => Carbon::now()->format('Y-m'),
                'nominal'      => $p->paket->harga,
                'jatuh_tempo'  => $jatuh,
                'status'       => 'belum bayar'
            ]);
        }

        return "BERHASIL GENERATE TAGIHAN BULANAN!";
    }
    public function index()
{
    $data = TagihanBulanan::with(['pelanggan', 'paket'])
        ->orderBy('id', 'desc')
        ->get();

    return view('payment.tagihan.index', compact('data'));
}

public function detail($id)
{
    $tagihan = TagihanBulanan::findOrFail($id);
    return view('payment.tagihan.detail', compact('tagihan'));
}

public function valid($id)
{
    $tagihan = TagihanBulanan::findOrFail($id);
    $tagihan->update([
        'status' => 'lunas',
        'tanggal_bayar' => now(),
        'alasan_penolakan' => null
    ]);

    return back()->with('success', 'Tagihan bulanan berhasil diverifikasi!');
}

public function invalid(Request $request, $id)
{
    $request->validate(['alasan' => 'required']);

    $tagihan = TagihanBulanan::findOrFail($id);
    $tagihan->update([
        'status' => 'ditolak',
        'alasan_penolakan' => $request->alasan
    ]);

    return back()->with('success', 'Tagihan bulanan ditolak!');
}

}
