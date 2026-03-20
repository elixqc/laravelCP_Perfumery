<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function data(Request $request)
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
                . Str::plural('item', $order->orderDetails->count())
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

    public function show($id)
    {
        $order = Order::with('orderDetails.product', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order          = Order::with('orderDetails.product', 'user')->findOrFail($id);
        $previousStatus = $order->order_status;
        $newStatus      = $request->status;

        if ($previousStatus === $newStatus) {
            return back()->with('success', 'Order status is already ' . $newStatus . '.');
        }

        $order->update(['order_status' => $newStatus]);

        $notifyStatuses = ['processing', 'completed', 'cancelled'];

        if (in_array($newStatus, $notifyStatuses) && $order->user?->email) {
            \Illuminate\Support\Facades\Mail::to($order->user->email)
                ->send(new \App\Mail\OrderStatusUpdated($order, $previousStatus));
        }

        return back()->with('success', 'Order status updated to ' . ucfirst($newStatus) . '.');
    }
}