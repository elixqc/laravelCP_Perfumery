@extends('layouts.admin')

@section('content')
<div class="pa-container">
    <h1 class="pa-title">Trashed Products</h1>
    <a href="{{ route('admin.products.index') }}" class="pa-btn mb-4">Back to Products</a>
    <table class="pa-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.products.restore', $product->product_id) }}">
                            @csrf
                            <button type="submit" class="pa-table-link text-green-600" onclick="return confirm('Restore this product?')">Restore</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-400">No trashed products found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
