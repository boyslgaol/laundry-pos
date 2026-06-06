<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    protected $table = 'layanans';
    protected $fillable = ['nama', 'harga_per_kg'];
    
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}