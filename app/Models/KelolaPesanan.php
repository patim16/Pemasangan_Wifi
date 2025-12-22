<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'paket_id',
        'alamat',
        'patokan',
        'catatan',
        'latitude',
        'longitude',
        'invoice_code',
        'status',
        'ktp',
        'nik',
        'total_bayar',
    ];

    // RELASI KE USER (PELANGGAN)
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // RELASI KE PAKET
    public function paket()
    {
        return $this->belongsTo(PaketLayanan::class, 'paket_id');
    }
}
