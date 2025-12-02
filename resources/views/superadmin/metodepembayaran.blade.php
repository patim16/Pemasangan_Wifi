@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3 fw-bold">Kelola Metode Pembayaran</h3>

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Metode Pembayaran
    </button>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th width="80">Icon</th>
                        <th>Nama Metode</th>
                        <th>Nomor Pembayaran</th>
                        <th>Deskripsi</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $m)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if($m->icon)
                                <img src="{{ asset('storage/' . $m->icon) }}" width="50" class="rounded">
                            @else
                                <small class="text-muted">Tidak ada</small>
                            @endif
                        </td>

                        <td>{{ $m->nama_metode }}</td>
                        <td>{{$m-> nomor_pembayaran}}</td>
                        <td>{{ $m->deskripsi ?? '-' }}</td>

                        <td>
                            <!-- Edit -->
                            <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{ $m->id }}">
                                Edit
                            </button>

                            <!-- Hapus -->
                            <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalHapus{{ $m->id }}">
                                Hapus
                            </button>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada metode pembayaran</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>


{{-- =========================== --}}
{{--     MODAL TAMBAH DATA        --}}
{{-- =========================== --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST"
              action="{{ url('superadmin/metodepembayaran/store') }}"
              enctype="multipart/form-data"
              class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Nama Metode</label>
                    <input type="text" name="nama_metode" class="form-control" required>

                </div>

                <div class="mb-3">
    <label class="form-label">Nomor Pembayaran</label>
    <input type="text" name="nomor_pembayaran" class="form-control" required>
</div>


                <div class="mb-3">
                    <label class="form-label">Deskripsi (opsional)</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Icon (opsional)</label>
                    <input type="file" name="icon" class="form-control" accept="image/*">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success">Simpan</button>
            </div>

        </form>
    </div>
</div>


{{-- =========================== --}}
{{--     MODAL EDIT DATA          --}}
{{-- =========================== --}}
@foreach ($data as $m)
<div class="modal fade" id="modalEdit{{ $m->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST"
              action="{{ url('superadmin/metodepembayaran/update/' . $m->id) }}"
              enctype="multipart/form-data"
              class="modal-content">

            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Nama Metode</label>
                    <input type="text" name="nama_metode" class="form-control" value="{{ $m->nama_metode }}" required>
                </div>
                
                <div class="mb-3">
    <label class="form-label">Nomor Pembayaran</label>
    <input type="text" name="nomor_pembayaran" class="form-control" value="{{ $m->nomor_pembayaran }}" required>
</div>


                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ $m->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Icon Baru (opsional)</label>
                    <input type="file" name="icon" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak diganti.</small>
                    <br>
                    @if($m->icon)
                        <img src="{{ asset('storage/' . $m->icon) }}" width="50" class="mt-2">
                    @endif
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-warning">Update</button>
            </div>

        </form>
    </div>
</div>
@endforeach


{{-- =========================== --}}
{{--         MODAL HAPUS         --}}
{{-- =========================== --}}
@foreach ($data as $m)
<div class="modal fade" id="modalHapus{{ $m->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST"
              action="{{ url('superadmin/metodepembayaran/delete/' . $m->id) }}"
              class="modal-content">
            @csrf
            @method('DELETE')

            <div class="modal-header">
                <h5 class="modal-title">Hapus Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Yakin ingin menghapus <strong>{{ $m->nama_metode }}</strong> ?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger">Hapus</button>
            </div>

        </form>
    </div>
</div>
@endforeach

@endsection
