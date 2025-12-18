@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 text-dark fw-bold">Kelola Payment</h2>

    <!-- Tombol Tambah Payment -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahPayment">
        + Tambah Akun Payment
    </button>
    

    <!-- CARD TABEL PAYMENT -->
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
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->nama }}</td>
                        <td>{{ $payment->email }}</td>
                        <td>{{ $payment->no_hp }}</td>
                        <td>{{ $payment->alamat }}</td>

                        <td>
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditPayment{{ $payment->id }}">
                                Edit
                            </button>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('superadmin.payment.delete', $payment->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus akun ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada akun payment</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>



<!-- ====================================================== -->
<!--  MODAL TAMBAH PAYMENT -->
<!-- ====================================================== -->
<div class="modal fade" id="modalTambahPayment" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('superadmin.payment.store') }}" method="POST">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Akun Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Minimal 6 karakter" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" placeholder="Masukkan alamat" required></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Tambah</button>
            </div>

        </form>
    </div>
</div>



<!-- ====================================================== -->
<!--  MODAL EDIT PAYMENT -->
<!-- ====================================================== -->
@foreach($payments as $payment)
<div class="modal fade" id="modalEditPayment{{ $payment->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content"
              action="{{ route('superadmin.payment.update', $payment->id) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Akun Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ $payment->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ $payment->email }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control"
                           value="{{ $payment->no_hp }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" required>{{ $payment->alamat }}</textarea>
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
