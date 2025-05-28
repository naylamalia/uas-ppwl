<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Tampilkan isi keranjang
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('customer.cart.index', compact('cart'));
    }

    // Tambah produk ke keranjang
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = Session::get('cart', []);

        // Jika produk sudah ada di keranjang, tambahkan quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'quantity'   => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('customer.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Hapus produk dari keranjang
    public function remove($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        return redirect()->route('customer.cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}