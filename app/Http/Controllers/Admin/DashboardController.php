<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalSuppliers = Supplier::count();
        $totalRevenue   = Order::sum('total_amount');
        $recentOrders   = Order::with('user')
                            ->orderBy('order_date', 'desc')
                            ->take(8)
                            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalSuppliers',
            'totalRevenue',
            'recentOrders'
        ));
    }
}