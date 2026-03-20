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

        $total = $cartItems->sum(fn($item) => $item->quantity * ($item->product->selling_price ?? 0));

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required',
            'payment_method'   => 'required',
        ]);

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        DB::transaction(function () use ($request, $cartItems) {
            $order = Order::create([
                'user_id'          => Auth::id(),
                'order_status'     => 'pending',
                'order_date'       => now(),
                'delivery_address' => $request->delivery_address,
                'payment_method'   => $request->payment_method,
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id'   => $order->order_id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }

    public function index()
    {
        $orders = Order::with('orderDetails.product')
                    ->where('user_id', Auth::id())
                    ->orderBy('order_id', 'desc')
                    ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('orderDetails.product')
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        return view('orders.show', compact('order'));
    }
}