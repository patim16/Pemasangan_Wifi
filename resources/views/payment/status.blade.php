@extends('layout.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">Update Status Pembayaran</h2>
        <div class="d-flex gap-2">
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                <i class="bi bi-list-check me-1"></i> {{ $data->count() }} Transaksi
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary bg-opacity-10">
                        <tr>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold">Pelanggan</th>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold">Paket</th>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold text-end">Total</th>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold text-center">Status Saat Ini</th>
                            <th class="border-0 px-4 py-3 text-muted fw-semibold">Update Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $t)
                        <tr class="border-bottom border-light">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded-circle me-3">
                                        <span class="text-primary fw-bold">{{ substr($t->pelanggan->nama, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $t->pelanggan->nama }}</div>
                                        <small class="text-muted d-none d-md-block">{{ $t->pelanggan->email ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-light border border-secondary-subtle text-dark px-3 py-2 rounded-pill">
                                    {{ $t->paket->nama }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="fw-bold text-success">Rp {{ number_format($t->total, 0, ',', '.') }}</div>
                                <small class="text-muted d-none d-lg-block">{{ $t->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $statusClass = match($t->status) {
                                        'menunggu' => 'bg-warning bg-opacity-10 text-warning',
                                        'terverifikasi' => 'bg-info bg-opacity-10 text-info',
                                        'sedang diproses' => 'bg-primary bg-opacity-10 text-primary',
                                        'berhasil' => 'bg-success bg-opacity-10 text-success',
                                        'gagal' => 'bg-danger bg-opacity-10 text-danger',
                                        default => 'bg-secondary bg-opacity-10 text-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }} px-3 py-2 rounded-pill">
                                    {{ $t->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <form action="{{ route('payment.status.update', $t->id) }}" method="POST" class="d-flex gap-2 align-items-center">
                                    @csrf
                                    <div class="flex-grow-1">
                                        <select name="status" class="form-select form-select-sm rounded-pill border-0 bg-light" required>
                                            <option value="menunggu" {{ $t->status == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                            <option value="terverifikasi" {{ $t->status == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                            <option value="sedang diproses" {{ $t->status == 'sedang diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                            <option value="berhasil" {{ $t->status == 'berhasil' ? 'selected' : '' }}>Pembayaran Berhasil</option>
                                            <option value="gagal" {{ $t->status == 'gagal' ? 'selected' : '' }}>Pembayaran Gagal</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">
                                        <i class="bi bi-arrow-clockwise me-1"></i> Update
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
</div>

@push('styles')
<style>
    .avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    
    .form-select-sm {
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }
    
    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .alert-success {
        background-color: rgba(25, 135, 84, 0.1);
        border-left: 4px solid #198754;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Animasi muncul untuk baris tabel
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            setTimeout(() => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';
                row.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, 50);
            }, index * 30);
        });
        
        // Efek hover pada tombol update
        const updateButtons = document.querySelectorAll('button[type="submit"]');
        updateButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.querySelector('i').classList.add('bi-arrow-repeat');
                this.querySelector('i').classList.remove('bi-arrow-clockwise');
            });
            
            button.addEventListener('mouseleave', function() {
                this.querySelector('i').classList.remove('bi-arrow-repeat');
                this.querySelector('i').classList.add('bi-arrow-clockwise');
            });
        });
    });
</script>
@endpush
@endsection