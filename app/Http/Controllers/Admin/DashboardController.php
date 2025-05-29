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
        $totalRevenue = Order::sum('price');
        $orderCount = Order::count();
        $avgTransaction = Order::avg('price');
        $recentOrders = Order::with(['product', 'user'])->latest()->limit(5)->get();
        $orderOverview = Order::select('status_order', DB::raw('count(*) as total'))
            ->groupBy('status_order')->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'orderCount', 'avgTransaction', 'recentOrders', 'orderOverview'
        ));
    }
}