@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-black">
    <div class="container mx-auto px-4 py-8">
        <!-- Luxury Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-serif font-bold text-gold-400 mb-4 tracking-wider">ORDER MANAGEMENT</h1>
            <p class="text-gold-300 text-lg font-light tracking-widest uppercase">Prestige Customer Orders</p>
        </div>

        <!-- Orders Table -->
        <div class="bg-black/40 backdrop-blur-sm border border-gold-400/20 rounded-lg shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gold-400/10">
                        <tr>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Order ID</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Customer</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Date</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Total</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Status</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gold-400/10">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gold-400/5 transition-colors duration-200">
                                <td class="px-6 py-4 text-sm text-white font-mono">#{{ $order->order_id }}</td>
                                <td class="px-6 py-4 text-sm text-white font-medium">{{ $order->user->full_name }}</td>
                                <td class="px-6 py-4 text-sm text-gold-300">{{ $order->order_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gold-400 font-semibold">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->order_id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status"
                                                onchange="this.form.submit()"
                                                class="bg-gray-800/50 border border-gold-400/30 rounded-md px-3 py-1 text-sm text-white focus:outline-none focus:ring-2 focus:ring-gold-400 focus:border-transparent">
                                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}
                                                    class="bg-gray-800 text-white">Pending</option>
                                            <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}
                                                    class="bg-gray-800 text-white">Processing</option>
                                            <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}
                                                    class="bg-gray-800 text-white">Shipped</option>
                                            <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}
                                                    class="bg-gray-800 text-white">Delivered</option>
                                            <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}
                                                    class="bg-gray-800 text-white">Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('admin.orders.show', $order->order_id) }}"
                                       class="inline-flex items-center text-gold-400 hover:text-gold-300 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gold-300">
                                        <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No orders found</p>
                                        <p class="text-sm opacity-75">Orders will appear here once customers start shopping</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection