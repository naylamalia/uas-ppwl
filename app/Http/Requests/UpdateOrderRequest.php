<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'alamat' => 'sometimes|required|string',
            'rincian_pemesanan' => 'sometimes|required|string',
            'pilihan_cod' => 'sometimes|boolean',
            'status_order' => 'sometimes|in:selesai,belum_selesai',
        ];
    }
}
