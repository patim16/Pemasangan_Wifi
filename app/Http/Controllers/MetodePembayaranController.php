<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;

class MetodePembayaranController extends Controller
{
    public function index(Request $request)
    {
        $data = MetodePembayaran::when($request->search, function ($query) use ($request) {
                $query->where('nama_metode', 'like', '%' . $request->search . '%')
                      ->orWhere('nomor_pembayaran', 'like', '%' . $request->search . '%');
            })
            ->orderBy('status', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('superadmin.metodepembayaran', compact('data'));
    }

    public function create()
    {
        return view('superadmin.metodepembayaran');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_metode' => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'icon'        => 'nullable|image|max:2048',
            'nomor_pembayaran' => 'nullable|string|max:100',
           
        ]);

        $iconPath = $request->hasFile('icon')
            ? $request->file('icon')->store('metode_pembayaran', 'public')
            : null;

        MetodePembayaran::create([
            'nama_metode' => $request->nama_metode,
            'deskripsi'   => $request->deskripsi,
            'icon'        => $iconPath,
            'nomor_pembayaran'=> $request->nomor_pembayaran,
           
        ]);

        return redirect()->route('superadmin.metodepembayaran')
                         ->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_metode' => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'icon'        => 'nullable|image|max:2048',
            'nomor_pembayaran' => 'nullable|string|max:100',
           
        ]);

        $m = MetodePembayaran::findOrFail($id);

        // Ganti icon jika upload baru
        if ($request->hasFile('icon')) {

            if ($m->icon && file_exists(storage_path('app/public/' . $m->icon))) {
                unlink(storage_path('app/public/' . $m->icon));
            }

            $m->icon = $request->file('icon')->store('metode_pembayaran', 'public');
        }

        $m->update([
            'nama_metode' => $request->nama_metode,
            'deskripsi'   => $request->deskripsi,
            'icon'        => $m->icon,
            'nomor_pembayaran' => $request->nomor_pembayaran,
           
        ]);

        return back()->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = MetodePembayaran::findOrFail($id);

        if ($data->icon && file_exists(storage_path('app/public/' . $data->icon))) {
            unlink(storage_path('app/public/' . $data->icon));
        }

        $data->delete();

        return back()->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
