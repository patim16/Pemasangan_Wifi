@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 fw-bold text-dark">Daftar Pelanggan Terdaftar</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Foto KTP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Koordinat</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pelanggan as $p)
                    <tr>

                        <td>
                            @if($p->foto_ktp)
                                <img src="{{ asset('storage/' . $p->foto_ktp) }}"
                                     width="90" class="border rounded">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td>{{ $p->alamat }}</td>

                        <td>
                            @if($p->latitude && $p->longitude)
                                {{ $p->latitude }}, {{ $p->longitude }}

                                <br>
                                <a href="https://www.google.com/maps?q={{ $p->latitude }},{{ $p->longitude }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary mt-1">
                                    Lihat Maps
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            <!-- EDIT -->
                            <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{ $p->id }}">
                                Edit
                            </button>

                            <!-- HAPUS -->
                            <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalHapus{{ $p->id }}">
                                Hapus
                            </button>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada pelanggan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

{{-- ========================= --}}
{{--     MODAL EDIT PELANGGAN  --}}
{{-- ========================= --}}
@foreach ($pelanggan as $p)
<div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content"
              method="POST"
              action="{{ url('superadmin/pelanggan/update/' . $p->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Pelanggan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-2">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required>
                </div>

                <div class="mb-2">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $p->email }}" required>
                </div>

                <div class="mb-2">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $p->no_hp }}" required>
                </div>

                <div class="mb-2">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control">{{ $p->alamat }}</textarea>
                </div>

                <div class="mb-2">
                    <label>Foto KTP Baru (opsional)</label>
                    <input type="file" name="foto_ktp" class="form-control">
                    @if($p->foto_ktp)
                        <img src="{{ asset('storage/' . $p->foto_ktp) }}" width="70" class="mt-2">
                    @endif
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-warning">Update</button>
            </div>

        </form>
    </div>
</div>
@endforeach


{{-- ========================= --}}
{{--     MODAL HAPUS PELANGGAN --}}
{{-- ========================= --}}
@foreach ($pelanggan as $p)
<div class="modal fade" id="modalHapus{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content"
              method="POST"
              action="{{ url('superadmin/pelanggan/delete/' . $p->id) }}">
              
            @csrf
            @method('DELETE')

            <div class="modal-header">
                <h5 class="modal-title">Hapus Pelanggan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Apakah kamu yakin ingin menghapus <strong>{{ $p->nama }}</strong> ?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger">Hapus</button>
            </div>

        </form>
    </div>
</div>
@endforeach

@endsection
