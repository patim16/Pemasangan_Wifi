<?php

namespace App\Http\Controllers;
use App\Models\Pemesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\PaketLayanan;
use App\Models\Tagihan;
use App\Models\MetodePembayaran;
use App\Models\TagihanBulanan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;





class PelangganController extends Controller
{
//dahsboard pelanggan
public function dashboard()
    {
        $userId = session('user')->id;

        // ===============================
        // 1. Ambil pesanan aktif (yang sudah selesai instalasi)
        // ===============================
        $activeOrder = Pemesanan::where('user_id', $userId)
            ->where('status', 'selesai')
            ->orderByDesc('jadwal_instalasi')
            ->first();

        // Default nilai
        $activeSince = null;
        $nextBillDate = null;
        $paket = null;

        if ($activeOrder) {
            $paket = $activeOrder->paket;

            if ($activeOrder->jadwal_instalasi) {
                $activeSince = Carbon::parse($activeOrder->jadwal_instalasi);
                $nextBillDate = $activeSince->copy()->addMonth();
            }
        }

        // ===============================
        // 2. Ambil transaksi milik pelanggan ini
        // ===============================
        $transaksi = Transaksi::where('pelanggan_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        // ===============================
        // 3. Cari transaksi tagihan bulan aktif
        // ===============================
        $currentBill = null;

        if ($nextBillDate) {
          $currentBill = null;

if ($activeOrder) {
    $currentBill = TagihanBulanan::where('pelanggan_id', $userId)
        ->where('bulan', now()->format('Y-m'))
        ->latest()
        ->first();
}


        }

        $notifikasi = Pemesanan::with('paket')
    ->where('user_id', $userId)
    ->whereIn('status', ['jadwal_instalasi', 'selesai'])
    ->orderBy('updated_at', 'desc')
    ->get();


        return view('pelanggan.dashboard', compact(
            'activeOrder',
            'activeSince',
            'nextBillDate',
            'paket',
            'transaksi',
            'currentBill',
         'notifikasi'
        ));

        
    }

//pilih paket
    public function pilihPaket()
{
    $pakets = PaketLayanan::all();
    return view('pelanggan.paket.pilih-paket', compact('pakets'));
}

//detail paket
 public function detailPaket($id)
{
    $paket = PaketLayanan::findOrFail($id);

    return view('pelanggan.paket.detail', compact('paket'));
}

  //pilih jadwal
public function pilihJadwal($id)
{
    return view('pelanggan.paket.jadwal', ['paket_id' => $id]);
}

//simpan jadwal
public function simpanJadwal(Request $request, $id)
{
    // validasi
    $request->validate([
        'tanggal' => 'required|date',
        'jam' => 'required|string',
    ]);

    // simpan sementara ke session dulu (belum ke database)
    session([
        'pesanan' => [
            'paket_id' => $id,
            'tanggal' => $request->tanggal,
            'jam'     => $request->jam,
        ]
    ]);

 // lanjut ke halaman input data
 
    return redirect()->route('pelanggan.inputdata', $id);
}
public function inputData($id)
{
    return view('pelanggan.paket.input-data', ['paket_id' => $id]);
}
public function simpanInputData(Request $request, $paket_id)
{
    $validated = $request->validate([
        'alamat' => 'required|string',
        'patokan' => 'nullable|string',
        'catatan' => 'nullable|string',
        'latitude' => 'required',
        'longitude' => 'required',
    ]);

    // Simpan data ke session atau database (sementara pakai session dulu)
    session([
        'input_data' => [
            'paket_id' => $paket_id,
            'alamat' => $validated['alamat'],
            'patokan' => $validated['patokan'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]
    ]);

    return redirect()->route('pelanggan.invoice', $paket_id);
}
          //invoice
public function invoice($paket_id)
{
    // ambil data dari session
    $data = session('input_data');

    if (!$data) {
        return redirect()
            ->route('pelanggan.pesanwifi')
            ->with('error', 'Data pemesanan tidak ditemukan.');
    }

    // ambil paket
    $paket = PaketLayanan::findOrFail($paket_id);

    return view('pelanggan.paket.invoice', compact('data', 'paket'));
}

     //konfirmasi pemesanan
public function konfirmasiPemesanan($paket_id)
{
    $data = session('input_data');

    if (!$data) {
        return back()->with('error', 'Data pemesanan tidak ditemukan');
    }

    // ✅ AMBIL DATA PAKET DARI DATABASE
    $paket = PaketLayanan::findOrFail($paket_id);

    // Generate Invoice Code
    $invoice = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

    Pemesanan::create([
       'user_id' => session('user')->id,

        'paket_id'     => $paket->id,
        'alamat'       => $data['alamat'],
        'patokan'      => $data['patokan'],
        'catatan'      => $data['catatan'],
        'latitude'     => $data['latitude'],
        'longitude'    => $data['longitude'],
        'invoice_code' => $invoice,

        // 🔥 INI YANG BENAR
        'total_bayar'  => $paket->harga,

        'status'       => 'pending',
    ]);

    session()->forget('input_data');

    return redirect()->route('pelanggan.riwayat')
        ->with('success', 'Pemesanan berhasil dibuat!');
}

    // riwayat pemesana
    public function riwayat()
{
    // Ambil data dari database
    $riwayat = Pemesanan::where('user_id', session('user')->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

    return view('pelanggan.paket.riwayat', compact('riwayat'));
}
   //cetak invoice
 public function cetakInvoice($id)
{
    $pesanan = Pemesanan::with(['paket', 'user'])
        ->where('id', $id)
        ->where('user_id',session('user')->id)
        ->firstOrFail();

    return view('pelanggan.paket.invoice_detail', compact('pesanan'));
}

public function tagihanAwal()
{
    $userId = session('user')->id;

    $tagihan = Tagihan::with(['pelanggan', 'paket'])
        ->where('pelanggan_id', $userId)
        ->select(
            'id',
            'pelanggan_id',   // WAJIB untuk relasi
            'paket_id',       // WAJIB untuk relasi
            'invoice_code',
            'nominal',
            'status',
            'bukti_pembayaran',
            DB::raw("'awal' as jenis_tagihan"),
            DB::raw('NULL as bulan'),
            DB::raw('NULL as jatuh_tempo')
        )
        ->get();

    return view('pelanggan.paket.tagihan', compact('tagihan'));
}


public function tagihan()
{
    $userId = session('user')->id;

    // TAGIHAN AWAL
   $awal = Tagihan::with(['pelanggan','paket'])
    ->where('pelanggan_id', $userId)
    ->select(
        'id',
        'pelanggan_id', // 🔥 WAJIB
        'paket_id',  // 🔥 WAJIB
        'invoice_code',   
        'nominal',
        'status',
        'bukti_pembayaran',
        DB::raw("'awal' as jenis_tagihan"),
        DB::raw('NULL as bulan'),
        DB::raw('NULL as jatuh_tempo')
    )
    ->get();


$bulanan = TagihanBulanan::with(['pelanggan','paket'])
    ->where('pelanggan_id', $userId)
    ->select(
        'id',
        'pelanggan_id', // 🔥
        'paket_id',     // 🔥
        'nominal',
        'status',
        'bukti_pembayaran',
        DB::raw("'bulanan' as jenis_tagihan"),
        'bulan',
        'jatuh_tempo'
    )
    ->get()
    ->map(function($t){
        $t->invoice_code = 'INV-BLN-' . str_pad($t->id, 4, '0', STR_PAD_LEFT);
        return $t;
    });


$tagihan = $awal->merge($bulanan);

    return view('pelanggan.paket.tagihan', compact('tagihan'));
}


public function formBayar($id)
{
    $user = session('user');
    if (!$user) abort(403);

    $tagihan = Tagihan::find($id)
        ?? TagihanBulanan::find($id);

    if (!$tagihan) abort(404);

    if ($tagihan->pelanggan_id != $user->id) {
        abort(403);
    }

    return view('pelanggan.tagihan.bayar', compact('tagihan'));
}


public function formBayarTagihanAwal(Tagihan $tagihan)
{
    $user = session('user');

    if ($tagihan->pelanggan_id != $user->id) {
        abort(403);
    }

    $tagihan->invoice_code = $tagihan->invoice_code
        ?? 'INV-' . str_pad($tagihan->id, 4, '0', STR_PAD_LEFT);

    $tagihan->nominal =$tagihan->nominal = $tagihan->nominal;

    $metodePembayaran = MetodePembayaran::where('status','aktif')->get();

    return view('pelanggan.paket.bayar', compact('tagihan','metodePembayaran'));
}



public function pilihMetode(Request $request, Tagihan $tagihan)
{
    $request->validate([
        'metode_pembayaran_id' => 'required'
    ]);

    // simpan metode yang dipilih
    $tagihan->metode_pembayaran_id = $request->metode_pembayaran_id;
    $tagihan->status = 'menunggu_pembayaran';
    $tagihan->save();

    return redirect()
        ->route('pelanggan.tagihan.upload', $tagihan->id)
        ->with('success', 'Metode pembayaran dipilih. Silakan upload bukti transfer.');
}


public function uploadBukti(Tagihan $tagihan)
{
    return view('pelanggan.paket.uploadbukti', compact('tagihan'));
}


public function storeUpload(Request $request, Tagihan $tagihan)
{
    $request->validate([
        'bukti_pembayaran' => 'required|image|max:2048'
    ]);

    // 1️⃣ SIMPAN BUKTI
    $path = $request->file('bukti_pembayaran')
            ->store('bukti_pembayaran', 'public');

    // 2️⃣ UPDATE TAGIHAN
    $tagihan->update([
        'bukti_pembayaran' => $path,
        'status' => 'menunggu_verifikasi'
    ]);

    // 3️⃣ INSERT KE TABEL TRANSAKSIS (INI KUNCI)
    Transaksi::create([
        'pelanggan_id' => $tagihan->pelanggan_id,
        'paket_id'     => $tagihan->paket_id,
        'total'        => $tagihan->nominal,
        'bukti'        => $path,
        'status'       => 'menunggu',
        'jenis'        => 'tagihan_awal'
    ]); 

    return redirect()
        ->route('pelanggan.tagihan')
        ->with('success', 'Bukti pembayaran berhasil dikirim, menunggu verifikasi admin.');
}

public function riwayatTransaksi()
{
    $transaksi = Transaksi::where('pelanggan_id', session('user')->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pelanggan.paket.riwayat-transaksi', compact('transaksi'));
}

   public function formBayarBulanan(TagihanBulanan $tagihan)
    {
        $user = session('user');

        if ($tagihan->pelanggan_id != $user->id) {
            abort(403);
        }

        if ($tagihan->status === 'lunas') {
            return redirect()->route('pelanggan.tagihan')
                ->with('warning', 'Tagihan ini sudah lunas.');
        }

        if ($tagihan->status === 'menunggu_verifikasi') {
            return redirect()->route('pelanggan.tagihan')
                ->with('info', 'Pembayaran sedang diverifikasi.');
        }

        // ✅ INI WAJIB
        if ($tagihan->status === 'belum bayar' || $tagihan->status === 'ditolak') {
            $tagihan->update([
                'status' => 'menunggu_pembayaran',
                'alasan_penolakan' => null
            ]);
        }

        $metodePembayaran = MetodePembayaran::where('status', 'aktif')->get();

        return view('pelanggan.paket.bayar', compact('tagihan', 'metodePembayaran'));
    }


    public function pilihMetodeBulanan(Request $request, TagihanBulanan $tagihan)
    {
        $request->validate([
            'metode_pembayaran_id' => 'required|exists:metode_pembayaran,id'
        ]);

        // 🔒 Cegah aksi ilegal
        if ($tagihan->status !== 'menunggu_pembayaran') {
            return redirect()
                ->route('pelanggan.tagihan')
                ->with('error', 'Status tagihan tidak valid.');
        }

        $tagihan->update([
            'metode_pembayaran_id' => $request->metode_pembayaran_id,
            'status' => 'menunggu_pembayaran'
        ]);

        return redirect()
            ->route('pelanggan.tagihan.bulanan.upload', $tagihan->id)
            ->with('success', 'Metode pembayaran dipilih. Silakan upload bukti transfer.');
    }


    public function uploadBuktiBulanan(TagihanBulanan $tagihan)
    {
        return view('pelanggan.paket.uploadbukti-bulan', compact('tagihan'));
    }


    public function storeUploadBulanan(Request $request, TagihanBulanan $tagihan)
    {
        if (!in_array($tagihan->status, ['belum bayar','menunggu_pembayaran','ditolak'])) {
            return redirect()
                ->route('pelanggan.tagihan')
                ->with('error', 'Status tagihan tidak valid.');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|max:2048'
        ]);

        if ($tagihan->bukti_pembayaran && \Storage::disk('public')->exists($tagihan->bukti_pembayaran)) {
            \Storage::disk('public')->delete($tagihan->bukti_pembayaran);
        }

        $path = $request->file('bukti_pembayaran')
            ->store('bukti_pembayaran', 'public');

        $tagihan->update([
            'bukti_pembayaran' => $path,
            'tanggal_bayar'    => now(),
            'status'           => 'menunggu_verifikasi',
            'alasan_penolakan' => null
        ]);

        Transaksi::create([
            'pelanggan_id' => $tagihan->pelanggan_id,
            'paket_id'     => $tagihan->paket_id,
            'total'        => $tagihan->nominal,
            'bukti'        => $path,
            'status'       => 'menunggu',
            'jenis'        => 'tagihan_bulanan'
        ]);

        return redirect()
            ->route('pelanggan.tagihan')
            ->with('success', 'Bukti pembayaran dikirim, menunggu verifikasi admin.');
    }

}
