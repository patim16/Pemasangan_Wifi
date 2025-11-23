@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 text-dark fw-bold">Kelola Admin</h2>

    <!-- Tombol Tambah Admin -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahAdmin">
        + Tambah Admin
    </button>

    <!-- CARD TABEL ADMIN -->
    <div class="card shadow-sm">
        <div class="card-body">

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
                    @forelse($admins as $admin)
                    <tr>
                        <td>{{ $admin->nama }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->no_hp }}</td>
                        <td>{{ $admin->alamat }}</td>

                        <td>
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditAdmin{{ $admin->id }}">
                                Edit
                            </button>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('superadmin.admin.delete', $admin->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada admin</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>



<!-- ====================================================== -->
<!--  MODAL TAMBAH ADMIN                                     -->
<!-- ====================================================== -->
<div class="modal fade" id="modalTambahAdmin" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('superadmin.admin.store') }}" method="POST">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Admin Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Nama Admin</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama admin" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Admin</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email admin" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Admin</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Minimal 6 karakter" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" placeholder="Masukkan alamat admin" required></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Tambah Admin</button>
            </div>
        </form>
    </div>
</div>



<!-- modal edit -->
@foreach($admins as $admin)
<div class="modal fade" id="modalEditAdmin{{ $admin->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content"
              action="{{ route('superadmin.admin.update', $admin->id) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ $admin->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ $admin->email }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control"
                           value="{{ $admin->no_hp }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" required>{{ $admin->alamat }}</textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endforeach

@endsection
