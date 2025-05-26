<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'product')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_order' => 'required|in:selesai,belum_selesai',
        ]);

        $order = Order::findOrFail($id);
        $order->status_order = $request->status_order;
        $order->save();

        return redirect()->route('admin.orders.show', $order->id)
                         ->with('success', 'Status order berhasil diperbarui');
    }
}
