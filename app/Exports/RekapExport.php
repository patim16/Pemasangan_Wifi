<?php

namespace App\Exports;

use App\Models\Transaksi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    WithEvents,
    WithColumnFormatting,
    WithCustomStartCell
};
use Maatwebsite\Excel\Events\AfterSheet;

class RekapExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithEvents,
    WithColumnFormatting,
    WithCustomStartCell
{
    protected $start;
    protected $end;

    // 🔥 TOTAL DIHITUNG DI PHP
    protected int $grandTotal = 0;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    /* ================= DATA ================= */
    public function collection()
    {
        return Transaksi::with(['pelanggan', 'paket'])
            ->where('status', 'lunas')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->orderBy('created_at')
            ->get();
    }

    /* ================= START CELL ================= */
    public function startCell(): string
    {
        return 'A6';
    }

    /* ================= HEADER ================= */
    public function headings(): array
    {
        return [
            'Pelanggan',
            'Paket',
            'Total Pembayaran',
            'Tanggal',
            'Status',
        ];
    }

    /* ================= MAP DATA ================= */
    public function map($trx): array
    {
        $amount = (int) ($trx->total ?? $trx->nominal ?? 0);

        // ✅ HITUNG TOTAL DI PHP (BUKAN EXCEL)
        $this->grandTotal += $amount;

        return [
            $trx->pelanggan?->nama ?? '-',
            $trx->paket?->nama_paket ?? '-',
            $amount, // angka murni
            Carbon::parse($trx->created_at)->format('d/m/Y'),
            ucfirst($trx->status),
        ];
    }

    /* ================= FORMAT KOLOM ================= */
    public function columnFormats(): array
    {
        return [
            'C' => '"Rp"#,##0;-"Rp"#,##0',
        ];
    }

    /* ================= STYLING & TOTAL ================= */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $totalRow = $lastRow + 1;

                // ===== JUDUL =====
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', 'LAPORAN REKAP TRANSAKSI');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // ===== PERIODE =====
                $sheet->mergeCells('A2:E2');
                $sheet->setCellValue(
                    'A2',
                    'Periode: ' .
                    Carbon::parse($this->start)->format('d M Y') .
                    ' - ' .
                    Carbon::parse($this->end)->format('d M Y')
                );
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // ===== HEADER STYLE =====
                $sheet->getStyle('A6:E6')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => 'solid',
                        'color' => ['rgb' => 'E5E7EB'],
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => 'thin'],
                    ],
                ]);

                // ===== BORDER DATA =====
                $sheet->getStyle("A6:E{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle('thin');

                // ===== TOTAL (TANPA SUM EXCEL) =====
                $sheet->mergeCells("A{$totalRow}:B{$totalRow}");
                $sheet->setCellValue("A{$totalRow}", 'TOTAL');
                $sheet->setCellValue("C{$totalRow}", $this->grandTotal);

                $sheet->getStyle("A{$totalRow}:E{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'borders' => [
                        'top' => ['borderStyle' => 'thick'],
                    ],
                ]);

                // ===== AUTO WIDTH =====
                foreach (range('A', 'E') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
