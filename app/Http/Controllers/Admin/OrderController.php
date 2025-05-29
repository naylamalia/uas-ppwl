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
        $orders = Order::with('user', 'orderItems.product')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function exportPdf()
    {
        $orders = Order::with('user', 'product')->latest()->get();
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
        $newStatus = $request->status_order;

        $order->status_order = $newStatus;
        $order->save();

        // Jika status berubah jadi dibatalkan dan sebelumnya bukan dibatalkan, kembalikan stok produk
        if ($oldStatus !== 'dibatalkan' && $newStatus === 'dibatalkan') {
            if ($order->product && $order->quantity) {
                $order->product->increment('stock', $order->quantity);
            }
        }

        // Jika status berubah dari dibatalkan ke status aktif (selesai/belum_selesai), kurangi stok produk
        if ($oldStatus === 'dibatalkan' && $newStatus !== 'dibatalkan') {
            if ($order->product && $order->quantity) {
                if ($order->product->stock >= $order->quantity) {
                    $order->product->decrement('stock', $order->quantity);
                } else {
                    return redirect()->back()->with('error', 'Stok produk tidak cukup untuk mengubah status order.');
                }
            }
        }

        return redirect()->route('admin.orders.show', $order->id)
                         ->with('success', 'Status order & stok berhasil diperbarui');
    }
}