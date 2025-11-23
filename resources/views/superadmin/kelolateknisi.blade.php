@extends('layout.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4 text-dark fw-bold">Kelola Teknisi</h2>

    {{-- Notifikasi berhasil --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah Teknisi -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahTeknisi">
        + Tambah Teknisi
    </button>

    <!-- ============================== -->
    <!--            TABEL TEKNISI       -->
    <!-- ============================== -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th width="160px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($teknisis as $teknisi)
                        <tr>
                            <td>{{ $teknisi->nama }}</td>
                            <td>{{ $teknisi->email }}</td>
                            <td>{{ $teknisi->no_hp }}</td>
                            <td>{{ $teknisi->alamat }}</td>

                            <td>
                                <!-- TOMBOL EDIT -->
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditTeknisi{{ $teknisi->id }}">
                                    Edit
                                </button>

                                <!-- TOMBOL HAPUS -->
                                <form action="{{ route('superadmin.teknisi.delete', $teknisi->id) }}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus teknisi ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada teknisi</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>


<!-- =================================================================== -->
<!--             MODAL EDIT (Diletakkan DI LUAR TABLE)                   -->
<!-- =================================================================== -->
@foreach ($teknisis as $teknisi)
<div class="modal fade" id="modalEditTeknisi{{ $teknisi->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content"
              action="{{ route('superadmin.teknisi.update', $teknisi->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Teknisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Nama Teknisi</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ $teknisi->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Teknisi</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ $teknisi->email }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control"
                           value="{{ $teknisi->no_hp }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" required>{{ $teknisi->alamat }}</textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>
@endforeach


<!-- =================================================================== -->
<!--             MODAL TAMBAH TEKNISI                                     -->
<!-- =================================================================== -->
<div class="modal fade" id="modalTambahTeknisi" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('superadmin.teknisi.store') }}" method="POST">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Teknisi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Nama Teknisi</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama teknisi" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Teknisi</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email teknisi" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Teknisi</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" placeholder="Masukkan alamat teknisi" required></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Tambah Teknisi</button>
            </div>

        </form>
    </div>
</div>

@endsection
