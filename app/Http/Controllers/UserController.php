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

    public function superAdminDashboard()
    {
        return view('superadmin.dashboard');
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function teknisiDashboard()
    {
        return view('teknisi.dashboard');
    }

    public function paymentDashboard()
    {
        return view('payment.dashboard');
    }
    // ============================
    // KELOLA ADMIN
    // ============================

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

        $admin->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Admin berhasil diperbarui');
    }

    public function deleteAdmin($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Admin berhasil dihapus');
    }

    // ============================
    // KELOLA TEKNISI
    // ============================

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

        $teknisi->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Teknisi berhasil diperbarui');
    }

    public function deleteTeknisi($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Teknisi berhasil dihapus');
    }

    // ============================
    // KELOLA PAYMENT
    // ============================

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

        $payment->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Payment staff berhasil diperbarui');
    }

    public function deletePayment($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Payment staff berhasil dihapus');
    }
}
