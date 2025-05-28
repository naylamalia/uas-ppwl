<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'product')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function exportPdf()
    {
        $orders = Order::with('user', 'orderItems.product')->latest()->get();
        $pdf = Pdf::loadView('admin.orders.report', compact('orders'));
        return $pdf->download('laporan-order.pdf');
    }

    public function show($id)
    {
        $order = Order::with('user', 'product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_order' => 'required|in:selesai,belum_selesai,dibatalkan',
        ]);

        $order = Order::with('product')->findOrFail($id);
        $oldStatus = $order->status_order;
        $order->status_order = $request->status_order;
        $order->save();

        // Responsif stok: jika order dibatalkan, stok produk dikembalikan
        if ($oldStatus !== 'dibatalkan' && $request->status_order === 'dibatalkan') {
            if ($order->product && $order->quantity) {
                $order->product->increment('stock', $order->quantity);
            }
            if (method_exists($order, 'orderItems')) {
                foreach ($order->orderItems as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        // Jika status diubah dari dibatalkan ke aktif, stok dikurangi lagi
        if ($oldStatus === 'dibatalkan' && $request->status_order !== 'dibatalkan') {
            if ($order->product && $order->quantity) {
                if ($order->product->stock >= $order->quantity) {
                    $order->product->decrement('stock', $order->quantity);
                }
            }
            if (method_exists($order, 'orderItems')) {
                foreach ($order->orderItems as $item) {
                    if ($item->product->stock >= $item->quantity) {
                        $item->product->decrement('stock', $item->quantity);
                    }
                }
            }
        }

        return redirect()->route('admin.orders.show', $order->id)
                         ->with('success', 'Status order & stok berhasil diperbarui');
    }
}