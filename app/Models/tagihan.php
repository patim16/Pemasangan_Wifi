<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';

    protected $fillable = [
        'invoice_code',
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

    public function pesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pesanan_id');
    }

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tagihan) {

            if (!$tagihan->invoice_code) {

                $nextId = (self::max('id') ?? 0) + 1;

                $tagihan->invoice_code =
                    'INV-' . date('Y') . '-' .
                    str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
            
        });
    }
    public function transaksi()
{
    return $this->hasOne(Transaksi::class); // atau hasMany tergantung relasi
}

    
}
