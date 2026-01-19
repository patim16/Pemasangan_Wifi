<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PaketLayanan;
use App\Models\MetodePembayaran;


class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'pelanggan_id',
        'paket_id',
        'total',
        'bukti',
        'status',
        'metode_pembayaran_id',
        'alasan_penolakan',
        'jenis',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function paket()
    {
        return $this->belongsTo(PaketLayanan::class, 'paket_id');
    }
    public function metodePembayaran()
{
    return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran_id');
}


    
}

