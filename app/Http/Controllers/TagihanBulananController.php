<?php

namespace App\Http\Controllers;

use App\Models\TagihanBulanan;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pemesanan;

class TagihanBulananController extends Controller
{

    // GENERATE TAGIHAN BULANAN OTOMATIS
    // GENERATE TAGIHAN BULANAN OTOMATIS
public function generate()
{
    $pesanan = Pemesanan::where('status', 'selesai')->get();

    foreach ($pesanan as $p) {

        $exists = TagihanBulanan::where('pelanggan_id', $p->user_id)
            ->where('bulan', now()->format('Y-m'))
            ->exists();

        if ($exists) continue;

        TagihanBulanan::create([
            'invoice_code'   => 'INV-BLN-' . now()->format('Ym') . '-' . str_pad($p->user_id, 4, '0', STR_PAD_LEFT),
            'pelanggan_id'   => $p->user_id,
            'paket_id'       => $p->paket_id,
            'bulan'          => now()->format('Y-m'),
            'tanggal_pesan'  => $p->created_at,
            'nominal'        => $p->total_bayar,
            'jatuh_tempo'    => now()->addDays(10),
            'status'         => 'belum bayar',
        ]);
    }

    return redirect()->route('payment.tagihan.bulanan')
        ->with('success', 'Tagihan bulanan berhasil digenerate');
}

    // HALAMAN DAFTAR TAGIHAN BULANAN
    public function index()
    {
        $data = TagihanBulanan::with(['pelanggan', 'paket'])
            ->orderBy('id', 'desc')
            ->get();

        // Mengubah property bulan menjadi format "Bulan Tahun" untuk ditampilkan di view
        foreach ($data as $t) {
            if ($t->bulan) {
                $t->bulan_formatted = Carbon::parse($t->bulan . '-01')->translatedFormat('F Y');
            } else {
                $t->bulan_formatted = '-';
            }
        }

        return view('payment.tagihan.bulanan', compact('data'));
    }


    // DETAIL TAGIHAN BULANAN
    public function detail($id)
    {
        $tagihan = TagihanBulanan::findOrFail($id);
        return view('payment.tagihan.detail', compact('tagihan'));
    }


    // KONFIRMASI TAGIHAN LUNAS
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


    // TOLAK TAGIHAN
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


    // KIRIM TAGIHAN KE PELANGGAN
    public function kirim($id)
    {
        $tagihan = TagihanBulanan::findOrFail($id);

        if ($tagihan->status == 'pending') {
            $tagihan->update([
                'status' => 'dikirim'
            ]);

            // TODO: Bisa tambah notifikasi ke pelanggan jika nanti ada fitur
            return back()->with('success', 'Tagihan berhasil dikirim ke pelanggan!');
        }

        return back()->with('error', 'Tagihan sudah dikirim atau sudah dibayar.');
    }



    // FORM UPLOAD BUKTI PEMBAYARAN
public function uploadBukti(Request $request, $id)
{
    $request->validate([
        'bukti_pembayaran' => 'required|image|mimes:png,jpg,jpeg|max:2048'
    ]);

    $tagihan = TagihanBulanan::findOrFail($id);

    $path = $request->file('bukti_pembayaran')
        ->store('bukti_pembayaran', 'public');

    $tagihan->bukti_pembayaran = $path;
    $tagihan->status = 'menunggu_verifikasi';
    $tagihan->save();

    return back()->with('success', 'Bukti pembayaran berhasil diupload');
}


// SIMPAN BUKTI PEMBAYARAN
public function storeUpload(Request $request, $id)
{
    $request->validate([
        'bukti_pembayaran' => 'required|image|max:2048'
    ]);

    $tagihan = TagihanBulanan::findOrFail($id);

    // simpan file ke storage
    $path = $request->file('bukti_pembayaran')
        ->store('bukti-tagihan-bulanan', 'public');

    // update database
    $tagihan->update([
        'bukti_pembayaran' => $path,
        'status' => 'menunggu_verifikasi',
        'tanggal_bayar' => now()
    ]);

    return redirect()
        ->route('pelanggan.tagihan')
        ->with('success', 'Bukti pembayaran berhasil dikirim, menunggu verifikasi admin');
}

}
