<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Tampilkan semua order dengan relasi user dan product.
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['user', 'product'])->latest()->get();

        return response()->json($orders);
    }

    /**
     * Tampilkan detail order tertentu dengan relasi user dan product.
     */
    public function show(int $id): JsonResponse
    {
        $order = Order::with(['user', 'product'])->findOrFail($id);

        return response()->json($order);
    }

    /**
     * Hapus order berdasarkan ID.
     */
    public function destroy(int $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order berhasil dihapus.'], 200);
    }
}
