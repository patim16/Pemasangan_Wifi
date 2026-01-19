<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\User;
use App\Models\tagihan;
use Illuminate\Http\Request;
use App\Models\TagihanBulanan;
use Carbon\Carbon;
use App\Models\Transaksi;


class KelolaPesananController extends Controller
{
public function kelolaPesanan(Request $request)
{
    $pesanan = Pemesanan::with(['pelanggan', 'paket', 'teknisi'])
        ->paginate(20);

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
    $pesanan = Pemesanan::with('paket')->findOrFail($id);

    // cegah double tagihan
    if (Tagihan::where('pesanan_id', $pesanan->id)->exists()) {
        return back()->with('warning', 'Tagihan sudah pernah dibuat.');
    }

    // 🔥 HITUNG TOTAL YANG BENAR
    $harga = $pesanan->paket->harga ?? 0;
    $biayaPemasangan = $pesanan->paket->biaya_pemasangan ?? 0;

    $total = $harga + $biayaPemasangan;

    // 🔐 SIMPAN TOTAL KE PESANAN (INI PENTING)
    $pesanan->update([
        'total_bayar' => $total,
        'status'      => 'menunggu_pembayaran',
    ]);

    // BUAT TAGIHAN
    Tagihan::create([
        'pesanan_id'   => $pesanan->id,
        'pelanggan_id' => $pesanan->pelanggan_id,
        'paket_id'     => $pesanan->paket_id,
        'nominal'      => $total,
        'status'       => 'menunggu_pembayaran',
    ]);

    return back()->with('success', 'Tagihan berhasil dibuat & dikirim.');
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
        'jadwal_instalasi' => 'required|date',
        'teknisi_id'       => 'required|exists:users,id',
    ]);

    $pesanan = Pemesanan::findOrFail($id);

    $pesanan->jadwal_instalasi = $request->jadwal_instalasi;
    $pesanan->teknisi_id       = $request->teknisi_id; // 🔥 INI YANG KURANG
    $pesanan->status           = 'jadwal_instalasi';
    $pesanan->save();

    return back()->with('success', 'Jadwal instalasi dikirim ke teknisi');
}




   public function instalasiSelesai($id)
{
    $pesanan = Pemesanan::with(['paket', 'pelanggan'])->findOrFail($id);

    // update status pesanan
    $pesanan->status = 'selesai';
    $pesanan->save();

    // 🔒 CEK BIAR TIDAK DOUBLE TAGIHAN BULANAN
  $bulan = now()->format('Y-m');

$pelangganId = $pesanan->pelanggan_id ?? ($pesanan->pelanggan->id ?? null);

if (!$pelangganId) {
    return back()->with('error', 'Gagal membuat tagihan bulanan: pelanggan tidak ditemukan.');
}

// tanggal instalasi (fallback ke today jika kosong)
$tanggalInstalasi = $pesanan->jadwal_instalasi ?? now();

$day = \Carbon\Carbon::parse($tanggalInstalasi)->day;

// tentukan tanggal jatuh tempo
if ($day >= 1 && $day <= 10) {
    $jatuhTempoTanggal = 7;
} elseif ($day >= 11 && $day <= 20) {
    $jatuhTempoTanggal = 17;
} else {
    $jatuhTempoTanggal = 27;
}

// jatuh tempo = bulan berikutnya + tanggal aturan
$jatuhTempo = \Carbon\Carbon::parse($tanggalInstalasi)
    ->addMonthNoOverflow()
    ->day($jatuhTempoTanggal);

// cegah double tagihan
$sudahAda = TagihanBulanan::where('pelanggan_id', $pelangganId)
    ->where('bulan', $bulan)
    ->exists();

if (!$sudahAda) {

    TagihanBulanan::create([
        'pelanggan_id' => $pelangganId,
        'paket_id'     => $pesanan->paket_id,
        'bulan'        => $bulan,
        'tanggal_pesan' => now()->toDateString(),
        'nominal'      => $pesanan->paket->harga ?? 0,
        'jatuh_tempo'  => $jatuhTempo,
        'status'       => 'belum bayar',
    ]);
}

///////

    return back()->with('success','Instalasi selesai & tagihan bulanan dibuat.');
}


public function deletePesanan($id)
{
    $pesanan = Pemesanan::findOrFail($id);

   


    // Jika ada relasi instalasi / transaksi (opsional)
    if ($pesanan->instalasi) {
        $pesanan->instalasi()->delete();
    }

    $pesanan->delete();

    return back()->with('success', 'Pesanan berhasil dihapus');
}

public function show($id)
{
    // ambil 1 pesanan
    $pesananSingle = Pemesanan::with(['pelanggan','paket','teknisi'])
        ->findOrFail($id);

    // UBAH jadi collection + paginator palsu
    $pesanan = new \Illuminate\Pagination\LengthAwarePaginator(
        collect([$pesananSingle]),
        1,
        20,
        1,
        ['path' => request()->url()]
    );

    $teknisi = User::where('role', 'teknisi')->get();

    return view('admin.kelolapesanan', compact('pesanan','teknisi'));
}

public function index()
{
    $pesanan = Pemesanan::with(['pelanggan', 'paket', 'teknisi'])
        ->paginate(20);

    $teknisi = User::where('role', 'teknisi')->get();

    return view('admin.kelolapesanan', compact('pesanan', 'teknisi'));
}
   
}