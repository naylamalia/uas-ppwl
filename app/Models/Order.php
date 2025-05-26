<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'alamat',
        'rincian_pemesanan',
        'pilihan_cod',
        'status_order', // jangan lupa masukkan ini agar bisa diisi massal
    ];

    /**
     * Relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel products.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
