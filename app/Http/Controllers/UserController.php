<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    // ============================
    // DASHBOARD PER ROLE
    // ============================

   

     //DASHBOARD PER ROLE
    // SUPERADMIN
   public function superAdminDashboard()
{
    return view('superadmin.dashboard', [
        'totalAdmin'     => User::where('role', 'admin')->count(),
        'totalPelanggan' => User::where('role', 'user')->count(),
        'totalTeknisi'   => User::where('role', 'teknisi')->count(),
        'totalPayment'   => User::where('role', 'payment')->count(),
        'totalPenghasilan' => 0, 
        'totalTransaksi' => 0,
        'paymentPending' => 0,
        'pesananAktif' => 0,
        'pesananSelesaiHariIni' => 0,
    ]);
}


    


    public function adminDashboard()
    {
        return view('admin.dashboard',[
             'totalPelanggan' => User::where('role', 'user')->count(),
        'totalTeknisi'   => User::where('role', 'teknisi')->count(),
        'totalPayment'   => User::where('role', 'payment')->count(),
        'totalPenghasilan' => 0, 
        'totalTransaksi' => 0,
        'paymentPending' => 0,
        'pesananAktif' => 0,
        'pesananSelesaiHariIni' => 0,
        ]);
    }

    public function paymentDashboard()
    {
        return view('payment.dashboard');
    }

    public function pelangganDashboard()
    {
        return view('pelanggan.dashboard');
    }

    // KELOLA ADMIN
    public function indexAdmin()
    {
        $admins = User::where('role', 'admin')->get();
        return view('superadmin.kelolaadmin', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'admin',
        ]);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan');
    }

    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $admin = User::findOrFail($id);
        $admin->update($request->only('nama','email','no_hp','alamat'));

        return redirect()->back()->with('success', 'Admin berhasil diperbarui');
    }

    public function deleteAdmin($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Admin berhasil dihapus');
    }

    // KELOLA TEKNISI (hanya user teknisi)
    public function indexTeknisi()
    {
        $teknisis = User::where('role', 'teknisi')->get();
        return view('superadmin.kelolateknisi', compact('teknisis'));
    }

    public function storeTeknisi(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'teknisi',
        ]);

        return redirect()->back()->with('success', 'Teknisi berhasil ditambahkan');
    }

    public function updateTeknisi(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $teknisi = User::findOrFail($id);
        $teknisi->update($request->only('nama','email','no_hp','alamat'));

        return redirect()->back()->with('success', 'Teknisi berhasil diperbarui');
    }

    public function deleteTeknisi($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Teknisi berhasil dihapus');
    }

    // KELOLA PAYMENT
    public function indexPayment()
    {
        $payments = User::where('role', 'payment')->get();
        return view('superadmin.kelolapayment', compact('payments'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'payment',
        ]);

        return redirect()->back()->with('success', 'Payment staff berhasil ditambahkan');
    }

    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        $payment = User::findOrFail($id);
        $payment->update($request->only('nama','email','no_hp','alamat'));

        return redirect()->back()->with('success', 'Payment staff berhasil diperbarui');
    }

    public function deletePayment($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Payment staff berhasil dihapus');
    }





/*
|--------------------------------------------------------------------------
| KELOLA PELANGGAN
|--------------------------------------------------------------------------
*/

// LIST SEMUA PELANGGAN
public function indexPelanggan()
{
    // kalau pelanggan kamu pakai role = 'pelanggan', gunakan ini:
    $pelanggan = User::where('role', 'pelanggan')->get();

    return view('superadmin.kelolapelanggan', compact('pelanggan'));
}

// TERIMA PELANGGAN
public function terimaPelanggan($id)
{
    $p = User::findOrFail($id);
    $p->update([
        'status' => 'accepted',
        'alasan_penolakan' => null
    ]);

    return back()->with('success', 'Pelanggan diterima!');
}


    public function tolakPelanggan(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required'
        ]);

        $p = User::findOrFail($id);
        $p->update([
            'status' => 'rejected',
            'alasan_penolakan' => $request->alasan
        ]);

        return back()->with('success', 'Pelanggan ditolak.');
    }




// UPDATE DATA PELANGGAN
public function updatePelanggan(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email',
        'no_hp' => 'required|string|max:20',
        'alamat' => 'nullable|string',
        'foto_ktp' => 'nullable|image|max:2048',
    ]);

    $p = User::findOrFail($id);

    // Jika upload foto KTP baru
    if ($request->hasFile('foto_ktp')) {

        // Hapus foto lama
        if ($p->foto_ktp && file_exists(storage_path('app/public/' . $p->foto_ktp))) {
            unlink(storage_path('app/public/' . $p->foto_ktp));
        }

        $p->foto_ktp = $request->file('foto_ktp')->store('ktp', 'public');
    }

    // Update data lainnya
    $p->update([
        'nama' => $request->nama,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
        'foto_ktp' => $p->foto_ktp,
    ]);

    return back()->with('success', 'Data pelanggan berhasil diperbarui!');
}


// HAPUS PELANGGAN
public function deletePelanggan($id)
{
    $p = User::findOrFail($id);

    // Hapus foto KTP jika ada
    if ($p->foto_ktp && file_exists(storage_path('app/public/' . $p->foto_ktp))) {
        unlink(storage_path('app/public/' . $p->foto_ktp));
    }

    $p->delete();

    return back()->with('success', 'Pelanggan berhasil dihapus!');
}

}