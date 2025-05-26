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
        $request->validate([
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|in:' . implode(',', Product::CATEGORIES),
        ]);

        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Product::CATEGORIES;

        return view('customer.products.index', compact('products', 'categories'));
    }

    // Tampilkan detail produk beserta review dan usernya
    public function show($id)
    {
        $product = Product::with('reviews.user')->findOrFail($id);
        return view('customer.products.show', compact('product'));
    }
}
