<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id', // <-- Pastikan ini benar
        'price',
        'order_date',
        'alamat',
        'rincian_pemesanan',
        'pilihan_cod',
        'status_order',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'pilihan_cod' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Relasi ke User (pemesan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke Product melalui order_items
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')
            ->withPivot(['quantity', 'price']);
    }

    // Accessor untuk alamat: jika kosong, ambil dari customer via user
    public function getAlamatAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }
        // Akses customer via user
        return optional($this->user->customer)->address ?? '';
    }
}