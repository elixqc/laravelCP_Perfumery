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
            'product_name'   => 'required',
            'initial_price'  => 'nullable|numeric',
            'selling_price'  => 'nullable|numeric',
            'stock_quantity' => 'required|integer',
            'category_id'    => 'required|exists:categories,category_id',
            'supplier_id'    => 'required|exists:suppliers,supplier_id',
            'images'         => 'nullable|array',
            'images.*'       => 'image',
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
            'product_name'   => 'required',
            'initial_price'  => 'nullable|numeric',
            'selling_price'  => 'nullable|numeric',
            'stock_quantity' => 'required|integer',
            'category_id'    => 'required|exists:categories,category_id',
            'supplier_id'    => 'required|exists:suppliers,supplier_id',
            'images'         => 'nullable|array',
            'images.*'       => 'image',
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
        $orders = Order::with('user')->orderBy('order_date', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
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

        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->status]);

        return back()->with('success', 'Order status updated.');
    }

    // ── REPORTS & CHARTS ────────────────────────────────────────

    public function bestSellingChart()
    {
        $data = Product::select('products.product_name', DB::raw('SUM(order_details.quantity) as total'))
            ->join('order_details', 'products.product_id', '=', 'order_details.product_id')
            ->groupBy('products.product_id', 'products.product_name')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $chart = new BestSellingPerfume();
        $chart->labels($data->pluck('product_name')->toArray());
        $chart->dataset('Units Sold', 'bar', $data->pluck('total')->toArray())
            ->backgroundColor('rgba(181, 151, 90, 0.5)')
            ->color('rgba(181, 151, 90, 1)');

        return view('admin.charts.best_sellers', compact('chart'));
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
            // Raw scalar values for the frontend stats bar.
            // The 'role' and 'status' columns above return HTML strings, so
            // json.data cannot be filtered on u.role or u.is_active directly.
            // These two columns expose the plain values the blade JS needs.
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