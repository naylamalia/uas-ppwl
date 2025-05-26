<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['product', 'user'])->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $products = Product::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('admin.reviews.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create($request->all());

        return redirect()->route('admin.reviews.index')->with('success', 'Review berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $products = Product::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('admin.reviews.edit', compact('review', 'products', 'users'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($request->all());

        return redirect()->route('admin.reviews.index')->with('success', 'Review berhasil diupdate.');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review berhasil dihapus.');
    }
}
