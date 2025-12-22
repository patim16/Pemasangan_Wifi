<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'paket_id',
        'teknisi_id',
        'alamat',
        'patokan',
        'catatan',
        'latitude',
        'longitude',
        'status',
        'invoice_code',
        'total_bayar',
        'jadwal_survei',
        'jadwal_instalasi',
        'laporan_teknisi',
        'alasan_penolakan',

    ];

    protected $casts = [
        'jadwal_survei' => 'datetime',
        'jadwal_instalasi' => 'datetime',
    ];

       
    

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paket()
    {
        return $this->belongsTo(\App\Models\PaketLayanan::class, 'paket_id');
    }

    public function tagihan()
    {
        return $this->hasOne(\App\Models\Tagihan::class, 'pesanan_id');
    }

    public function teknisi()
{
    return $this->belongsTo(User::class, 'teknisi_id');
}



}
