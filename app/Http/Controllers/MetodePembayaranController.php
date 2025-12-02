<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        $data = MetodePembayaran::all();
        return view('superadmin.metodepembayaran', compact('data'));
    }

    public function create()
    {
        return view('superadmin.metode_pembayaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_metode' => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'icon'        => 'nullable|image|max:2048'

        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('metode_pembayaran', 'public');
        }

        MetodePembayaran::create([
            'nama_metode' => $request->nama_metode,
            'deskripsi'   => $request->deskripsi,
            'icon'        => $iconPath,
            'nomor_pembayaran'=> $request->nomor_pembayaran,
        ]);

        return redirect()->route('superadmin.metodepembayaran')
                         ->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $data = MetodePembayaran::findOrFail($id);

        if ($data->icon) {
            unlink(storage_path('app/public/' . $data->icon));
        }

        $data->delete();

        return back()->with('success', 'Metode pembayaran berhasil dihapus.');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_metode' => 'required|string|max:100',
        'deskripsi'   => 'nullable|string',
        'icon'        => 'nullable|image|max:2048'

    ]);

    $m = MetodePembayaran::findOrFail($id);

    // jika upload icon baru
    if ($request->hasFile('icon')) {

        // hapus icon lama
        if ($m->icon && file_exists(storage_path('app/public/' . $m->icon))) {
            unlink(storage_path('app/public/' . $m->icon));
        }

        // simpan icon baru
        $m->icon = $request->file('icon')->store('metode_pembayaran', 'public');
    }

    // update nama & deskripsi
    $m->update([
        'nama_metode' => $request->nama_metode,
        'deskripsi'   => $request->deskripsi,
        'icon'        => $m->icon,
        'nomor_pembayaran' => $request->nomor_pembayaran,
    ]);

    return redirect()->back()->with('success', 'Metode pembayaran berhasil diperbarui!');
}

}
