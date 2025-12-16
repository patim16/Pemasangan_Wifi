<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';

    protected $fillable = [
        'pesanan_id',
        'pelanggan_id',
        'paket_id',
        'metode_pembayaran_id',
        'nominal',
        'nomor_pembayaran',
        'bukti_pembayaran',
        'status',
        'alasan_penolakan',
    ];

    // RELASI KE PEMESANAN
    public function pesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pesanan_id');
    }

    // RELASI KE USER
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    // RELASI KE PAKET
    public function paket()
    {
        return $this->belongsTo(PaketLayanan::class, 'paket_id');
    }

    // RELASI KE METODE PEMBAYARAN
    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran_id');
    }
}
