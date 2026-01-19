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
    <div><span class="label">Kode Invoice:</span> {{ $pesanan->invoice_code }}</div>
    <div><span class="label">Tanggal:</span> {{ $pesanan->created_at->format('d-m-Y') }}</div>
</div>

<hr>

<div class="section">
    <div><span class="label">Alamat:</span> {{ $pesanan->alamat }}</div>
    <div><span class="label">Patokan:</span> {{ $pesanan->patokan }}</div>
    <div><span class="label">Catatan:</span> {{ $pesanan->catatan }}</div>
</div>

<hr>

<div class="section">
    <div><span class="label">Latitude:</span> {{ $pesanan->latitude }}</div>
    <div><span class="label">Longitude:</span> {{ $pesanan->longitude }}</div>
</div>

</body>
</html>
