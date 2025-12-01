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
    ];
}

