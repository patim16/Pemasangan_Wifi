<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instalasi;
use App\Models\KelolaPesanan;
use App\Models\Pemesanan;
use App\Models\Survei;
use App\Models\Pemasangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeknisiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        return view('teknisi.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | JADWAL SURVEI (FIX UTAMA)
    |--------------------------------------------------------------------------
    */
    // public function jadwalSurvei()
    // {
    //     $survei = Pemesanan::where('status', 'jadwal_survei')->get();
    //     return view('teknisi.jadwal-survei', compact('survei'));
    // }

    public function jadwalSurveyTeknisi()
    {
        $teknisiId = session('user')->id;

        $pesanan = Pemesanan::with(['pelanggan', 'paket'])
            ->where('teknisi_id', $teknisiId)
            ->whereNotNull('jadwal_survei')
            ->orderBy('jadwal_survei', 'asc')
            ->get();


        return view('teknisi.jadwal-survei', compact('pesanan'));
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL SURVEI
    |--------------------------------------------------------------------------
    */
    public function detailSurvei($id)
    {
        $survei = Pemesanan::with(['user', 'paket'])->findOrFail($id);
        return view('teknisi.detail-survei', compact('survei'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM SURVEI
    |--------------------------------------------------------------------------
    */
    public function formSurvei($id)
    {
        $data = Pemesanan::findOrFail($id);
        return view('teknisi.form-survei', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT SURVEI
    |--------------------------------------------------------------------------
    */
    public function submitSurvei(Request $request)
    {
        $request->validate([
            'pemesanan_id' => 'required|exists:pemesanan,id',
            'hasil'        => 'required|in:bisa,tidak_bisa',
            'catatan'      => 'nullable|string|max:255',
            'foto'         => 'nullable|image|max:2048'
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/survei', $filename);
            $foto = 'survei/'.$filename;
        }

        DB::transaction(function () use ($request, $foto) {

            Survei::create([
                'pemesanan_id' => $request->pemesanan_id,
                'hasil'        => $request->hasil,
                'catatan'      => $request->catatan,
                'foto'         => $foto,
                'teknisi_id'   => Auth::id(),
            ]);

            $pesanan = Pemesanan::findOrFail($request->pemesanan_id);
            $pesanan->status = ($request->hasil === 'bisa')
                ? 'survei_selesai'
                : 'ditolak';
            $pesanan->save();
        });

        return back()->with('success', 'Laporan survei berhasil dikirim!');
    }

    /*
    |--------------------------------------------------------------------------
    | JADWAL PEMASANGAN
    |--------------------------------------------------------------------------
    */
    public function jadwalPemasangan()
    {
        $pemasangan = Pemesanan::with(['user', 'paket'])
            ->where('teknisi_id', Auth::id())
            ->where('status', 'paid')
            ->whereNotNull('jadwal_instalasi')
            ->get();

        return view('teknisi.jadwal-pemasangan', compact('pemasangan'));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PEMASANGAN
    |--------------------------------------------------------------------------
    */
    public function detailPemasangan($id)
    {
        $pemasangan = Pemasangan::where('pemesanan_id', $id)->firstOrFail();
        return view('teknisi.detail-pemasangan', compact('pemasangan'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM LAPORAN PEMASANGAN
    |--------------------------------------------------------------------------
    */
    public function formLaporan()
    {
        $pemesanan = Pemesanan::where('teknisi_id', Auth::id())
            ->where('status', 'paid')
            ->get();

        return view('teknisi.kirim-laporan', compact('pemesanan'));
    }

    /*
    |--------------------------------------------------------------------------
    | KIRIM LAPORAN PEMASANGAN
    |--------------------------------------------------------------------------
    */
    public function kirimLaporanPemasangan(Request $request)
    {
        $request->validate([
            'pemesanan_id' => 'required|exists:pemesanan,id',
            'catatan'      => 'nullable|string|max:255',
            'foto'         => 'nullable|image|max:2048'
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/pemasangan', $filename);
            $foto = 'pemasangan/'.$filename;
        }

        DB::transaction(function () use ($request, $foto) {

            Instalasi::create([
                'pemesanan_id' => $request->pemesanan_id,
                'catatan'      => $request->catatan,
                'foto'         => $foto,
                'teknisi_id'   => Auth::id(),
                'status'       => 'selesai'
            ]);

            Pemesanan::where('id', $request->pemesanan_id)
                ->update(['status' => 'pemasangan_selesai']);
        });

        return back()->with('success', 'Laporan pemasangan berhasil dikirim!');
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS INSTALASI
    |--------------------------------------------------------------------------
    */
    public function updateStatus()
    {
        $instalasi = Instalasi::where('teknisi_id', Auth::id())
            ->latest()
            ->get();

        return view('teknisi.update-status', compact('instalasi'));
    }

    public function updateStatusSubmit(Request $request)
    {
        $request->validate([
            'instalasi_id' => 'required|exists:instalasi,id',
            'status'       => 'required|string|max:50'
        ]);

        $instalasi = Instalasi::findOrFail($request->instalasi_id);
        $instalasi->status = $request->status;
        $instalasi->save();

        return back()->with('success', 'Status instalasi berhasil diperbarui!');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL INSTALASI
    |--------------------------------------------------------------------------
    */
    public function detailInstalasi($id)
    {
        $instalasi = Instalasi::findOrFail($id);
        return view('teknisi.detail-instalasi', compact('instalasi'));
    }
}
