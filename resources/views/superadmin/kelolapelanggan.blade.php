@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 fw-bold text-dark">Kelola Pelanggan</h2>

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
                        <th>Status</th>
                        <th width="160px">Aksi</th>
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
                            @if($p->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($p->status === 'accepted')
                                <span class="badge bg-success">Diterima</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span><br>
                                <small>Alasan: {{ $p->alasan_penolakan }}</small>
                            @endif
                        </td>

                        <td>
                            @if($p->status === 'pending')
                                <!-- TERIMA -->
                                <form action="{{ route('superadmin.pelanggan.terima', $p->id) }}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm">Terima</button>
                                </form>

                                <!-- TOLAK -->
                                <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#tolak{{ $p->id }}">
                                    Tolak
                                </button>
                            @else
                                <em class="text-muted">Tidak ada aksi</em>
                            @endif
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

{{-- ====================== --}}
{{--  SEMUA MODAL DI BAWAH --}}
{{-- ====================== --}}

@foreach ($pelanggan as $p)
<div class="modal fade" id="tolak{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content"
              action="{{ route('superadmin.pelanggan.tolak', $p->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Tolak Pelanggan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label>Alasan Penolakan</label>
                <textarea name="alasan" class="form-control" required></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger">Tolak</button>
            </div>

        </form>
    </div>
</div>
@endforeach

@endsection
