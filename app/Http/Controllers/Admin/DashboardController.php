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
        // Chart Stock In/Out (misal: ambil dari tabel stock_histories)
       // $stock = DB::table('stock_histories')
         //   ->selectRaw('DATE(created_at) as date, SUM(quantity) as total')
           // ->groupBy('date')
            //->orderBy('date', 'desc')
            //->limit(7)
            //->get();

        // Produk Populer (berdasarkan jumlah order terbanyak)
        //$popularProducts = Product::select('products.*')
            //->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
            //->selectRaw('count(order_details.id) as order_details_count')
            //->groupBy('products.id')
            //->orderByDesc('order_details_count')
            //->limit(5)
            //->get();

        // Order Overview (jumlah order per status)
        $orderOverview = Order::select('status_order', DB::raw('count(*) as total'))
            ->groupBy('status_order')
            ->get();

        // Jumlah User
        $userCount = User::count();

        return view('admin.dashboard', [
            // 'stock' => $stock,
            //'popularProducts' => $popularProducts,
            'orderOverview' => $orderOverview,
            'userCount' => $userCount,
        ]);
    }
}