<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelolaPesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan'; // nama table di database

    protected $fillable = [
        'pelanggan_id',
        'paket_id',
        'status',
        'alasan_penolakan',
        'jadwal_instalasi',
    ];

    // public function pelanggan()
    // {
    //     return $this->belongsTo(User::class, 'pelanggan_id');
    // }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paket()
    {
        return $this->belongsTo(PaketLayanan::class, 'paket_id');
    }
}
