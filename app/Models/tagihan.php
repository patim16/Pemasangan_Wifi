<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function pesanan() {
        return $this->belongsTo(KelolaPesanan::class, 'pesanan_id');
    }

    public function pelanggan() {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function paket() {
        return $this->belongsTo(PaketLayanan::class, 'paket_id');
    }

    public function metodePembayaran() {
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran_id');
    }
}
