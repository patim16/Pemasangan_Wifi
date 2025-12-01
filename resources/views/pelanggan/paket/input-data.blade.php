@extends('layout.app')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@section('content')

<div class="container mt-4">

    <h2 class="fw-bold mb-3">Input Data Instalasi</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('pelanggan.inputdata.simpan', $paket_id) }}" method="POST">
                @csrf
                <h5 class="fw-bold mb-2">Tentukan Lokasi Pemasangan</h5>

     <div id="map" style="height: 350px;" class="mb-3"></div>

       <input type="text" id="lat" name="latitude" class="form-control mb-2" placeholder="Latitude" readonly>
        <input type="text" id="lng" name="longitude" class="form-control mb-3" placeholder="Longitude" readonly>


                <div class="mb-3">
                    <label class="fw-bold">Alamat Lengkap</label>
                    <textarea class="form-control" name="alamat" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Patokan Lokasi (Opsional)</label>
                    <input type="text" name="patokan" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Catatan Tambahan (Opsional)</label>
                    <textarea class="form-control" name="catatan" rows="2"></textarea>
                </div>

                <button class="btn btn-primary mt-2">Lanjut ke Invoice</button>
            </form>

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
