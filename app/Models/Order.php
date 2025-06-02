<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Nama tabel (opsional, kalau sudah sesuai dengan nama model + s biasanya tidak perlu)
    protected $table = 'orders';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'price',
        'order_date',
        'alamat',
        'rincian_pemesanan',
        'pilihan_cod',
        'status_order',
    ];

    // Jika ingin otomatis meng-cast tipe data tertentu
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
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')
            ->withPivot(['quantity', 'price']);
    }
}
