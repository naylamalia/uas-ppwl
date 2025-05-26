<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Sesuaikan jika perlu otorisasi
    }

    public function rules()
    {
        return [
            'code' => [
                'required',
                'string',
                'max:255',
                // unique di tabel products tapi kecuali record yang sedang diupdate
                Rule::unique('products', 'code')->ignore($this->route('product')),
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => [
                'required',
                Rule::in(['Samsung','Apple','Xiaomi','Vivo','Oppo','LG','Infinix','Itel','Realme','Poco']),
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Kode produk harus diisi.',
            'code.unique' => 'Kode produk sudah digunakan oleh produk lain.',
            'name.required' => 'Nama produk harus diisi.',
            'price.required' => 'Harga produk harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'stock.required' => 'Stok produk harus diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'category.required' => 'Kategori produk harus dipilih.',
            'category.in' => 'Kategori tidak valid.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
