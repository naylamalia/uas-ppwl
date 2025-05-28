<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
    return $this->user() && $this->user()->is_admin;
    }

    public function rules()
    {
        return [
            'quantity' => 'sometimes|integer|min:1',
            'alamat' => 'sometimes|string',
            'rincian_pemesanan' => 'sometimes|string',
            'pilihan_cod' => 'sometimes|boolean',
            'status_order' => 'sometimes|in:selesai,belum_selesai',
            // biasanya product_id dan price tidak diubah saat update order, tapi kalau mau:
            // 'product_id' => 'sometimes|exists:products,id',
        ];
    }
}
