<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Transaksi</title>
    <style>
        @page {
            margin: 1cm;
            size: A4;
        }
        
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.5;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4361ee;
        }
        
        .header h2 {
            margin: 0;
            color: #4361ee;
            font-size: 24px;
            font-weight: 700;
        }
        
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        
        .summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-left: 4px solid #4361ee;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .summary-row:last-child {
            margin-bottom: 0;
            font-weight: 600;
            font-size: 16px;
            color: #4361ee;
        }
        
        .summary-label {
            color: #555;
        }
        
        .summary-value {
            font-weight: 600;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th {
            background-color: #4361ee;
            color: white;
            text-align: left;
            padding: 12px 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            min-width: 100px;
        }
        
        .status-terverifikasi {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-ditolak {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #888;
            font-size: 12px;
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
        }
        
        .amount {
            text-align: right;
            font-weight: 600;
        }
        
        .date {
            color: #666;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Rekap Transaksi</h2>
    <p>Laporan Keuangan Sistem Pembayaran</p>
</div>

<div class="summary">
    <div class="summary-row">
        <span class="summary-label">Rentang Waktu:</span>
        <span class="summary-value">{{ $start }} — {{ $end }}</span>
    </div>
    <div class="summary-row">
        <span class="summary-label">Total Pendapatan:</span>
        <span class="summary-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th style="width: 25%;">Pelanggan</th>
            <th style="width: 20%;">Paket</th>
            <th style="width: 15%;">Total</th>
            <th style="width: 15%;">Status</th>
            <th style="width: 25%;">Tanggal</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $t)
        <tr>
            <td>{{ $t->pelanggan->nama }}</td>
            <td>{{ $t->paket->nama }}</td>
            <td class="amount">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
            <td>
                <span class="status status-{{ strtolower(str_replace(' ', '-', $t->status)) }}">
                    {{ $t->status }}
                </span>
            </td>
            <td class="date">{{ $t->created_at->format('d F Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <p>Dicetak pada: {{ date('d F Y H:i') }} | Sistem Pembayaran v1.0</p>
</div>

</body>
</html>