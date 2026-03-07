<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Supplier;

class ProductController extends Controller
{
    // Show the import form
    public function importForm()
    {
        return view('admin.products.import');
    }

    // Handle the import POST
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));
            return redirect()->route('admin.products.index')->with('success', 'Products imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $query = Product::with('productImages', 'supplier', 'category')
            ->where('is_active', true);

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by supplier
        if ($request->filled('supplier')) {
            $query->where('supplier_id', $request->supplier);
        }

        // Sort by price: price_asc | price_desc (default: latest)
        match ($request->sort) {
            'price_asc'  => $query->orderBy('selling_price', 'asc'),
            'price_desc' => $query->orderBy('selling_price', 'desc'),
            default      => $query->orderBy('product_id', 'desc'),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $suppliers  = Supplier::all();

        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function show($id)
    {
        $product = Product::with('category', 'supplier', 'productImages', 'productReviews.user')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add to cart.');
        }

        $request->validate([
            'quantity' => 'integer|min:1',
        ]);

        $product = Product::findOrFail($productId);

        if ($product->stock_quantity < ($request->quantity ?? 1)) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity ?? 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $productId,
                'quantity'   => $request->quantity ?? 1,
            ]);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function cart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = Cart::with('product.productImages')->where('user_id', Auth::id())->get();

        return view('cart.index', compact('cartItems'));
    }

    public function updateCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $productId)->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Cart updated.');
    }

    public function removeFromCart($productId)
    {
        Cart::where('user_id', Auth::id())->where('product_id', $productId)->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    // Restore a soft deleted product (admin only)
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')->with('success', 'Product restored successfully.');
    }
}