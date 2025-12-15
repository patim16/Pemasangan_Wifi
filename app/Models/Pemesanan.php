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
        'status',
        'invoice_code',

        'jadwal_survei',
        'jadwal_instalasi',
        'laporan_teknisi',
        'alasan_penolakan',

        'pelanggan_id',
        'teknisi_id',
    ];

  
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function paket()
    {
        return $this->belongsTo(PaketLayanan::class, 'paket_id');
    }

    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'pesanan_id');
    }

    protected $casts = [
        'jadwal_survei' => 'datetime',
        'jadwal_instalasi' => 'datetime',
    ];
}
