<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketLayanan;

class PaketLayananController extends Controller
{
    // TAMPILKAN DATA
   public function index(Request $request)
{
    $pakets = PaketLayanan::when($request->search, function ($query) use ($request) {
            $query->where('nama_paket', 'like', '%' . $request->search . '%')
                  ->orWhere('kecepatan', 'like', '%' . $request->search . '%')
                  ->orWhere('harga', 'like', '%' . $request->search . '%');
        })
        ->paginate(5)
        ->withQueryString();

    return view('superadmin.paketlayanan', compact('pakets'));
}


    // SIMPAN PAKET BARU
   public function store(Request $request)
{
    $request->validate([
        'nama_paket' => 'required',
        'kecepatan' => 'required|numeric',
        'harga' => 'required|numeric',
        'biaya_pemasangan' => 'required|numeric',
        'deskripsi' => 'nullable|string',
    ]);

    PaketLayanan::create(
        $request->only([
            'nama_paket',
            'kecepatan',
            'harga',
            'biaya_pemasangan',
            'deskripsi',
        ])
    );

    return back()->with('success', 'Paket berhasil ditambahkan!');
}

    // UPDATE PAKET
    public function update(Request $request, $id)
{
    $request->validate([
        'nama_paket' => 'required',
        'kecepatan' => 'required|numeric',
        'harga' => 'required|numeric',
        'biaya_pemasangan' => 'required|numeric',
        'deskripsi' => 'nullable|string',
    ]);

    $paket = PaketLayanan::findOrFail($id);

    $paket->update(
        $request->only([
            'nama_paket',
            'kecepatan',
            'harga',
            'biaya_pemasangan',
            'deskripsi',
        ])
    );

    return back()->with('success', 'Paket berhasil diperbarui!');
}

    // HAPUS PAKET
    public function destroy($id)
    {
        PaketLayanan::findOrFail($id)->delete();

        return back()->with('success', 'Paket berhasil dihapus!');
    }
}
