<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->selling_price;
        });

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required',
            'payment_method' => 'required',
        ]);

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->selling_price;
        });

        DB::transaction(function () use ($request, $cartItems, $total) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_status' => 'pending',
                'delivery_address' => $request->delivery_address,
                'payment_method' => $request->payment_method,
                'total_amount' => $total,
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->selling_price,
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully');
    }

    public function index()
    {
        $orders = Order::with('orderDetails.product')->where('user_id', Auth::id())->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('orderDetails.product')->where('user_id', Auth::id())->findOrFail($id);

        return view('orders.show', compact('order'));
    }
}