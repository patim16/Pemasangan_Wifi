<?php

namespace App\Http\Controllers;
use App\Models\Pemesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\PaketLayanan;



class PelangganController extends Controller
{
//dahsboard pelanggan
 public function dashboard()
    {
        return view('pelanggan.dashboard');
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
    // Ambil data pemesanan terakhir untuk user ini dengan paket_id tersebut
    $userId = auth()->id();

    $invoice = Pemesanan::where('user_id', $userId)
                ->where('paket_id', $paket_id)
                ->latest()
                ->first();
    
    return view('pelanggan.paket.invoice', compact('paket_id', 'invoice'));
}
     //konfirmasi pemesanan
public function konfirmasiPemesanan($paket_id)
{
    $data = session('input_data');

    // Generate Invoice Code
    $invoice = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

    Pemesanan::create([
        'user_id'   => session('user')->id,
        'paket_id'  => $paket_id,
        'alamat'    => $data['alamat'],
        'patokan'   => $data['patokan'],
        'catatan'   => $data['catatan'],
        'latitude'  => $data['latitude'],
        'longitude' => $data['longitude'],
        'invoice_code' => $invoice,
        'total_bayar' => $paket->harga,
        'status'    => 'pending',
    ]);

    // Hapus session
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
                ->get();

    return view('pelanggan.paket.riwayat', compact('riwayat'));
}
   //cetak invoice
  public function cetakInvoice($id)
{
    $invoice = Pemesanan::findOrFail($id);

    $pdf = Pdf::loadView('pelanggan.paket.invoice-pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');

    return $pdf->download('Invoice-'.$invoice->invoice_code.'.pdf');
}


}
