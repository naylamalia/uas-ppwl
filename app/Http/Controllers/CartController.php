<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cartItem = CartItem::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ],
            ['quantity' => 0]
        );

        $cartItem->increment('quantity', $request->input('quantity', 1));
        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        $item = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $item->delete();
        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang.');
    }
}