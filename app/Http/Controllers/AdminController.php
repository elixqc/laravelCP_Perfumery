<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $products = Product::with('category', 'supplier')->paginate(20);
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
            'price'          => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id'    => 'required|exists:categories,category_id',
            'supplier_id'    => 'required|exists:suppliers,supplier_id',
            'image'          => 'nullable|image',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

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
            'price'          => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id'    => 'required|exists:categories,category_id',
            'supplier_id'    => 'required|exists:suppliers,supplier_id',
            'image'          => 'nullable|image',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

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
        $orders = Order::with('user')->latest()->paginate(20);
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
}