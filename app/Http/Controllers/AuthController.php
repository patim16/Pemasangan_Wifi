<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // TAMPILKAN FORM REGISTER
    public function showRegister()
    {
        return view('register');
    }

    // PROSES REGISTER
   public function register(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:100',
        'no_hp' => 'required|string|max:20',
        // jika kamu masih ingin menyimpan nomor KTP, tambahkan validasi 'ktp' di sini
        'alamat' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048' // max 2MB
    ]);

    // Proses upload foto KTP
    $fotoPath = null;
    if ($request->hasFile('foto_ktp')) {
        $file = $request->file('foto_ktp');
        $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
        // simpan di storage/app/public/uploads/ktp
        $file->storeAs('public/uploads/ktp', $filename);
        $fotoPath = 'uploads/ktp/' . $filename; // path relatif ke folder public
    }

    User::create([
        'nama' => $request->nama,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'user',
        'foto_ktp' => $fotoPath,
        // kalau masih menyimpan nomor KTP: 'ktp' => $request->ktp,
    ]);

    return redirect('/login')->with('success', 'Registrasi Berhasil, silakan login!');
}
    // TAMPILKAN FORM LOGIN
    public function showLogin()
    {
        return view('login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        // Simpan user ke session
        session(['user' => $user]);

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'superadmin':
                return redirect('/superadmin/dashboard');
            case 'admin':
                return redirect('/admin/dashboard');
            case 'teknisi':
                return redirect('/teknisi/dashboard');
            case 'payment':
                return redirect('/payment/dashboard');
            default:
                return redirect('/pelanggan/dashboard');
        }
    }

    // LOGOUT
    public function logout()
    {
        session()->forget('user');
        return redirect('/login');
    }
}

