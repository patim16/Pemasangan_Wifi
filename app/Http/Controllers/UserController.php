<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     //DASHBOARD PER ROLE
    // SUPERADMIN
    public function superAdminDashboard()
    {
        return view('superadmin.dashboard');
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

   

     // pelanggan
    public function pelangganDashboard()
    {
        return view('pelanggan.dashboard');
    }

    //KELOLA ADMIN
    // LIST ADMIN
    public function indexAdmin()
    {
        $admins = User::where('role', 'admin')->get();
        return view('superadmin.kelolaadmin', compact('admins'));
    }

    // STORE ADMIN
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

    // UPDATE ADMIN
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

    // DELETE ADMIN
    public function deleteAdmin($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Admin berhasil dihapus');
    }

     //KELOLA TEKNISI
    // LIST TEKNISI
    public function indexTeknisi()
    {
        $teknisis = User::where('role', 'teknisi')->get();
        return view('superadmin.kelolateknisi', compact('teknisis'));
    }

    // STORE TEKNISI
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

    // UPDATE TEKNISI
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

    // DELETE TEKNISI
    public function deleteTeknisi($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Teknisi berhasil dihapus');
    }




    //KELOLA  PAYMENT

    // LIST PAYMENT 
    public function indexPayment()
    {
        $payments = User::where('role', 'payment')->get();
        return view('superadmin.kelolapayment', compact('payments'));
    }

    // STORE PAYMENT 
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

    // UPDATE PAYMENT 
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

    // DELETE PAYMENT 
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

// LIST PELANGGAN
public function indexPelanggan()
{
    $pelanggan = User::where('role', 'user')->get();
    return view('superadmin.kelolapelanggan', compact('pelanggan'));
}

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
}