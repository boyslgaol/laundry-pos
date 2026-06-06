<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $fillable = ['kode_transaksi', 'pelanggan_id', 'layanan_id', 'berat_kg', 'total_harga', 'status', 'tanggal_ambil'];
    protected $casts = [
        'tanggal_ambil' => 'date',
        'berat_kg' => 'decimal:2',
        'total_harga' => 'decimal:2'
    ];
    
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }
    
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }
    
    protected static function booted()
    {
        static::creating(function ($transaksi) {
            $transaksi->kode_transaksi = 'TRX' . date('Ymd') . rand(100, 999);
        });
    }
}