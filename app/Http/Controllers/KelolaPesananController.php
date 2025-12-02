<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelolaPesanan;
use App\Models\Tagihan;
use Carbon\Carbon;

class KelolaPesananController extends Controller
{
    // =====================================================
    // 1. TAMPILKAN DAFTAR PESANAN
    // =====================================================
    public function kelolaPesanan()
    {
        $pesanan = KelolaPesanan::with('pelanggan', 'paket', 'tagihan')
                    ->orderBy('created_at','desc')
                    ->get();

        return view('superadmin.kelolapesanan', compact('pesanan'));
    }

    // =====================================================
    // 2. TERIMA PESANAN (MENUNGGU SURVEI TEKNISI)
    // =====================================================
    public function terima($id)
    {
        $pesanan = KelolaPesanan::findOrFail($id);

        $pesanan->update([
            'status' => 'diterima',
            'alasan_penolakan' => null
        ]);

        return back()->with('success', 'Pesanan diterima. Menunggu survei teknisi.');
    }

    // =====================================================
    // 3. TOLAK PESANAN
    // =====================================================
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $pesanan = KelolaPesanan::findOrFail($id);

        $pesanan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return back()->with('success', 'Pesanan ditolak.');
    }

    // =====================================================
    // 4. TEKNISI SELESAI SURVEI (ADMIN TAMPILKAN STATUS)
    // =====================================================
    public function laporanTeknisi(Request $request, $id)
    {
        $request->validate([
            'laporan_teknisi' => 'required'
        ]);

        $pesanan = KelolaPesanan::findOrFail($id);

        $pesanan->update([
            'laporan_teknisi' => $request->laporan_teknisi,
            'status' => 'survei_selesai'
        ]);

        return back()->with('success', 'Laporan teknisi telah disimpan.');
    }

    // =====================================================
    // 5. BUAT TAGIHAN (SETELAH SURVEI SELESAI)
    // =====================================================
    public function buatTagihan($pesanan_id)
    {
        $pesanan = KelolaPesanan::findOrFail($pesanan_id);

        // buat tagihan baru
        $tagihan = Tagihan::create([
            'pelanggan_id' => $pesanan->pelanggan_id,
            'paket_id'     => $pesanan->paket_id,
            'nominal'      => $pesanan->paket->harga,
            'status'       => 'menunggu_pembayaran'
        ]);

        // simpan id tagihan di pesanan
        $pesanan->update([
            'tagihan_id' => $tagihan->id,
            'status'     => 'menunggu_pembayaran'
        ]);

        return back()->with('success', 'Tagihan berhasil dibuat.');
    }

    // =====================================================
    // 6. VERIFIKASI PEMBAYARAN (ADMIN)
    // =====================================================
    public function verifikasiPembayaran(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);

        if ($request->status == 'lunas') {
            // tagihan lunas
            $tagihan->update([
                'status' => 'lunas'
            ]);

            // ubah pesanan juga jadi lunas
            $tagihan->pesanan->update([
                'status' => 'lunas'
            ]);

        } else {
            // pembayaran ditolak
            $tagihan->update([
                'status' => 'ditolak',
                'alasan_penolakan' => $request->alasan_penolakan
            ]);
        }

        return back()->with('success', 'Status pembayaran diperbarui!');
    }

    // =====================================================
    // 7. ATUR JADWAL INSTALASI (SETELAH LUNAS)
    // =====================================================
    public function aturJadwal(Request $request, $id)
    {
        $request->validate([
            'jadwal_instalasi' => 'required|date'
        ]);

        $pesanan = KelolaPesanan::findOrFail($id);

        $pesanan->update([
            'jadwal_instalasi' => Carbon::parse($request->jadwal_instalasi),
            'status'           => 'jadwal_instalasi'
        ]);

        return back()->with('success', 'Jadwal instalasi berhasil diatur.');
    }
}
