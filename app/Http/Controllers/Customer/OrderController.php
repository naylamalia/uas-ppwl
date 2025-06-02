<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $order = Order::where('id', $id)
                      ->where('user_id', $user->id)
                      ->with('orderItems.product')
                      ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'alamat' => 'required|string',
            'rincian_pemesanan' => 'required|string',
            'pilihan_cod' => 'boolean',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek stok cukup
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // Buat order baru
        $order = Order::create([
            'user_id' => Auth::id(),
            'price' => $product->price * $request->quantity,
            'alamat' => $request->alamat,
            'rincian_pemesanan' => $request->rincian_pemesanan,
            'pilihan_cod' => $request->pilihan_cod ?? false,
            'status_order' => 'belum_selesai',
        ]);

        // Simpan detail produk ke order_items
        $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        // Setelah order berhasil dibuat, lakukan pengurangan stok:
        $product->decrement('stock', $request->quantity);

        return redirect()->route('customer.orders.index')->with('success', 'Order berhasil dibuat!');
    }
}