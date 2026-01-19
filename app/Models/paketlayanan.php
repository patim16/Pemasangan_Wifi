<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pemesanan;

class PaketLayanan extends Model
{
    protected $fillable = [
    'nama_paket',
    'kecepatan',
    'harga',
    'biaya_pemasangan', // 👈 TAMBAH INI
    'deskripsi',
];

     // RELASI KE PEMESANAN
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'paket_id');
    }


}
 



   