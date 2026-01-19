@extends('layout.app')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@section('content')
<style>
    /* Clean Blue Theme - Same as Other Pages */
    .page-header {
        background-color: #0066cc;
        color: white;
        padding: 2.5rem 0;
        margin-bottom: 2rem;
    }
    
    .installation-card {
        border: 1px solid #e3e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .installation-card:hover {
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
        padding: 30px;
    }
    
    #map {
        border-radius: 12px;
        border: 2px solid #e3e8f0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }
    
    .coordinates-inputs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }
    
    .coordinate-input {
        position: relative;
    }
    
    .coordinate-input label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
        font-size: 0.9rem;
    }
    
    .coordinate-input .input-group {
        position: relative;
    }
    
    .coordinate-input .input-group-text {
        background-color: #f8fafc;
        border: 1px solid #e5e7eb;
        border-right: none;
        color: #0066cc;
        border-radius: 10px 0 0 10px;
    }
    
    .coordinate-input .form-control {
        border: 1px solid #e5e7eb;
        border-left: none;
        border-radius: 0 10px 10px 0;
        padding: 12px 15px;
        background-color: #f8fafc;
        font-weight: 500;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }
    
    .form-group label i {
        margin-right: 8px;
        color: #0066cc;
    }
    
    .form-control {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        outline: none;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 102, 204, 0.3);
        color: white;
    }
    
    .map-instructions {
        background-color: #f0f7ff;
        border-left: 4px solid #0066cc;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .map-instructions h6 {
        color: #0066cc;
        margin-bottom: 8px;
        font-weight: 600;
    }
    
    .map-instructions p {
        margin: 0;
        color: #475569;
        font-size: 0.9rem;
    }
    
    .required-field {
        color: #ef4444;
        margin-left: 4px;
    }
    
    .optional-field {
        color: #6b7280;
        font-size: 0.85rem;
        font-weight: 400;
        margin-left: 8px;
    }
</style>

<div class="container-fluid p-0">
    <!-- Clean Blue Header - Same Style as Other Pages -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-map-marked-alt me-3"></i>Input Data Instalasi
                    </h2>
                    <p class="mb-0 opacity-90">Tentukan lokasi dan detail pemasangan WiFi</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-white text-blue px-3 py-2">
                            <i class="fas fa-tools me-1"></i>
                            Tahap Instalasi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="installation-card">
                    <div class="card-header-custom">
                        <h5>
                            <i class="fas fa-map-pin"></i>
                            Tentukan Lokasi Pemasangan
                        </h5>
                    </div>

                    <div class="card-body-custom">
                        <form action="{{ route('pelanggan.inputdata.simpan', $paket_id) }}" method="POST">
                            @csrf

                            <!-- Map Instructions -->
                            <div class="map-instructions">
                                <h6>
                                    <i class="fas fa-info-circle me-2"></i>
                                    Petunjuk Pemilihan Lokasi
                                </h6>
                                <p>Klik dan seret marker pada peta untuk menentukan lokasi pemasangan yang tepat</p>
                            </div>

                            <!-- Map Container -->
                            <div id="map" style="height: 400px;"></div>

                            <!-- Coordinate Inputs -->
                            <div class="coordinates-inputs">
                                <div class="coordinate-input">
                                    <label for="lat">
                                        <i class="fas fa-globe"></i>
                                        Latitude
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <input type="text" 
                                               id="lat" 
                                               name="latitude" 
                                               class="form-control" 
                                               placeholder="Latitude" 
                                               readonly>
                                    </div>
                                </div>

                                <div class="coordinate-input">
                                    <label for="lng">
                                        <i class="fas fa-globe"></i>
                                        Longitude
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <input type="text" 
                                               id="lng" 
                                               name="longitude" 
                                               class="form-control" 
                                               placeholder="Longitude" 
                                               readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="form-group">
                                <label for="alamat">
                                    <i class="fas fa-home"></i>
                                    Alamat Lengkap
                                    <span class="required-field">*</span>
                                </label>
                                <textarea class="form-control" 
                                          name="alamat" 
                                          rows="3" 
                                          placeholder="Masukkan alamat lengkap lokasi pemasangan"
                                          required></textarea>
                            </div>

                            <!-- Patokan Lokasi -->
                            <div class="form-group">
                                <label for="patokan">
                                    <i class="fas fa-flag"></i>
                                    Patokan Lokasi
                                    <span class="optional-field">(Opsional)</span>
                                </label>
                                <input type="text" 
                                       name="patokan" 
                                       class="form-control" 
                                       placeholder="Contoh: Dekat masjid, depan toko, dll">
                            </div>

                            <!-- Catatan Tambahan -->
                            <div class="form-group">
                                <label for="catatan">
                                    <i class="fas fa-sticky-note"></i>
                                    Catatan Tambahan
                                    <span class="optional-field">(Opsional)</span>
                                </label>
                                <textarea class="form-control" 
                                          name="catatan" 
                                          rows="2" 
                                          placeholder="Informasi tambahan yang perlu diketahui teknisi"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-arrow-right me-2"></i>
                                Lanjut ke Invoice
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Lokasi default awal: Panjalu, Ciamis
    var defaultLat = -7.2121;
    var defaultLng = 108.3674;

    // Inisialisasi map
    var map = L.map('map').setView([defaultLat, defaultLng], 15);

    // Peta dari OpenStreetMap (GRATIS)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Marker draggable
    var marker = L.marker([defaultLat, defaultLng], {
        draggable: true
    }).addTo(map);

    // Update koordinat saat marker digeser
    marker.on('dragend', function (e) {
        var pos = marker.getLatLng();
        document.getElementById('lat').value = pos.lat;
        document.getElementById('lng').value = pos.lng;
    });

    // Isi awal
    document.getElementById('lat').value = defaultLat;
    document.getElementById('lng').value = defaultLng;
</script>

@endsection