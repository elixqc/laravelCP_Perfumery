<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
            Excel::import(new ProductsImport(), $request->file('file'));

            return redirect()->route('admin.products.index')->with('success', 'Products imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: '.$e->getMessage());
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
            'price_asc' => $query->orderBy('selling_price', 'asc'),
            'price_desc' => $query->orderBy('selling_price', 'desc'),
            default => $query->orderBy('product_id', 'desc'),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function show($id)
    {
        $product = Product::with('category', 'supplier', 'productImages', 'productReviews.user')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function addToCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'integer|min:1',
        ]);

        $product = Product::findOrFail($productId);
        $quantity = $request->quantity ?? 1;

        if ($product->stock_quantity < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        // Try to get user ID from multiple sources
        $user = Auth::user();
        $userId = $user ? $user->user_id : null;

        if ($userId) {
            // User is authenticated - save to database
            $cartItem = Cart::where('user_id', $user->user_id)->where('product_id', $productId)->firstOrFail();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            // Guest - save to session
            $sessionCart = session()->get('guest_cart', []);

            if (isset($sessionCart[$productId])) {
                $sessionCart[$productId] += $quantity;
            } else {
                $sessionCart[$productId] = $quantity;
            }

            session()->put('guest_cart', $sessionCart);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function cart()
    {
        $cartItems = collect();

        if (Auth::check()) {
            // Get database cart items for logged-in users
            $cartItems = Cart::with('product.productImages')->where('user_id', Auth::user()->user_id)->get();
        } else {
            // Get session cart items for guests
            $sessionCart = session()->get('guest_cart', []);
            $cartItems = Product::with('productImages')
                ->whereIn('product_id', array_keys($sessionCart))
                ->get()
                ->map(function ($product) use ($sessionCart) {
                    return (object) [
                        'product_id' => $product->product_id,
                        'quantity' => $sessionCart[$product->product_id],
                        'product' => $product,
                    ];
                });
        }

        return view('cart.index', compact('cartItems'));
    }

    public function updateCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        if ($user && $user->id) {
            $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->firstOrFail();
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        } else {
            $sessionCart = session()->get('guest_cart', []);
            if (isset($sessionCart[$productId])) {
                $sessionCart[$productId] = $request->quantity;
                session()->put('guest_cart', $sessionCart);
            }
        }

        return back()->with('success', 'Cart updated.');
    }

    public function removeFromCart($productId)
    {
        $user = Auth::user();
        if ($user && $user->id) {
            Cart::where('user_id', $user->user_id)->where('product_id', $productId)->delete();
        } else {
            $sessionCart = session()->get('guest_cart', []);
            unset($sessionCart[$productId]);
            session()->put('guest_cart', $sessionCart);
        }

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
