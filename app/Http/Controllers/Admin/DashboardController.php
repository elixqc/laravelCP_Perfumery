<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalSuppliers = Supplier::count();

        $totalRevenue = OrderDetail::join('products', 'order_details.product_id', '=', 'products.product_id')
                            ->sum(\DB::raw('order_details.quantity * products.selling_price'));

        $recentOrders = Order::with('user', 'orderDetails.product')
                            ->orderBy('order_id', 'desc')
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