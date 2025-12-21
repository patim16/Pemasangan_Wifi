<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagihanBulanan extends Model
{
    protected $table = 'tagihan_bulanan';

    protected $fillable = [
        'pelanggan_id',
        'paket_id',
        'bulan',
        'nominal',
        'jatuh_tempo',
        'tanggal_bayar',
        'status',
        'bukti_pembayaran',
        'alasan_penolakan'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function paket()
    {
        return $this->belongsTo(PaketLayanan::class, 'paket_id');
    }

}
