@extends('layout.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="row">
        <div class="col-12">
            {{-- Header --}}
            <div class="mb-4 text-center">
                <h4 class="fw-bold mb-2">Update Status Pemasangan</h4>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Daftar Instalasi --}}
            <div class="mb-4">
                <h5 class="fw-semibold mb-3">Daftar Instalasi</h5>
                
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px;" class="text-center">No</th>
                                <th>Alamat</th>
                                <th style="width: 250px;" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Data dummy untuk testing - ganti dengan data dari controller
                                $instalasi = $instalasi ?? [
                                    (object)['id' => 123, 'alamat' => 'Jl. Merah No. 1', 'status' => 'proses'],
                                    (object)['id' => 124, 'alamat' => 'Jl. Kuning No. 2', 'status' => 'selesai'],
                                    (object)['id' => 124, 'alamat' => 'Jl. Hijau No. 34', 'status' => 'menunggu'],
                                ];
                            @endphp

                            @forelse($instalasi as $item)
                            <tr>
                                <td class="text-center fw-bold">#{{ $item->id }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        @if($item->status == 'proses')
                                            <span class="badge bg-warning text-dark px-3 py-2">Proses</span>
                                        @elseif($item->status == 'selesai')
                                            <span class="badge bg-success px-3 py-2">Selesai</span>
                                        @elseif($item->status == 'menunggu')
                                            <span class="badge bg-secondary px-3 py-2">Menunggu</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2">{{ ucfirst($item->status) }}</span>
                                        @endif
                                        
                                        <button type="button" 
                                                class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailModal{{ $item->id }}">
                                            <i class="bi bi-file-text-fill"></i>
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal Detail --}}
                            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="bi bi-info-circle me-2"></i>Detail Instalasi #{{ $item->id }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th style="width: 120px;">No</th>
                                                    <td>#{{ $item->id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td>{{ $item->alamat }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        @if($item->status == 'proses')
                                                            <span class="badge bg-warning text-dark">Proses</span>
                                                        @elseif($item->status == 'selesai')
                                                            <span class="badge bg-success">Selesai</span>
                                                        @elseif($item->status == 'menunggu')
                                                            <span class="badge bg-secondary">Menunggu</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ ucfirst($item->status) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <td>{{ $item->tanggal ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Catatan</th>
                                                    <td>{{ $item->catatan ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Tidak ada data instalasi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Notifikasi Ke Konsumen --}}
            <div class="mb-4">
                <h5 class="fw-semibold mb-3">Notifikasi Ke Konsumen :</h5>
                
                <div class="border rounded p-3 bg-light">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-bell-fill fs-3 me-3"></i>
                        <span class="fw-semibold">Kirim notifikasi setelah update</span>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4">
                    Batal
                </button>
                <button type="button" class="btn btn-primary px-4">
                    Update
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .badge {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .btn-sm {
        padding: 0.35rem 0.6rem;
    }

    @media (max-width: 576px) {
        .table {
            font-size: 0.875rem;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.5em;
        }
    }
</style>
@endsection