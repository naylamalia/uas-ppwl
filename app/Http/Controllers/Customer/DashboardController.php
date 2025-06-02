<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Produk terbaru (6 produk terbaru)
        $latestProducts = Product::orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Produk populer (berdasarkan jumlah order terbanyak via order_items)
        $popularProducts = Product::select('products.*')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('COUNT(order_items.id) as orders_count')
            ->groupBy('products.id')
            ->orderByDesc('orders_count')
            ->limit(6)
            ->get();


        // Pencarian produk
        $searchResults = null;
        if ($request->has('q') && $request->q) {
            $searchResults = Product::where('name', 'like', '%' . $request->q . '%')
                ->orWhere('code', 'like', '%' . $request->q . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('customer.dashboard', [
            'latestProducts' => $latestProducts,
            'popularProducts' => $popularProducts,
            'searchResults' => $searchResults,
        ]);
    }
}