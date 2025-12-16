<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /* =========================
       DASHBOARD PER ROLE
    ========================== */

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

    // ADMIN
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    // TEKNISI
    public function teknisiDashboard()
    {
        return view('teknisi.dashboard');
    }

    // PELANGGAN
    public function pelangganDashboard()
    {
        return view('pelanggan.dashboard');
    }

    /* =========================
       KELOLA ADMIN
    ========================== */

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

        return back()->with('success', 'Admin berhasil ditambahkan');
    }

    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        User::findOrFail($id)->update(
            $request->only('nama','email','no_hp','alamat')
        );

        return back()->with('success', 'Admin berhasil diperbarui');
    }

    public function deleteAdmin($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Admin berhasil dihapus');
    }

    /* =========================
       KELOLA TEKNISI
    ========================== */

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

        return back()->with('success', 'Teknisi berhasil ditambahkan');
    }

    public function updateTeknisi(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        User::findOrFail($id)->update(
            $request->only('nama','email','no_hp','alamat')
        );

        return back()->with('success', 'Teknisi berhasil diperbarui');
    }

    public function deleteTeknisi($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Teknisi berhasil dihapus');
    }

    /* =========================
       KELOLA PAYMENT
    ========================== */

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

        return back()->with('success', 'Payment staff berhasil ditambahkan');
    }

    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
        ]);

        User::findOrFail($id)->update(
            $request->only('nama','email','no_hp','alamat')
        );

        return back()->with('success', 'Payment staff berhasil diperbarui');
    }

    public function deletePayment($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Payment staff berhasil dihapus');
    }

    /* =========================
       KELOLA PELANGGAN
    ========================== */

    public function indexPelanggan()
    {
        $pelanggan = User::where('role', 'user')->get();
        return view('superadmin.kelolapelanggan', compact('pelanggan'));
    }

    public function terimaPelanggan($id)
    {
        User::findOrFail($id)->update([
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

        User::findOrFail($id)->update([
            'status' => 'rejected',
            'alasan_penolakan' => $request->alasan
        ]);

        return back()->with('success', 'Pelanggan ditolak.');
    }
}
