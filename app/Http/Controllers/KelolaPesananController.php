<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaPesananController extends Controller
{
public function kelolaPesanan(Request $request)
{
    $pesanan = Pemesanan::with(['pelanggan', 'paket', 'teknisi'])
        ->paginate(10);

    $teknisi = User::where('role', 'teknisi')->get();

    return view('admin.kelolapesanan', compact('pesanan', 'teknisi'));
}



    public function terima($id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        $pesanan->status = 'pending';
        $pesanan->save();

        return back()->with('success','Pesanan diterima.');
    }

    /** SIMPAN JADWAL SURVEI PERTAMA KALI */
    public function jadwalSurvei(Request $request, $id)
    {
        $request->validate([
            'jadwal_survei' => 'required|date',
            'teknisi_id' => 'required'
        ]);

        $pesanan = Pemesanan::findOrFail($id);
        $pesanan->jadwal_survei = $request->jadwal_survei;
        $pesanan->teknisi_id = $request->teknisi_id;
        $pesanan->status = 'menunggu_survei';
        $pesanan->save();

        return back()->with('success', 'Jadwal survei berhasil disimpan.');
    }

    /** UPDATE JADWAL SURVEI */
    public function updateJadwalSurvei(Request $request, $id)
    {
        $request->validate([
            'jadwal_survei' => 'required|date',
            'teknisi_id' => 'required'
        ]);

        $pesanan = Pemesanan::findOrFail($id);
        $pesanan->jadwal_survei = $request->jadwal_survei;
        $pesanan->teknisi_id = $request->teknisi_id;
        $pesanan->save();

        return back()->with('success', 'Jadwal survei berhasil diupdate!');
    }
public function laporanSurvei(Request $request, $id)
{
    $request->validate([
        'laporan_teknisi' => 'required'
    ]);

    $pesanan = Pemesanan::findOrFail($id);

    // ADMIN HANYA MELIHAT / CATAT
    $pesanan->laporan_teknisi = $request->laporan_teknisi;
    $pesanan->save();

    return back()->with('success','Catatan survei disimpan.');
}


    public function kirimTagihan($id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        $pesanan->status = 'menunggu_pembayaran';
        $pesanan->save();

        return back()->with('success','Tagihan dikirim.');
    }

    public function konfirmasiPembayaran($id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        $pesanan->status = 'lunas';
        $pesanan->save();

        return back()->with('success','Pembayaran diterima.');
    }

    public function jadwalInstalasi(Request $request, $id)
    {
        $request->validate([
            'jadwal_instalasi' => 'required|date'
        ]);

        $pesanan = Pemesanan::findOrFail($id);
        $pesanan->jadwal_instalasi = $request->jadwal_instalasi;
        $pesanan->status = 'jadwal_instalasi';
        $pesanan->save();

        return back()->with('success','Jadwal instalasi diatur.');
    }

    public function instalasiSelesai($id)
    {
        $pesanan = Pemesanan::findOrFail($id);
        $pesanan->status = 'selesai';
        $pesanan->save();

        return back()->with('success','Instalasi selesai.');

    }


   
}