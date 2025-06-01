<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Product;

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

    public function checkout(Request $request)
    {
        $selected = $request->input('selected_products', []);
        if (empty($selected)) {
            return back()->with('error', 'Pilih minimal satu produk untuk checkout.');
        }

        $cart = session('cart', []);
        $itemsToOrder = [];

        // Ambil hanya produk yang dipilih
        foreach ($selected as $productId) {
            if (isset($cart[$productId])) {
                $itemsToOrder[] = $cart[$productId];
            }
        }

        if (empty($itemsToOrder)) {
            return back()->with('error', 'Produk yang dipilih tidak ditemukan di keranjang.');
        }

        // Tampilkan halaman konfirmasi checkout
        return view('customer.cart.checkout', compact('itemsToOrder'));
    }

    public function confirmCheckout(Request $request)
    {
        $selected = $request->input('selected_products', []);
        $alamat = $request->input('alamat');
        $catatan = $request->input('catatan');

        if (empty($selected)) {
            return redirect()->route('customer.cart.index')->with('error', 'Tidak ada produk yang dipilih.');
        }

        $cart = session('cart', []);
        $itemsToOrder = [];
        foreach ($selected as $productId) {
            if (isset($cart[$productId])) {
                $item = $cart[$productId];
                if (
                    is_array($item) &&
                    isset($item['product_id'], $item['quantity'], $item['price']) &&
                    !empty($item['product_id']) &&
                    !empty($item['quantity'])
                ) {
                    $itemsToOrder[] = [
                        'product_id' => $item['product_id'],
                        'quantity'   => $item['quantity'],
                        'price'      => $item['price'],
                    ];
                }
            }
        }

        if (empty($itemsToOrder)) {
            return redirect()->route('customer.cart.index')->with('error', 'Data produk tidak valid atau tidak ditemukan.');
        }

        // Simpan order ke database
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'total' => collect($itemsToOrder)->sum(fn($i) => $i['price'] * $i['quantity']),
            'status' => 'pending',
            'alamat' => $alamat,
            'catatan' => $catatan,
        ]);

        foreach ($itemsToOrder as $item) {
            if (
                !is_array($item) ||
                !isset($item['product_id'], $item['quantity'], $item['price']) ||
                empty($item['product_id']) ||
                empty($item['quantity'])
            ) {
                // Lewati jika data tidak valid
                continue;
            }
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Hapus produk yang sudah di-checkout dari keranjang
        foreach ($selected as $productId) {
            unset($cart[$productId]);
        }
        session(['cart' => $cart]);

        return redirect()->route('customer.orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }
}