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
        'jadwal_survei',
        'jadwal_instalasi',
        'laporan_teknisi',
        'alasan_penolakan',
    ];

    protected $casts = [
        'jadwal_survei' => 'datetime',
        'jadwal_instalasi' => 'datetime',
    ];

    // 🔹 pelanggan (user yang memesan)
    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 teknisi yang ditugaskan
    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    // 🔹 paket layanan
    public function paket()
    {
        return $this->belongsTo(PaketLayanan::class, 'paket_id');
    }

    // 🔹 tagihan (optional)
    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'pesanan_id');
    }
}
