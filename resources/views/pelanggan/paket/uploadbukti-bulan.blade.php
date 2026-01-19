@extends('layout.app')

@section('content')
<style>
    /* Clean Blue Theme - Same as Other Pages */
    .page-header {
        background-color: #0066cc;
        color: white;
        padding: 2.5rem 0;
        margin-bottom: 2rem;
    }
    
    .upload-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .upload-card:hover {
        transform: translateY(-5px);
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        color: white;
        padding: 25px;
        border: none;
    }
    
    .card-header-custom h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .card-header-custom h5 i {
        margin-right: 10px;
    }
    
    .card-body-custom {
        padding: 40px;
    }
    
    .info-box {
        background-color: #f0f7ff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .info-item:last-child {
        margin-bottom: 0;
    }
    
    .info-label {
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
    }
    
    .info-label i {
        margin-right: 8px;
        color: #0066cc;
    }
    
    .info-value {
        font-weight: 700;
        color: #1f2937;
        font-size: 1.1rem;
    }
    
    .amount-value {
        color: #10b981;
        font-size: 1.3rem;
    }
    
    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        color: #0066cc;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }
    
    .form-label i {
        margin-right: 8px;
        color: #0066cc;
    }
    
    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        outline: none;
    }
    
    .file-upload {
        position: relative;
        display: block;
    }
    
    .file-upload input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 10;
    }
    
    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background-color: #f8fafc;
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .file-upload-label:hover {
        border-color: #0066cc;
        background-color: #f0f7ff;
    }
    
    .file-upload-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }
    
    .file-upload-text {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .btn-upload {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .upload-instructions {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    
    .upload-instructions h6 {
        color: #92400e;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .upload-instructions ul {
        margin: 0;
        padding-left: 20px;
        color: #78350f;
        font-size: 0.9rem;
    }
    
    .upload-instructions li {
        margin-bottom: 5px;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-cloud-upload-alt me-3"></i>Upload Bukti Pembayaran
                    </h2>
                    <p class="mb-0 opacity-90">Upload bukti transfer untuk menyelesaikan pembayaran</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-receipt me-1"></i>
                            {{ $tagihan->invoice_code }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="upload-card">
            <div class="card-body-custom">
                <!-- Invoice Information iniii bulanan -->
                <div class="info-box">
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-file-invoice"></i>
                            Nomor Invoice
                        </span>
                        <span class="info-value">{{ $tagihan->invoice_code }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-money-bill-wave"></i>
                            Nominal Tagihan
                        </span>
                        <span class="info-value amount-value">Rp {{ number_format($tagihan->nominal,0,',','.') }}</span>
                    </div>
                </div>

                <!-- Upload Instructions -->
                <div class="upload-instructions">
                    <h6>
                        <i class="fas fa-info-circle me-2"></i>
                        Petunjuk Upload
                    </h6>
                    <ul>
                        <li>Format file: JPG, PNG, atau PDF</li>
                        <li>Ukuran maksimal: 2MB</li>
                        <li>Pastikan bukti transfer jelas terbaca</li>
                        <li>Nomor rekening dan nominal harus sesuai</li>
                    </ul>
                </div>

                <!-- Upload Form -->
                <form method="POST"
                    action="{{ route('pelanggan.tagihan.bulanan.storeupload', $tagihan->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <h5 class="section-title">
                        <i class="fas fa-upload"></i>
                        Upload Bukti Transfer
                    </h5>

                    <div class="form-group">
                        <div class="file-upload">
                            <input type="file" 
                                   name="bukti_pembayaran" 
                                   class="form-control" 
                                   accept="image/*,.pdf" 
                                   required
                                   id="fileInput">
                            <label for="fileInput" class="file-upload-label">
                                <div class="file-upload-icon">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <div class="file-upload-text">
                                    <strong>Klik untuk upload bukti transfer</strong><br>
                                    <small>atau drag and drop file ke sini</small>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-upload">
                        <i class="fas fa-paper-plane me-2"></i>
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// File upload preview
document.getElementById('fileInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const label = document.querySelector('.file-upload-label');
    
    if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        
        label.querySelector('.file-upload-text').innerHTML = `
            <strong>${fileName}</strong><br>
            <small>Ukuran: ${fileSize} MB</small>
        `;
        
        // Add success visual feedback
        label.style.borderColor = '#10b981';
        label.style.backgroundColor = '#d1fae5';
    }
});

// Drag and drop functionality
const dropZone = document.querySelector('.file-upload-label');
const fileInput = document.getElementById('fileInput');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => {
        dropZone.style.borderColor = '#0066cc';
        dropZone.style.backgroundColor = '#f0f7ff';
    });
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => {
        dropZone.style.borderColor = '#d1d5db';
        dropZone.style.backgroundColor = '#f8fafc';
    });
});

dropZone.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        const event = new Event('change', { bubbles: true });
        fileInput.dispatchEvent(event);
    }
});
</script>

@endsection