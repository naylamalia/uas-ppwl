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
        $orders = Order::with('user', 'products')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function exportPdf()
    {
        $orders = Order::with('user', 'products')->latest()->get();
        $pdf = Pdf::loadView('admin.orders.report', compact('orders'));
        return $pdf->download('laporan-order.pdf');
    }

    public function show($id)
    {
        $order = Order::with('user', 'products')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_order' => 'required|in:selesai,belum_selesai,dibatalkan',
        ]);

        $order = Order::with('products')->findOrFail($id);
        $oldStatus = $order->status_order;
        $newStatus = $request->status_order;

        $order->status_order = $newStatus;
        $order->save();

        // Jika status berubah jadi dibatalkan dan sebelumnya bukan dibatalkan, kembalikan stok semua produk pada order
        if ($oldStatus !== 'dibatalkan' && $newStatus === 'dibatalkan') {
            foreach ($order->products as $product) {
                $qty = $product->pivot->quantity ?? 0;
                if ($qty > 0) {
                    $product->increment('stock', $qty);
                }
            }
        }

        // Jika status berubah dari dibatalkan ke status aktif (selesai/belum_selesai), kurangi stok semua produk pada order
        if ($oldStatus === 'dibatalkan' && $newStatus !== 'dibatalkan') {
            foreach ($order->products as $product) {
                $qty = $product->pivot->quantity ?? 0;
                if ($qty > 0) {
                    if ($product->stock >= $qty) {
                        $product->decrement('stock', $qty);
                    } else {
                        return redirect()->back()->with('error', 'Stok produk ' . $product->name . ' tidak cukup untuk mengubah status order.');
                    }
                }
            }
        }

        return redirect()->route('admin.orders.show', $order->id)
                         ->with('success', 'Status order & stok berhasil diperbarui');
    }
}