@extends('layouts.admin')

@section('title', 'Dashboard — Admin')

@section('content')

<div class="pa-page">

    {{-- PAGE HEADER --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Overview</span>
            <h1 class="pa-page-title">Dashboard</h1>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="pa-stats-grid">
        <div class="pa-stat-card">
            <span class="pa-stat-label">Total Products</span>
            <span class="pa-stat-value">{{ $totalProducts ?? '—' }}</span>
            <a href="{{ route('admin.products.index') }}" class="pa-stat-link">Manage →</a>
        </div>
        <div class="pa-stat-card">
            <span class="pa-stat-label">Total Orders</span>
            <span class="pa-stat-value">{{ $totalOrders ?? '—' }}</span>
            <a href="{{ route('admin.orders.index') }}" class="pa-stat-link">View all →</a>
        </div>
        <div class="pa-stat-card">
            <span class="pa-stat-label">Total Suppliers</span>
            <span class="pa-stat-value">{{ $totalSuppliers ?? '—' }}</span>
            <a href="{{ route('admin.suppliers.index') }}" class="pa-stat-link">Manage →</a>
        </div>
        <div class="pa-stat-card pa-stat-card--gold">
            <span class="pa-stat-label">Revenue</span>
            <span class="pa-stat-value">₱{{ number_format($totalRevenue ?? 0, 2) }}</span>
            <span class="pa-stat-link">All time</span>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="pa-section">
        <h2 class="pa-section-title">Quick Actions</h2>
        <div class="pa-actions-grid">
            <a href="{{ route('admin.products.create') }}" class="pa-action-card">
                <span class="pa-action-icon">＋</span>
                <span class="pa-action-label">Add Product</span>
            </a>
            <a href="{{ route('admin.suppliers.create') }}" class="pa-action-card">
                <span class="pa-action-icon">＋</span>
                <span class="pa-action-label">Add Supplier</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="pa-action-card">
                <span class="pa-action-icon">◎</span>
                <span class="pa-action-label">View Orders</span>
            </a>
            <a href="{{ route('home') }}" class="pa-action-card">
                <span class="pa-action-icon">↗</span>
                <span class="pa-action-label">Visit Storefront</span>
            </a>
        </div>
    </div>

    {{-- RECENT ORDERS --}}
    @if(!empty($recentOrders) && $recentOrders->count())
    <div class="pa-section">
        <h2 class="pa-section-title">Recent Orders</h2>
        <div class="pa-table-wrap">
            <table class="pa-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->order_id }}</td>
                        <td>{{ $order->user->name ?? '—' }}</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="pa-status pa-status--{{ strtolower($order->order_status) }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>
                        <td>{{ $order->order_date->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->order_id) }}" class="pa-table-link">View →</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

@endsection