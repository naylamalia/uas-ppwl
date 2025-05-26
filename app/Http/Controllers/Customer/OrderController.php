<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Tampilkan semua order milik customer yang login
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('product')->latest()->get();
        return response()->json($orders);
    }

    // Simpan order baru
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'alamat' => 'required|string',
            'rincian_pemesanan' => 'required|string',
            'pilihan_cod' => 'boolean',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'alamat' => $request->alamat,
            'rincian_pemesanan' => $request->rincian_pemesanan,
            'pilihan_cod' => $request->pilihan_cod ?? false,
        ]);

        return response()->json(['message' => 'Order berhasil dibuat.', 'order' => $order], 201);
    }

    // Detail order milik customer
    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($order);
    }
}
