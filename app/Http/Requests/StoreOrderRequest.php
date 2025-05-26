<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Atur kalau mau cek authorization juga
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'alamat' => 'required|string',
            'rincian_pemesanan' => 'required|string',
            'pilihan_cod' => 'boolean',
            'status_order' => 'in:selesai,belum_selesai',
        ];
    }
}
