<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: left; }
        th { background: #eaeaea; }
    </style>
</head>
<body>

    <h2>
        Rekap Transaksi 
        @if($mode == 'harian')
            Tanggal {{ $tanggal }}
        @else
            Bulan {{ $bulan }}
        @endif
    </h2>

    <table>
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Paket</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $t)
            <tr>
                <td>{{ $t->pelanggan->nama }}</td>
                <td>{{ $t->paket->nama }}</td>
                <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                <td>{{ $t->status }}</td>
                <td>{{ $t->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
