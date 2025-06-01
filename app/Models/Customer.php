<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Tambahkan field yang boleh diisi secara mass assignment
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        // tambahkan field lain jika ada di tabel customers
    ];

    // Jika ada relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}