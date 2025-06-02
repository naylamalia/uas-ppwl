<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total revenue dari semua order_items (pivot)
        $totalRevenue = DB::table('order_items')->sum(DB::raw('price * quantity'));

        // Total order (jumlah order)
        $orderCount = Order::count();

        // Rata-rata transaksi (dari order_items)
        $avgTransaction = DB::table('order_items')->avg(DB::raw('price * quantity'));

        // 5 order terbaru beserta produk dan user (menggunakan with dan relasi many-to-many)
        $recentOrders = Order::with(['products', 'user'])->latest()->limit(5)->get();

        // Overview status order
        $orderOverview = Order::select('status_order', DB::raw('count(*) as total'))
            ->groupBy('status_order')->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'orderCount', 'avgTransaction', 'recentOrders', 'orderOverview'
        ));
    }
}