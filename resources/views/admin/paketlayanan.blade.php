@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Paket Layanan WiFi</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- TOMBOL TAMBAH --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Paket Layanan
    </button>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Paket</th>
                        <th>Kecepatan</th>
                        <th>Harga</th>
                        <th>Biaya Pemasangan</th>
                        <th>Deskripsi</th>
                        <th width="140px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pakets as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama_paket }}</td>
                            <td>{{ $p->kecepatan }} Mbps</td>
                            <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                            <td>Rp {{ number_format($p->biaya_pemasangan,0,',','.') }}</td>
                            <td>{{ $p->deskripsi }}</td>

                            <td>
                                <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $p->id }}">
                                    Edit
                                </button>

                                <form action="/superadmin/paketlayanan/delete/{{ $p->id }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus paket ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>


{{-- ================================================= --}}
{{--  MODAL TAMBAH PAKET --}}
{{-- ================================================= --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="/superadmin/paketlayanan/store" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Paket Layanan</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Nama Paket</label>
                        <input type="text" name="nama_paket" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Kecepatan (Mbps)</label>
                        <input type="number" name="kecepatan" class="form-control" required>
                    </div>

                    <div class="mb-2">
                       <label>Biaya Pemasangan</label>
                       <input type="number" name="biaya_pemasangan" class="form-control" required>
                    </div>


                    <div class="mb-2">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>



{{-- ================================================= --}}
{{--  SEMUA MODAL EDIT (DILETAKKAN DI LUAR TABLE!!)    --}}
{{-- ================================================= --}}
@foreach ($pakets as $p)
<div class="modal fade" id="modalEdit{{ $p->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="/superadmin/paketlayanan/update/{{ $p->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5>Edit Paket Layanan</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Nama Paket</label>
                        <input type="text" name="nama_paket" class="form-control"
                               value="{{ $p->nama_paket }}">
                    </div>

                    <div class="mb-2">
                        <label>Kecepatan (Mbps)</label>
                        <input type="number" name="kecepatan" class="form-control"
                               value="{{ $p->kecepatan }}">
                    </div>

                    <div class="mb-2">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control"
                               value="{{ $p->harga }}">
                    </div>
                    <div class="mb-2">
    <label>Biaya Pemasangan</label>
    <input type="number" name="biaya_pemasangan" class="form-control"
           value="{{ $p->biaya_pemasangan }}">
</div>


                    <div class="mb-2">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control">{{ $p->deskripsi }}</textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach

@endsection
