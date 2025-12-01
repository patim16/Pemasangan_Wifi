<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Cetak</title>
    <style>
        body { font-family: sans-serif; }
        .title { font-size: 22px; font-weight: bold; margin-bottom: 20px; }
        .section { margin-bottom: 12px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>

    <div class="title">INVOICE PEMASANGAN WIFI</div>

    <div class="section">
        <div><span class="label">Kode Invoice:</span> {{ $invoice->invoice_code }}</div>
        <div><span class="label">Tanggal:</span> {{ $invoice->created_at->format('d-m-Y') }}</div>
    </div>

    <hr>

    <div class="section">
        <div><span class="label">Alamat:</span> {{ $invoice->alamat }}</div>
        <div><span class="label">Patokan:</span> {{ $invoice->patokan }}</div>
        <div><span class="label">Catatan:</span> {{ $invoice->catatan }}</div>
    </div>

    <hr>

    <div class="section">
        <div><span class="label">Latitude:</span> {{ $invoice->latitude }}</div>
        <div><span class="label">Longitude:</span> {{ $invoice->longitude }}</div>
    </div>
<!-- Tombol Cetak PDF -->
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('pelanggan.invoice.cetak', $paket_id) }}" class="btn-cetak">
            <i class="fas fa-file-pdf"></i> Cetak PDF
        </a>
    </div>


</body>
</html>
