<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Supplier;
use App\Models\User;
use App\Charts\BestSellingPerfume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    // ── PRODUCT REVIEWS (admin) ──────────────────────────────────

    public function productReviews($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.reviews', compact('product'));
    }

    public function productReviewsData(Request $request, $id)
    {
        $query = ProductReview::with('user')
            ->where('product_id', $id)
            ->select('product_reviews.*');

        return DataTables::of($query)
            ->addColumn('user', fn($review) =>
                $review->user ? ($review->user->full_name ?: $review->user->username) : '—'
            )
            ->addColumn('actions', fn($review) =>
                "<button class='delete-review pa-button pa-button--small pa-button--danger'
                        data-id='{$review->review_id}'>Delete</button>"
            )
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function destroyProductReview($reviewId)
    {
        ProductReview::findOrFail($reviewId)->delete();
        return response()->json(['success' => true]);
    }



    // ── REPORTS & CHARTS ────────────────────────────────────────

    public function bestSellingChart()
    {
        $start = request('start_date');
        $end   = request('end_date');

        $query = Product::select('products.product_name', DB::raw('SUM(order_details.quantity) as total'))
            ->join('order_details', 'products.product_id', '=', 'order_details.product_id')
            ->join('orders', 'orders.order_id', '=', 'order_details.order_id');

        if ($start) {
            $query->whereDate('orders.order_date', '>=', $start);
        }
        if ($end) {
            $query->whereDate('orders.order_date', '<=', $end);
        }

        $data = $query->groupBy('products.product_id', 'products.product_name')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $chart = new BestSellingPerfume();
        $chart->labels($data->pluck('product_name')->toArray());
        $chart->dataset('Units Sold', 'bar', $data->pluck('total')->toArray())
            ->backgroundColor('rgba(181, 151, 90, 0.5)')
            ->color('rgba(181, 151, 90, 1)');

        $totalSales = $data->sum('total');
        $pieLabels  = $data->pluck('product_name')->toArray();
        $pieValues  = $data->pluck('total')->map(function ($qty) use ($totalSales) {
            return $totalSales > 0 ? round(($qty / $totalSales) * 100, 2) : 0;
        })->toArray();

        $pieChart = new \App\Charts\ProductSalesPieChart();
        $pieChart->labels($pieLabels);
        $pieChart->dataset('Sales %', 'pie', $pieValues)
            ->backgroundColor([
                'rgba(181,151,90,0.7)', 'rgba(44,40,37,0.7)', 'rgba(201,122,122,0.7)',
                'rgba(186,183,164,0.7)', 'rgba(200,180,140,0.7)', 'rgba(255,205,86,0.7)',
                'rgba(54,162,235,0.7)', 'rgba(255,99,132,0.7)', 'rgba(153,102,255,0.7)', 'rgba(255,159,64,0.7)',
            ]);

        // AFTER: Calculate yearly sales using product selling_price
        $yearlyData = \App\Models\Order::with(['orderDetails.product'])
            ->get()
            ->groupBy(function($order) {
                return $order->order_date ? $order->order_date->format('Y') : null;
            })
            ->map(function($orders, $year) {
                $total = $orders->flatMap->orderDetails->sum(function($detail) {
                    return $detail->quantity * ($detail->product->selling_price ?? 0);
                });
                return (object)['year' => $year, 'total' => $total];
            })->values();

        // Debug: Log the yearly data
        \Log::info('Yearly data:', $yearlyData->toArray());

        $yearlyChart = new \App\Charts\YearlySalesChart();
        $yearlyChart->labels($yearlyData->pluck('year')->toArray());
        $yearlyChart->dataset('Total Sales', 'line', $yearlyData->pluck('total')->toArray())
            ->backgroundColor('rgba(44,40,37,0.15)')
            ->color('rgba(44,40,37,1)');

        return view('admin.charts.best_sellers', compact('chart', 'pieChart', 'yearlyChart'));
    }

    // ── USERS ────────────────────────────────────────────────────

    public function users()
    {
        return view('admin.users.index');
    }

    public function usersData(Request $request)
    {
        $query = User::select('user_id', 'username', 'full_name', 'email', 'role', 'is_active');

        return DataTables::of($query)
            ->addColumn('status', function (User $user) {
                $label = $user->is_active ? 'Active' : 'Inactive';
                $class = $user->is_active ? 'pa-status--success' : 'pa-status--danger';
                return "<span class='pa-status {$class}'>{$label}</span>";
            })
            ->addColumn('role', function (User $user) {
                $roles   = ['admin' => 'Admin', 'customer' => 'Customer'];
                $options = collect($roles)->map(function ($label, $value) use ($user) {
                    $selected = $user->role === $value ? 'selected' : '';
                    return "<option value='{$value}' {$selected}>{$label}</option>";
                })->implode('');
                return "<select class='pa-select pa-select--small user-role-select' data-user-id='{$user->user_id}'>{$options}</select>";
            })
            ->addColumn('actions', function (User $user) {
                $label  = $user->is_active ? 'Deactivate' : 'Activate';
                $class  = $user->is_active ? 'pa-button--danger' : 'pa-button--success';
                $active = $user->is_active ? '1' : '0';
                return "<button class='pa-button pa-button--small user-toggle-active {$class}' data-user-id='{$user->user_id}' data-active='{$active}'>{$label}</button>";
            })
            ->addColumn('is_active_raw', fn(User $user) => $user->is_active ? 1 : 0)
            ->addColumn('role_raw',      fn(User $user) => $user->role)
            ->rawColumns(['status', 'role', 'actions'])
            ->make(true);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->user_id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot change your own role or active status.',
            ], 422);
        }

        $validated = $request->validate([
            'role'      => 'sometimes|in:admin,customer',
            'is_active' => 'sometimes|boolean',
        ]);

        $user->update($validated);

        return response()->json(['success' => true, 'user' => $user]);
    }
}