<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapExport implements FromCollection, WithHeadings, WithMapping
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    public function collection()
    {
        return Transaksi::with(['pelanggan', 'paket'])
            ->whereBetween('created_at', [$this->start, $this->end])
            ->where('status', 'terverifikasi')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Pelanggan',
            'Paket',
            'Total Pembayaran',
            'Tanggal Transaksi',
            'Status'
        ];
    }

    public function map($trx): array
    {
        return [
            $trx->pelanggan->nama,
            $trx->paket->nama,
            'Rp ' . number_format($trx->total, 0, ',', '.'),
            $trx->created_at->format('d/m/Y'),
            ucfirst($trx->status)
        ];
    }
}
