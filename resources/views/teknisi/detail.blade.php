@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h4 class="text-center mb-4">Detail Jadwal Survei</h4>

    {{-- HEADER --}}
    <div class="card p-3 mb-3">
        <h6><strong>Informasi Jadwal Survei</strong></h6>
        <p>Order #{{ $survei->id }}</p>
    </div>

    {{-- INFORMASI PEMESANAN --}}
    <div class="card p-3 mb-3">
        <h6><strong>Informasi Pemesanan</strong></h6>

        <div class="mb-3">
            <label><strong>📅 Tanggal Survei</strong></label>
            <div class="border p-2">{{ $survei->tanggal_survei ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label><strong>⏰ Waktu Survei</strong></label>
            <div class="border p-2">{{ $survei->waktu_survei ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label><strong>📍 Lokasi Survei</strong></label>
            <div class="border p-2">{{ $survei->alamat ?? '-' }}</div>
        </div>
    </div>

    {{-- INFORMASI PELANGGAN --}}

    <h4 class="text-center mb-4">Detail Jadwal Instalasi</h4>

    <div class="card p-3 mb-3">
        <h6><strong>Detail Jadwal Instalasi</strong></h6>
        <p>Order #{{ $instalasi->id }}</p>
    </div>

    <div class="card p-3 mb-3">
        <h6><strong>Informasi Instalasi</strong></h6>

        <div class="mb-3">
            <label><strong>📅 Tanggal</strong></label>
            <div class="border p-2">{{ $instalasi->tanggal }}</div>
        </div>

        <div class="mb-3">
            <label><strong>⏰ Waktu</strong></label>
            <div class="border p-2">{{ $instalasi->waktu }}</div>
        </div>

        <div class="mb-3">
            <label><strong>📍 Lokasi</strong></label>
            <div class="border p-2">{{ $instalasi->alamat }}</div>
        </div>
    </div>

    <div class="card p-3 mb-3">
        <h6><strong>Informasi Pelanggan</strong></h6>

        <div class="mb-3">
            <label><strong>👤 Nama Pelanggan</strong></label>

            <div class="border p-2">{{ $survei->nama_pelanggan ?? '-' }}</div>

            <div class="border p-2">{{ $instalasi->nama_pelanggan }}</div>

        </div>

        <div class="mb-3">
            <label><strong>📞 Nomor Telepon</strong></label>
            <div class="border p-2">{{ $survei->telepon ?? '-' }}</div>
        </div>
    </div>

    {{-- DETAIL PAKET --}}
    <div class="card p-3 mb-3">
        <h6><strong>Detail Paket Layanan</strong></h6>

        <div class="mb-3">
            <label><strong>Paket Internet</strong></label>
            <div class="border p-2">{{ $survei->paket_layanan->nama_paket ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label><strong>Harga Paket</strong></label>
            <div class="border p-2">
                {{ isset($survei->paket_layanan->harga)
                    ? number_format($survei->paket_layanan->harga, 0, ',', '.')
                    : '-' }}
            </div>
        </div>
    </div>

    {{-- CATATAN ADMIN --}}
    <div class="card p-3 mb-3">
        <h6><strong>Catatan dari Admin</strong></h6>
        <div class="border p-3" style="min-height: 100px;">
            {{ $survei->catatan_admin ?? '-' }}
        </div>
    </div>

    {{-- BUTTON BACK --}}
    <div class="d-flex gap-3">
        <a href="{{ route('teknisi.jadwal.survei') }}" class="btn btn-secondary">Kembali</a>

            <div class="border p-2">{{ $instalasi->telepon }}</div>
        </div>
    </div>

    <div class="card p-3 mb-3">
        <h6><strong>Detail Layanan</strong></h6>

        <div class="mb-3">
            <label><strong>Teknisi</strong></label>
            <div class="border p-2">{{ $instalasi->teknisi_nama ?? 'Belum ditetapkan' }}</div>
        </div>

        <div class="mb-3">
            <label><strong>Paket Layanan</strong></label>
            <div class="border p-2">{{ $instalasi->paket ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label><strong>Biaya Instalasi</strong></label>
            <div class="border p-2">{{ number_format($instalasi->biaya, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="card p-3 mb-3">
        <h6><strong>Catatan Tambahan</strong></h6>
        <div class="border p-3" style="height: 100px;">
            {{ $instalasi->catatan ?? '-' }}
        </div>
    </div>

    <div class="d-flex gap-3">
        <a href="{{ route('teknisi.update.status') }}" class="btn btn-secondary">Kembali</a>
    </div>

</div>
@endsection
