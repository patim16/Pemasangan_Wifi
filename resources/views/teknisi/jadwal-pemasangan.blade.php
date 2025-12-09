@extends('layout.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">
    <div class="row">
        <div class="col-12">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                   <h5 class="fw-bold mb-1 text-dark" style="font-size: 1.4rem;">Atur Jadwal Pemasangan</h5>
                    <p class="text-muted mb-0">Jadwalkan instalasi, perbaikan, atau upgrade WiFi untuk pelanggan</p>
                </div>
                <a href="{{ route('teknisi.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>

            {{-- Filter Jenis Pemasangan --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-sm btn-outline-primary active filter-btn" data-filter="all">
                            <i class="bi bi-list-ul me-1"></i>Semua
                        </button>
                        <button class="btn btn-sm btn-outline-success filter-btn" data-filter="baru">
                            <i class="bi bi-plus-circle me-1"></i>Pemasangan Baru
                        </button>
                        <button class="btn btn-sm btn-outline-warning filter-btn" data-filter="perbaikan">
                            <i class="bi bi-tools me-1"></i>Perbaikan
                        </button>
                        <button class="btn btn-sm btn-outline-info filter-btn" data-filter="upgrade">
                            <i class="bi bi-arrow-up-circle me-1"></i>Upgrade
                        </button>
                    </div>
                </div>
            </div>

            {{-- Jadwal Pemasangan List --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0 fw-bold">Daftar Jadwal Pemasangan</h6>

                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Jadwal
                    </button>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Lokasi</th>
                                    <th>Jenis Pemasangan</th>
                                    <th>Paket</th>
                                    <th>Tanggal</th>
                                    <th>Catatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($pemasangan as $item)
                                <tr data-jenis="{{ $item->jenis_pemasangan ?? 'baru' }}">
                                    <td class="py-3">#{{ $item->id }}</td>

                                    <td class="py-3">
                                        <div class="fw-bold">
                                            {{ $item->pelanggan->nama ?? 'Tidak ada nama' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $item->pelanggan->no_hp ?? '-' }}
                                        </small>
                                    </td>

                                    <td class="py-3">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-geo-alt text-danger me-2 mt-1"></i>
                                            <div>
                                                <div class="fw-medium">{{ $item->pelanggan->alamat ?? '-' }}</div>
                                                @if($item->pelanggan->kelurahan)
                                                    <small class="text-muted">
                                                        {{ $item->pelanggan->kelurahan }}, {{ $item->pelanggan->kecamatan }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3">
                                        @php
                                            $jenis = $item->jenis_pemasangan ?? 'baru';
                                            $badgeClass = [
                                                'baru' => 'bg-success',
                                                'perbaikan' => 'bg-warning',
                                                'upgrade' => 'bg-info'
                                            ][$jenis] ?? 'bg-secondary';
                                            $label = [
                                                'baru' => 'Pemasangan Baru',
                                                'perbaikan' => 'Perbaikan',
                                                'upgrade' => 'Upgrade'
                                            ][$jenis] ?? 'Tidak Diketahui';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                                    </td>

                                    <td class="py-3">
                                        {{ $item->paket->nama_paket ?? '-' }}
                                    </td>

                                    <td class="py-3">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pemasangan)->format('d M Y') }}
                                    </td>

                                    <td class="py-3">
                                        {{ $item->catatan ?? '-' }}
                                    </td>

                                    <td class="py-3 text-center">
                                        <a href="{{ route('teknisi.detail-pemasangan', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        Tidak ada jadwal pemasangan.
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


{{-- Modal Tambah Jadwal --}}
<div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-labelledby="tambahJadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('teknisi.jadwal-pemasangan.simpan') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal Pemasangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- Jenis Pemasangan --}}
                    <div class="mb-3">
                        <label class="form-label">Jenis Pemasangan</label>
                        <select name="jenis_pemasangan" class="form-select" required>
                            <option value="" disabled selected>Pilih Jenis Pemasangan</option>
                            <option value="baru">Pemasangan Baru</option>
                            <option value="perbaikan">Perbaikan</option>
                            <option value="upgrade">Upgrade</option>
                        </select>
                    </div>

                    {{-- Pelanggan --}}
                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <select name="pemesanan_id" class="form-select" required id="pelangganSelect">
                            <option value="" disabled selected>Pilih Pelanggan</option>
                           @foreach ($pemasangan as $p)
                                <option value="{{ $p->id }}" 
                                    data-alamat="{{ $p->pelanggan->alamat ?? '' }}"
                                    data-kelurahan="{{ $p->pelanggan->kelurahan ?? '' }}"
                                    data-kecamatan="{{ $p->pelanggan->kecamatan ?? '' }}">
                                    {{ $p->pelanggan->nama }} — ({{ $p->paket->nama_paket }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hanya pelanggan yang sudah membayar.</small>
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-3">
                        <label class="form-label">Lokasi Pemasangan</label>
                        <div class="card bg-light">
                            <div class="card-body py-2">
                                <div id="lokasiDisplay" class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Pilih pelanggan terlebih dahulu untuk melihat lokasi
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pemasangan</label>
                        <input type="date" name="tanggal_pemasangan" class="form-control" required>
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan (opsional)</label>
                        <textarea name="catatan" rows="2" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan Jadwal</button>
                </div>

            </form>

        </div>
    </div>
</div>

<style>
    .table th {
        font-weight: 600;
        color: #495057;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table td { 
        font-size: 0.9rem; 
        vertical-align: middle; 
    }
    
    /* Filter buttons */
    .filter-btn.active {
        background-color: var(--bs-primary);
        color: white;
        border-color: var(--bs-primary);
    }
    
    /* Badge styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    
    /* Lokasi display */
    #lokasiDisplay {
        font-size: 0.9rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('tbody tr[data-jenis]');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter table rows
            const filterValue = this.getAttribute('data-filter');
            
            tableRows.forEach(row => {
                if (filterValue === 'all' || row.getAttribute('data-jenis') === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
    
    // Display location when pelanggan is selected
    const pelangganSelect = document.getElementById('pelangganSelect');
    const lokasiDisplay = document.getElementById('lokasiDisplay');
    
    pelangganSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            const alamat = selectedOption.getAttribute('data-alamat');
            const kelurahan = selectedOption.getAttribute('data-kelurahan');
            const kecamatan = selectedOption.getAttribute('data-kecamatan');
            
            let lokasiText = `<i class="bi bi-geo-alt-fill text-danger me-2"></i>`;
            lokasiText += `<strong>${alamat}</strong>`;
            
            if (kelurahan) {
                lokasiText += `<br><small class="text-muted">${kelurahan}, ${kecamatan}</small>`;
            }
            
            lokasiDisplay.innerHTML = lokasiText;
        } else {
            lokasiDisplay.innerHTML = '<i class="bi bi-info-circle me-1"></i>Pilih pelanggan terlebih dahulu untuk melihat lokasi';
        }
    });
});
</script>
@endsection