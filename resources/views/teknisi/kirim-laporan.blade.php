@extends('layout.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <div class="row">
        <div class="col-12">
            {{-- Header --}}
            <div class="mb-4">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-clipboard-check text-primary me-2"></i>
                    Kirim Laporan Instalasi
                </h4>
                <p class="text-muted mb-0">Lengkapi formulir dengan data yang sesuai</p>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('teknisi.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Pilih Instalasi --}}
                <div class="mb-3">
                    <label for="instalasi_id" class="form-label fw-semibold">
                        Pilih Instalasi <span class="text-danger">*</span>
                    </label>
                    <select name="instalasi_id" id="instalasi_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Instalasi --</option>
                       @foreach(($instalasi ?? []) as $item)
                       
                        <option value="{{ $item->id }}">
                            #{{ $item->id }} - {{ $item->alamat }} ({{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Pekerjaan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Status Pekerjaan <span class="text-danger">*</span>
                    </label>
                    <div class="row g-2">
                        <div class="col-4">
                            <input class="btn-check" type="radio" name="status" id="statusSelesai" value="selesai" required>
                            <label class="btn btn-outline-success w-100 py-2" for="statusSelesai">
                                <i class="bi bi-check-circle d-block mb-1"></i>
                                <small class="fw-semibold">Selesai</small>
                            </label>
                        </div>
                        <div class="col-4">
                            <input class="btn-check" type="radio" name="status" id="statusBelum" value="belum">
                            <label class="btn btn-outline-warning w-100 py-2" for="statusBelum">
                                <i class="bi bi-hourglass-split d-block mb-1"></i>
                                <small class="fw-semibold">Proses</small>
                            </label>
                        </div>
                        <div class="col-4">
                            <input class="btn-check" type="radio" name="status" id="statusGagal" value="gagal">
                            <label class="btn btn-outline-danger w-100 py-2" for="statusGagal">
                                <i class="bi bi-x-circle d-block mb-1"></i>
                                <small class="fw-semibold">Gagal</small>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="mb-3">
                    <label for="catatan" class="form-label fw-semibold">
                        Catatan
                    </label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                </div>

                {{-- Upload Bukti --}}
                <div class="mb-4">
                    <label for="bukti" class="form-label fw-semibold">
                        Upload Bukti Foto <span class="text-danger">*</span>
                    </label>
                    <div class="upload-box border rounded p-3 text-center bg-light">
                        <input type="file" name="bukti" id="bukti" class="form-control d-none" required accept="image/*">
                        <label for="bukti" class="d-block mb-0 cursor-pointer">
                            <i class="bi bi-cloud-arrow-up fs-2 text-primary"></i>
                            <p class="mb-0 mt-2"><small>Klik untuk upload foto</small></p>
                            <small class="text-muted">JPG, PNG (Max 5MB)</small>
                        </label>
                    </div>
                    <div id="preview-container" class="mt-2 d-none">
                        <div class="position-relative d-inline-block">
                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" id="remove-preview">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i> Kirim Laporan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    .form-select:focus,
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .btn-check:checked + label {
        transform: scale(1.02);
    }

    .upload-box {
        border: 2px dashed #dee2e6 !important;
        transition: all 0.2s;
    }

    .upload-box:hover {
        border-color: #667eea !important;
        background: #f0f2ff !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    @media (max-width: 576px) {
        .btn-outline-success small,
        .btn-outline-warning small,
        .btn-outline-danger small {
            font-size: 0.75rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('bukti');
        const previewContainer = document.getElementById('preview-container');
        const previewImg = document.getElementById('preview-img');
        const removeBtn = document.getElementById('remove-preview');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        removeBtn.addEventListener('click', function() {
            fileInput.value = '';
            previewContainer.classList.add('d-none');
            previewImg.src = '';
        });
    });
</script>
@endsection