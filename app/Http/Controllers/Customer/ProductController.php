<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan daftar produk ke customer dengan filter dan validasi sederhana
    public function index(Request $request)
    {
        $query = \App\Models\Product::query();

        // Filter nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter harga
        if ($request->filled('price')) {
            switch ($request->price) {
                case '1':
                    $query->whereBetween('price', [1000000, 5000000]);
                    break;
                case '2':
                    $query->whereBetween('price', [6000000, 10000000]);
                    break;
                case '3':
                    $query->whereBetween('price', [11000000, 15000000]);
                    break;
                case '4':
                    $query->where('price', '>', 15000000);
                    break;
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        // Ambil kategori unik untuk filter
        $categories = \App\Models\Product::select('category')->distinct()->pluck('category');

        return view('customer.products.index', compact('products', 'categories'));
    }

    // Tampilkan detail produk beserta review dan usernya
    public function show($id)
    {
        $product = Product::with('reviews.user')->findOrFail($id);
        return view('customer.products.show', compact('product'));
    }
}
