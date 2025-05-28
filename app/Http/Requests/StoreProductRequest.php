<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Atur sesuai kebutuhan autentikasi/otorisasi
    }

    public function rules()
    {
        return [
            // 'code' dihapus dari rules, karena diisi otomatis di controller
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:Samsung,Apple,Xiaomi,Vivo,Oppo,LG,Infinix,Itel,Realme,Poco',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            // 'code' messages dihapus
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