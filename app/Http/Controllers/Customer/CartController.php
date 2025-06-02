<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer; // Tambahkan ini di bagian atas

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('customer.cart.index', compact('cart'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'quantity'   => 1,
                'pilihan_cod' => 'boolean',
            ];
        }

        Session::put('cart', $cart);
        return redirect()->route('customer.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function remove($productId)
    {
        $cart = Session::get('cart', []);
        $productId = (int)$productId;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        return redirect()->route('customer.cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $selected = array_map('intval', $request->input('selected_products', []));
        
        if (empty($selected)) {
            return back()->with('error', 'Pilih minimal satu produk untuk checkout.');
        }

        $cart = Session::get('cart', []);
        $itemsToOrder = [];

        foreach ($selected as $productId) {
            if (isset($cart[$productId])) {
                $itemsToOrder[] = $cart[$productId];
            }
        }

        if (empty($itemsToOrder)) {
            return back()->with('error', 'Produk yang dipilih tidak ditemukan di keranjang.');
        }

        $alamat = $request->input('alamat');
        if (empty($alamat)) {
            $customer = \App\Models\Customer::where('user_id', auth()->id())->first();
            $alamat = $customer && !empty($customer->address) ? $customer->address : '';
        }

        return view('customer.cart.checkout', compact('itemsToOrder', 'alamat'));
    }

    public function confirmCheckout(Request $request)
    {
        $selected = array_map('intval', $request->input('selected_products', []));
        $alamat = $request->input('alamat');
        $catatan = $request->input('catatan');
        

        if (empty($selected)) {
            return redirect()->route('customer.cart.index')->with('error', 'Tidak ada produk yang dipilih.');
        }

        $cart = Session::get('cart', []);
        $itemsToOrder = [];
        $errors = [];

        foreach ($selected as $productId) {
            if (!isset($cart[$productId])) continue;

            $item = $cart[$productId];
            $product = Product::find($productId);

            if (!$product) {
                $errors[] = 'Produk '.$item['name'].' tidak ditemukan';
                continue;
            }

            if ($product->stock < $item['quantity']) {
                $errors[] = 'Stok produk '.$product->name.' tidak mencukupi';
                continue;
            }

            $product->stock -= $item['quantity'];
            $product->save();

            $itemsToOrder[] = [
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price']
            ];
        }

        if (!empty($errors)) {
            return redirect()->route('customer.cart.index')->withErrors($errors);
        }

        $order = Order::create([
            'id' => 'ORD-'.strtoupper(uniqid()),
            'user_id' => auth()->id(),
            'price' => collect($itemsToOrder)->sum(fn($i) => $i['price'] * $i['quantity']),
            'status' => 'pending',
            'alamat' => $alamat,
            'rincian_pemesanan' => $catatan ?? '',
            'pilihan_cod' => $request->input('pilihan_cod', false),
        ]);

        $order->orderItems()->createMany($itemsToOrder);

        // Hapus produk yang sudah di-checkout
        $newCart = array_diff_key($cart, array_flip($selected));
        Session::put('cart', $newCart);

        return redirect()->route('customer.orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function update(Request $request, $productId)
    {
        $productId = (int)$productId;
        $cart = Session::get('cart', []);
        
        if (!isset($cart[$productId])) {
            return back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $action = $request->input('action');
        $currentQty = $cart[$productId]['quantity'];
        $product = Product::find($productId);

        if ($action === 'increment') {
            if ($product && $currentQty < $product->stock) {
                $cart[$productId]['quantity']++;
            } else {
                return back()->with('error', 'Stok produk tidak mencukupi.');
            }
        } elseif ($action === 'decrement') {
            if ($currentQty > 1) {
                $cart[$productId]['quantity']--;
            }
        }

        Session::put('cart', $cart);
        return back()->with('success');
    }
}