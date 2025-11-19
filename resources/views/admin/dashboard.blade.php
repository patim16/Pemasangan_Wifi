@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h1>Dashboard Admin</h1>
    <p>Selamat datang</p>

    <div class="row mt-4">

        {{-- Kartu Kelola Paket --}}
        <div class="col-md-4 mb-3">
            <a href="/admin/paket" class="text-decoration-none">
                <div class="card shadow-sm p-3">
                    <h4>Kelola Paket Layanan</h4>
                    <p>Lihat, tambah, edit, dan hapus paket internet.</p>
                </div>
            </a>
        </div>

        {{-- Kartu Kelola Teknisi --}}
        <div class="col-md-4 mb-3">
            <a href="/admin/teknisi" class="text-decoration-none">
                <div class="card shadow-sm p-3">
                    <h4>Kelola Data Teknisi</h4>
                    <p>Tambah, edit, hapus teknisi, dan atur jadwal instalasi.</p>
                </div>
            </a>
        </div>

        {{-- Kartu Kelola Konsumen --}}
        <div class="col-md-4 mb-3">
            <a href="/admin/konsumen" class="text-decoration-none">
                <div class="card shadow-sm p-3">
                    <h4>Kelola Data Konsumen</h4>
                    <p>Lihat daftar pelanggan dan proses pesanan.</p>
                </div>
            </a>
        </div>

        {{-- Kartu Kelola Payment --}}
        <div class="col-md-4 mb-3">
            <a href="/admin/payment" class="text-decoration-none">
                <div class="card shadow-sm p-3">
                    <h4>Kelola Pembayaran</h4>
                    <p>Verifikasi pembayaran dan tambah metode pembayaran.</p>
                </div>
            </a>
        </div>

        {{-- Kartu Generate Laporan --}}
        <div class="col-md-4 mb-3">
            <a href="/admin/laporan" class="text-decoration-none">
                <div class="card shadow-sm p-3">
                    <h4>Generate Laporan</h4>
                    <p>Buat laporan harian, mingguan, atau bulanan.</p>
                </div>
            </a>
        </div>

        {{-- Logout --}}
        <div class="col-md-4 mb-3">
            <a href="/logout" class="text-decoration-none">
                <div class="card shadow-sm p-3 bg-danger text-white">
                    <h4>Logout</h4>
                    <p>Keluar dari akun admin.</p>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection
