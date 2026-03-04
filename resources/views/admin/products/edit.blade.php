@extends('layouts.admin')

@section('content')
<div class="pa-page">

    {{-- PAGE HEADER --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Inventory</span>
            <h1 class="pa-page-title">Edit Product</h1>
        </div>
    </div>

    {{-- FORM --}}
    <div class="pa-section">

    <form method="POST" action="{{ route('admin.products.update', $product->product_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="product_name" class="block text-sm font-medium">Product Name</label>
            <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $product->product_name) }}" class="w-full border px-3 py-2" required>
            @error('product_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium">Description</label>
            <textarea name="description" id="description" class="w-full border px-3 py-2">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block text-sm font-medium">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" class="w-full border px-3 py-2" required>
            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="stock_quantity" class="block text-sm font-medium">Stock Quantity</label>
            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" class="w-full border px-3 py-2" required>
            @error('stock_quantity')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium">Category</label>
            <select name="category_id" id="category_id" class="w-full border px-3 py-2" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="supplier_id" class="block text-sm font-medium">Supplier</label>
            <select name="supplier_id" id="supplier_id" class="w-full border px-3 py-2" required>
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->supplier_id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->supplier_id ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                @endforeach
            </select>
            @error('supplier_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="variant" class="block text-sm font-medium">Variant</label>
            <input type="text" name="variant" id="variant" value="{{ old('variant', $product->variant) }}" class="w-full border px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium">Product Image</label>
            @if($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Current Image" class="w-32 h-32 object-cover mb-2">
            @endif
            <input type="file" name="image" id="image" class="w-full border px-3 py-2" accept="image/*">
            @error('image')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="mr-2">
                Active
            </label>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Product</button>
    </form>

    <a href="{{ route('admin.products.index') }}" class="text-blue-500 mt-4 inline-block">Back to Products</a>
</div>
@endsection