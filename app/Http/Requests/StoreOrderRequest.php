<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Bisa kamu sesuaikan dengan logic authorization jika diperlukan
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'alamat' => 'required|string',
            'rincian_pemesanan' => 'required|string',
            'pilihan_cod' => 'boolean',
            'status_order' => 'nullable|in:selesai,belum_selesai',
        ];
    }
}
