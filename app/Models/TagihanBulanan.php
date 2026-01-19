<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TagihanBulanan extends Model
{
    protected $table = 'tagihan_bulanan';

    // const STATUS_BELUM_BAYAR = 'belum_bayar';
    // const STATUS_DIKIRIM = 'dikirim';
    // const STATUS_MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';
    // const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    // const STATUS_DITOLAK = 'ditolak';
    // const STATUS_LUNAS = 'lunas';

    protected $fillable = [
        'invoice_code',             
        'pelanggan_id',
        'paket_id',
        'bulan',
        'tanggal_pesan',
        'nominal',
        'jatuh_tempo',
        'tanggal_bayar',
        'status',
        'bukti_pembayaran',
        'alasan_penolakan'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function paket()
    {
        return $this->belongsTo(PaketLayanan::class, 'paket_id');
    }

}
