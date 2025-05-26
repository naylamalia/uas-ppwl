<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Daftar atribut yang bisa diisi (mass assignable)
    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
    ];

    // Konstanta kategori (opsional, bisa dipakai untuk form dropdown atau validasi)
    public const CATEGORIES = [
        'Samsung',
        'Apple',
        'Xiaomi',
        'Vivo',
        'Oppo',
        'LG',
        'Infinix',
        'Itel',
        'Realme',
        'Poco',
    ];

    // Relasi ke Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
