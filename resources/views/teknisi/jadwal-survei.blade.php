@extends('layout.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">
    <div class="row">
        <div class="col-12">

            {{-- Header Section --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1 text-dark" style="font-size: 1.4rem;">Jadwal Survei</h5>
                    <p class="text-muted mb-0">Daftar survei yang perlu dilakukan</p>
                </div>
                <a href="{{ route('teknisi.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Dashboard
                </a>
            </div>

            {{-- Survei List --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 py-3">ID</th>
                                    <th class="border-0 py-3">Pelanggan</th>
                                    <th class="border-0 py-3">Alamat</th>
                                    <th class="border-0 py-3">Paket</th>
                                    <th class="border-0 py-3">Waktu</th>
                                    <th class="border-0 py-3">Status</th>
                                    <th class="border-0 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($pesanan as $item)
                                <tr>
                                    <td class="py-3">#SRV{{ $item->id }}</td>

                                    {{-- Pelanggan --}}
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            @php
                                                $initials = strtoupper(substr($item->pelanggan->nama ?? 'NA', 0, 2));
                                            @endphp
                                            <div class="avatar-circle-sm bg-primary bg-opacity-10 me-2">
                                                <span class="text-primary fw-bold">{{ $initials }}</span>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $item->pelanggan->nama ?? '-' }}</div>
                                                <div class="small text-muted">{{ $item->pelanggan->no_hp ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Alamat --}}
                                    <td class="py-3">
                                        <div class="text-truncate" style="max-width: 200px;"
                                            title="{{ $item->alamat }}">
                                            {{ $item->alamat }}
                                        </div>
                                    </td>
                                   <td class="py-3">
                                        <span class="badge bg-light text-dark fw-normal">
                                            {{ $item->paket->nama_paket ?? '-' }}
                                        </span>
                                    </td>


                                    {{-- Waktu --}}
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-clock text-muted me-1"></i>
<<<<<<< Updated upstream
                                          <span>
   {{ $item->jadwal_survei ? \Carbon\Carbon::parse($item->jadwal_survei)->format('d M Y H:i') : '-- Belum dijadwalkan --' }}

</span>

                                        </div>
                                    </td>

                                   <td class="py-3">
                                        <span class="badge 
                                            @if($item->status === 'menunggu_survei') bg-warning 
                                            @elseif($item->status === 'survei_selesai') bg-success 
                                            @else bg-secondary 
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </td>


                                    {{-- Aksi --}}
                                    <td class="py-3 text-center">
                                        {{-- <a href="{{ route('teknisi.detail-survei', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a> --}}
                                        <a href="#"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <div class="py-3">
                                            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
                                            Belum ada jadwal survei.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .avatar-circle-sm {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .table th {
        font-weight: 600;
        color: #495057;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e9ecef;
    }

    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
        border-bottom: 1px solid #f8f9fa;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        border-radius: 4px;
    }

    .btn-outline-primary {
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
    }

    .card {
        border-radius: 8px;
        overflow: hidden;
    }

    .table-responsive {
        border-radius: 8px;
    }
</style>
@endsection
