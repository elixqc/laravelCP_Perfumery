<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'supplier', 'productImages')->where('is_active', true);

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('category', 'supplier', 'productImages', 'productReviews.user')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add to cart');
        }

        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity ?? 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return back()->with('success', 'Product added to cart');
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
        $cartItem = Cart::where('user_id', Auth::id())->where('product_id', $productId)->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back();
    }

    public function removeFromCart($productId)
    {
        Cart::where('user_id', Auth::id())->where('product_id', $productId)->delete();

        return back();
    }
}