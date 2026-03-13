<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Supplier;
use App\Models\User;
use App\Charts\BestSellingPerfume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalSuppliers = Supplier::count();
        $totalRevenue   = Order::sum('total_amount');
        $recentOrders   = Order::with('user')->orderBy('order_date', 'desc')->take(8)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalSuppliers',
            'totalRevenue',
            'recentOrders'
        ));
    }

    // ── PRODUCTS ────────────────────────────────────────────────

    public function products()
    {
        $products = Product::with('category', 'supplier')
            ->withTrashed()
            ->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'product_name'   => 'required|string|min:2|max:255',
            'description'    => 'nullable|string|min:10|max:2000',
            'initial_price'  => 'nullable|numeric|min:0',
            'selling_price'  => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id'    => 'required|exists:categories,category_id',
            'supplier_id'    => 'required|exists:suppliers,supplier_id',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'product_name.required'   => 'Product name is required.',
            'product_name.min'        => 'Product name must be at least 2 characters.',
            'product_name.max'        => 'Product name cannot exceed 255 characters.',
            'description.min'         => 'Description must be at least 10 characters.',
            'description.max'         => 'Description cannot exceed 2000 characters.',
            'initial_price.numeric'   => 'Cost price must be a valid number.',
            'initial_price.min'       => 'Cost price cannot be negative.',
            'selling_price.numeric'   => 'Selling price must be a valid number.',
            'selling_price.min'       => 'Selling price cannot be negative.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'stock_quantity.integer'  => 'Stock quantity must be a whole number.',
            'stock_quantity.min'      => 'Stock quantity cannot be negative.',
            'category_id.required'   => 'Please select a category.',
            'category_id.exists'     => 'Selected category is invalid.',
            'supplier_id.required'   => 'Please select a supplier.',
            'supplier_id.exists'     => 'Selected supplier is invalid.',
            'images.*.image'         => 'Each file must be a valid image.',
            'images.*.mimes'         => 'Images must be JPG, PNG, or WEBP.',
            'images.*.max'           => 'Each image must not exceed 4MB.',
        ]);

        $data = $request->except('images');

        if (empty($data['initial_price']) && empty($data['selling_price']) && $request->filled('price')) {
            $data['initial_price'] = $request->input('price');
            $data['selling_price'] = $request->input('price');
        }

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                $product->productImages()->create([
                    'image_path'  => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function editProduct($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name'   => 'required|string|min:2|max:255',
            'description'    => 'nullable|string|min:10|max:2000',
            'initial_price'  => 'nullable|numeric|min:0',
            'selling_price'  => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id'    => 'required|exists:categories,category_id',
            'supplier_id'    => 'required|exists:suppliers,supplier_id',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'product_name.required'   => 'Product name is required.',
            'product_name.min'        => 'Product name must be at least 2 characters.',
            'product_name.max'        => 'Product name cannot exceed 255 characters.',
            'description.min'         => 'Description must be at least 10 characters.',
            'description.max'         => 'Description cannot exceed 2000 characters.',
            'initial_price.numeric'   => 'Cost price must be a valid number.',
            'initial_price.min'       => 'Cost price cannot be negative.',
            'selling_price.numeric'   => 'Selling price must be a valid number.',
            'selling_price.min'       => 'Selling price cannot be negative.',
            'stock_quantity.required' => 'Stock quantity is required.',
            'stock_quantity.integer'  => 'Stock quantity must be a whole number.',
            'stock_quantity.min'      => 'Stock quantity cannot be negative.',
            'category_id.required'   => 'Please select a category.',
            'category_id.exists'     => 'Selected category is invalid.',
            'supplier_id.required'   => 'Please select a supplier.',
            'supplier_id.exists'     => 'Selected supplier is invalid.',
            'images.*.image'         => 'Each file must be a valid image.',
            'images.*.mimes'         => 'Images must be JPG, PNG, or WEBP.',
            'images.*.max'           => 'Each image must not exceed 4MB.',
        ]);

        $data = $request->except('images');

        if (empty($data['initial_price']) && empty($data['selling_price']) && $request->filled('price')) {
            $data['initial_price'] = $request->input('price');
            $data['selling_price'] = $request->input('price');
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');
                $product->productImages()->create([
                    'image_path'  => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

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

    // ── SUPPLIERS ───────────────────────────────────────────────

    public function suppliers()
    {
        $suppliers = Supplier::paginate(20);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function createSupplier()
    {
        return view('admin.suppliers.create');
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required',
            'contact_email' => 'nullable|email',
        ]);

        Supplier::create($request->all());

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created.');
    }

    public function editSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function updateSupplier(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated.');
    }

    public function destroySupplier($id)
    {
        Supplier::findOrFail($id)->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted.');
    }

    // ── ORDERS ──────────────────────────────────────────────────

    public function orders()
    {
        return view('admin.orders.index');
    }

    public function ordersData(Request $request)
    {
        $query = Order::with('user', 'orderDetails')
            ->select('orders.*');

        return DataTables::of($query)
            ->addColumn('customer', fn($order) =>
                "<span style=\"font-size:0.92rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; display:block;\">{$order->user->full_name}</span>"
                . ($order->user->email
                    ? "<span style=\"font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;\">{$order->user->email}</span>"
                    : '')
            )
            ->addColumn('date', fn($order) =>
                "<span style=\"font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:400; display:block;\">{$order->order_date->format('M d, Y')}</span>"
                . "<span style=\"font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;\">{$order->order_date->format('h:i A')}</span>"
            )
            ->addColumn('items', fn($order) =>
                "<span style=\"font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:400;\">"
                . $order->orderDetails->count() . ' '
                . \Illuminate\Support\Str::plural('item', $order->orderDetails->count())
                . "</span>"
            )
            ->addColumn('total', fn($order) =>
                "<span style=\"font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:300; color:#1A1714; letter-spacing:0.02em;\">₱"
                . number_format($order->total_amount, 2)
                . "</span>"
            )
            ->addColumn('status', function ($order) {
                $status = strtolower($order->order_status);
                [$bg, $color] = match($status) {
                    'completed'  => ['#F0F5EE', '#4A6741'],
                    'processing' => ['#EEF2F8', '#3A5580'],
                    'cancelled'  => ['#F8EEEE', '#8B3A3A'],
                    default      => ['#FEF3CD', '#856404'],
                };
                return "<span style=\"display:inline-block; font-size:0.68rem; letter-spacing:0.15em; text-transform:uppercase; font-family:'Jost',sans-serif; font-weight:400; padding:0.28rem 0.75rem; border-radius:2px; background:{$bg}; color:{$color};\">"
                    . ucfirst($order->order_status)
                    . "</span>";
            })
            ->addColumn('actions', fn($order) =>
                "<a href=\"" . route('admin.orders.show', $order->order_id) . "\""
                . " style=\"font-family:'Jost',sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:0.08em; color:#2C2825; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px;\""
                . " onmouseover=\"this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'\""
                . " onmouseout=\"this.style.color='#2C2825'; this.style.borderBottomColor='transparent'\">"
                . "View →</a>"
            )
            ->addColumn('order_status_raw', fn($order) => $order->order_status)
            ->rawColumns(['customer', 'date', 'items', 'total', 'status', 'actions'])
            ->make(true);
    }

    public function showOrder($id)
    {
        $order = Order::with('orderDetails.product', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order          = Order::with('orderDetails.product', 'user')->findOrFail($id);
        $previousStatus = $order->order_status;
        $newStatus      = $request->status;

        // Only update and notify if status actually changed
        if ($previousStatus === $newStatus) {
            return back()->with('success', 'Order status is already ' . $newStatus . '.');
        }

        $order->update(['order_status' => $newStatus]);

        // Send email for processing, completed, and cancelled
        $notifyStatuses = ['processing', 'completed', 'cancelled'];

        if (in_array($newStatus, $notifyStatuses) && $order->user?->email) {
            \Illuminate\Support\Facades\Mail::to($order->user->email)
                ->send(new \App\Mail\OrderStatusUpdated($order, $previousStatus));
        }

        return back()->with('success', 'Order status updated to ' . ucfirst($newStatus) . '.');
    }

    // ── REPORTS & CHARTS ────────────────────────────────────────

    public function bestSellingChart()
    {
        $start = request('start_date');
        $end = request('end_date');

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

        // Pie chart for sales percentage
        $totalSales = $data->sum('total');
        $pieLabels = $data->pluck('product_name')->toArray();
        $pieValues = $data->pluck('total')->map(function($qty) use ($totalSales) {
            return $totalSales > 0 ? round(($qty / $totalSales) * 100, 2) : 0;
        })->toArray();

        $pieChart = new \App\Charts\ProductSalesPieChart();
        $pieChart->labels($pieLabels);
        $pieChart->dataset('Sales %', 'pie', $pieValues)
            ->backgroundColor([
                'rgba(181,151,90,0.7)', 'rgba(44,40,37,0.7)', 'rgba(201,122,122,0.7)',
                'rgba(186,183,164,0.7)', 'rgba(200,180,140,0.7)', 'rgba(255,205,86,0.7)',
                'rgba(54,162,235,0.7)', 'rgba(255,99,132,0.7)', 'rgba(153,102,255,0.7)', 'rgba(255,159,64,0.7)'
            ]);

        // Yearly sales chart
        $yearlyData = Order::select(DB::raw('YEAR(order_date) as year'), DB::raw('SUM(total_amount) as total'))
            ->groupBy(DB::raw('YEAR(order_date)'))
            ->orderBy('year', 'asc')
            ->get();

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
                $roles = ['admin' => 'Admin', 'customer' => 'Customer'];
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
    public function destroyProductImage($imageId)
    {
        $image = \App\Models\ProductImage::findOrFail($imageId);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}