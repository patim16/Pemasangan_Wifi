<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    protected $table = 'metode_pembayaran';

    protected $fillable = [
        'nama_metode',
        'deskripsi',
        'icon',
        'nomor_pembayaran',
        'status',
    ];

      public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'metode_pembayaran_id');
    }
}
