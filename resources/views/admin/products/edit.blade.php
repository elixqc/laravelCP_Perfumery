@extends('layouts.admin')

@section('title', 'Edit Product — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Products</span>
            <h1 class="pa-page-title">Edit Product</h1>
        </div>
        <a href="{{ route('admin.products.index') }}"
           style="font-size:0.85rem; letter-spacing:0.05em; text-transform:none; font-family:'Jost',sans-serif; font-weight:400; color:#5A524A; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
           onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
           onmouseout="this.style.color='#5A524A'; this.style.borderBottomColor='transparent'">
            ← Back to Products
        </a>
    </div>

    {{-- ── Global Error Summary ── --}}
    @if($errors->any())
        <div style="max-width:800px; margin:0 auto 1.5rem; background:#FDF2F2; border:1.5px solid #C97A7A; padding:1rem 1.25rem; border-radius:2px;">
            <p style="font-size:0.82rem; font-weight:600; color:#8B3A3A; font-family:'Jost',sans-serif; margin-bottom:0.5rem;">
                ⚠ Please fix the following errors before saving:
            </p>
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach($errors->all() as $error)
                    <li style="font-size:0.8rem; color:#8B3A3A; font-family:'Jost',sans-serif; margin-bottom:0.2rem;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ── Form Container ── --}}
    <div style="max-width:800px; margin:0 auto; width:100%;">
        <form method="POST" action="{{ route('admin.products.update', $product->product_id) }}"
              id="edit-product-form" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PATCH')

            {{-- ── Section: Product Information ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Product Information
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem;">

                    {{-- Product Name --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="product_name" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Product Name <span style="color:#C97A7A;">*</span>
                        </label>
                        <input type="text" name="product_name" id="product_name"
                               value="{{ old('product_name', $product->product_name) }}"
                               minlength="2" maxlength="255" required
                               placeholder="e.g. Oud Élixir Intense"
                               style="background:#fff; border:1.5px solid {{ $errors->has('product_name') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               oninput="validateField(this, 2, 255)"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="validateField(this, 2, 255)">
                        <span id="product_name-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('product_name') ? 'block' : 'none' }};">
                            @error('product_name') {{ $message }} @enderror
                        </span>
                    </div>

                    {{-- Variant --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="variant" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Variant <span style="font-size:0.75rem; color:#8C8078; font-weight:300;">(optional)</span>
                        </label>
                        <input type="text" name="variant" id="variant"
                               value="{{ old('variant', $product->variant) }}"
                               maxlength="255"
                               placeholder="e.g. 100ml, EDP, Gift Set"
                               style="background:#fff; border:1.5px solid {{ $errors->has('variant') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='{{ $errors->has('variant') ? '#C97A7A' : '#B0A898' }}'">
                    </div>

                    {{-- Description --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="description" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Description <span style="font-size:0.75rem; color:#8C8078; font-weight:300;">(optional)</span>
                        </label>
                        <textarea name="description" id="description" rows="5"
                                  minlength="10" maxlength="2000"
                                  placeholder="Describe the product…"
                                  style="background:#fff; border:1.5px solid {{ $errors->has('description') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; resize:vertical; min-height:120px; transition:border-color 0.2s; border-radius:2px;"
                                  onfocus="this.style.borderColor='#B5975A'"
                                  onblur="this.style.borderColor='{{ $errors->has('description') ? '#C97A7A' : '#B0A898' }}'">{{ old('description', $product->description) }}</textarea>
                        <span id="description-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('description') ? 'block' : 'none' }};">
                            @error('description') {{ $message }} @enderror
                        </span>
                    </div>

                </div>
            </div>

            {{-- ── Section: Pricing & Stock ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Pricing &amp; Stock
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem;">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">

                        {{-- Cost Price --}}
                        <div style="display:flex; flex-direction:column; gap:0.4rem;">
                            <label for="initial_price" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                                Cost Price (₱) <span style="font-size:0.75rem; color:#8C8078; font-weight:300;">(optional)</span>
                            </label>
                            <input type="number" name="initial_price" id="initial_price"
                                   value="{{ old('initial_price', $product->initial_price) }}"
                                   min="0" step="0.01" placeholder="0.00"
                                   style="background:#fff; border:1.5px solid {{ $errors->has('initial_price') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                                   onfocus="this.style.borderColor='#B5975A'"
                                   onblur="this.style.borderColor='{{ $errors->has('initial_price') ? '#C97A7A' : '#B0A898' }}'">
                            <span id="initial_price-error" class="field-error"
                                  style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('initial_price') ? 'block' : 'none' }};">
                                @error('initial_price') {{ $message }} @enderror
                            </span>
                        </div>

                        {{-- Selling Price --}}
                        <div style="display:flex; flex-direction:column; gap:0.4rem;">
                            <label for="selling_price" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                                Selling Price (₱) <span style="font-size:0.75rem; color:#8C8078; font-weight:300;">(optional)</span>
                            </label>
                            <input type="number" name="selling_price" id="selling_price"
                                   value="{{ old('selling_price', $product->selling_price) }}"
                                   min="0" step="0.01" placeholder="0.00"
                                   style="background:#fff; border:1.5px solid {{ $errors->has('selling_price') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                                   onfocus="this.style.borderColor='#B5975A'"
                                   onblur="this.style.borderColor='{{ $errors->has('selling_price') ? '#C97A7A' : '#B0A898' }}'">
                            <span id="selling_price-error" class="field-error"
                                  style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('selling_price') ? 'block' : 'none' }};">
                                @error('selling_price') {{ $message }} @enderror
                            </span>
                        </div>

                    </div>

                    {{-- Stock Quantity --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem; max-width:240px;">
                        <label for="stock_quantity" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Stock Quantity <span style="color:#C97A7A;">*</span>
                        </label>
                        <input type="number" name="stock_quantity" id="stock_quantity"
                               value="{{ old('stock_quantity', $product->stock_quantity) }}"
                               min="0" step="1" required placeholder="0"
                               style="background:#fff; border:1.5px solid {{ $errors->has('stock_quantity') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='{{ $errors->has('stock_quantity') ? '#C97A7A' : '#B0A898' }}'">
                        <span id="stock_quantity-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('stock_quantity') ? 'block' : 'none' }};">
                            @error('stock_quantity') {{ $message }} @enderror
                        </span>
                    </div>

                </div>
            </div>

            {{-- ── Section: Classification ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Classification
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">

                    {{-- Category --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="category_id" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Category <span style="color:#C97A7A;">*</span>
                        </label>
                        <select name="category_id" id="category_id" required
                                style="background:#fff; border:1.5px solid {{ $errors->has('category_id') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px; cursor:pointer;"
                                onfocus="this.style.borderColor='#B5975A'"
                                onblur="this.style.borderColor='{{ $errors->has('category_id') ? '#C97A7A' : '#B0A898' }}'">
                            <option value="">— Select a category —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}"
                                    {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        <span id="category_id-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('category_id') ? 'block' : 'none' }};">
                            @error('category_id') {{ $message }} @enderror
                        </span>
                    </div>

                    {{-- Supplier --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="supplier_id" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Supplier <span style="color:#C97A7A;">*</span>
                        </label>
                        <select name="supplier_id" id="supplier_id" required
                                style="background:#fff; border:1.5px solid {{ $errors->has('supplier_id') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px; cursor:pointer;"
                                onfocus="this.style.borderColor='#B5975A'"
                                onblur="this.style.borderColor='{{ $errors->has('supplier_id') ? '#C97A7A' : '#B0A898' }}'">
                            <option value="">— Select a supplier —</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->supplier_id }}"
                                    {{ old('supplier_id', $product->supplier_id) == $supplier->supplier_id ? 'selected' : '' }}>
                                    {{ $supplier->supplier_name }}
                                </option>
                            @endforeach
                        </select>
                        <span id="supplier_id-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('supplier_id') ? 'block' : 'none' }};">
                            @error('supplier_id') {{ $message }} @enderror
                        </span>
                    </div>

                </div>
            </div>

            {{-- ── Section: Images ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Images
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem;">

                    {{-- Existing Images --}}
                    @if($product->productImages->count())
                        <div>
                            <span style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif; display:block; margin-bottom:0.75rem;">Current Images</span>
                            <div style="display:flex; flex-wrap:wrap; gap:0.75rem;">
                                @foreach($product->productImages as $image)
                                    <div class="img-thumb" style="position:relative; width:90px; height:90px;">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt=""
                                             style="width:100%; height:100%; object-fit:cover; border:1px solid #D6D0C8; display:block;">
                                        <button type="button"
                                                onclick="deleteImage(this)"
                                                data-url="{{ route('admin.admin.products.images.destroy', $image->image_id) }}"
                                                style="position:absolute; top:4px; right:4px; background:rgba(26,23,20,0.75); color:#fff; border:none; width:22px; height:22px; font-size:0.7rem; cursor:pointer; display:flex; align-items:center; justify-content:center; border-radius:2px; z-index:10;">✕</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Upload New Images --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="images" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Add New Images <span style="font-size:0.75rem; color:#8C8078; font-weight:300;">(JPG, PNG, WEBP · max 4MB each)</span>
                        </label>
                        <input type="file" name="images[]" id="images"
                               multiple accept="image/jpeg,image/png,image/webp"
                               style="background:#fff; border:1.5px solid {{ $errors->has('images') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-size:0.88rem; padding:0.65rem 1rem; outline:none; width:100%; border-radius:2px; cursor:pointer;">
                        <span id="images-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('images') ? 'block' : 'none' }};">
                            @error('images') {{ $message }} @enderror
                        </span>
                    </div>

                </div>
            </div>

            {{-- ── Section: Status ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Status
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:1.5rem 2rem; display:flex; align-items:center; justify-content:space-between; gap:2rem;">
                    <div>
                        <span style="font-size:0.88rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif; display:block; margin-bottom:0.3rem;">Active Product</span>
                        <span style="font-size:0.82rem; color:#8C8078; font-family:'Jost',sans-serif;">Visible to customers on the storefront</span>
                    </div>
                    <label style="display:flex; align-items:center; gap:0.6rem; cursor:pointer; flex-shrink:0;">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               style="appearance:none; -webkit-appearance:none; width:20px; height:20px; border:2px solid #B0A898; background:#fff; cursor:pointer; transition:border-color 0.2s, background 0.2s; flex-shrink:0; border-radius:2px;"
                               onchange="this.style.background=this.checked?'#2C2825':'#fff'; this.style.borderColor=this.checked?'#2C2825':'#B0A898'">
                        <span style="font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:400;">Active</span>
                    </label>
                </div>
            </div>

            {{-- ── Actions ── --}}
            <div style="display:flex; align-items:center; gap:1rem; padding-top:1.5rem; border-top:1px solid #E8E2D9;">
                <button type="submit"
                        style="background:#2C2825; color:#F8F5F0; border:none; font-family:'Jost',sans-serif; font-size:0.88rem; font-weight:500; letter-spacing:0.08em; text-transform:uppercase; padding:0.85rem 2.5rem; cursor:pointer; transition:background 0.25s, color 0.25s; border-radius:2px;"
                        onmouseover="this.style.background='#B5975A'; this.style.color='#1A1714'"
                        onmouseout="this.style.background='#2C2825'; this.style.color='#F8F5F0'">
                    Update Product
                </button>
                <a href="{{ route('admin.products.index') }}"
                   style="background:transparent; color:#5A524A; border:1.5px solid #B0A898; font-family:'Jost',sans-serif; font-size:0.88rem; font-weight:400; letter-spacing:0.05em; text-transform:uppercase; padding:0.82rem 2rem; text-decoration:none; transition:border-color 0.25s, color 0.25s; display:inline-block; border-radius:2px;"
                   onmouseover="this.style.borderColor='#B5975A'; this.style.color='#B5975A'"
                   onmouseout="this.style.borderColor='#B0A898'; this.style.color='#5A524A'">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>

<script>
    function setFieldState(input, isError, message) {
        const name  = input.name.replace('[]', '');
        const errEl = document.getElementById(name + '-error');
        input.style.borderColor = isError ? '#C97A7A' : '#B5975A';
        if (errEl) {
            errEl.textContent   = isError ? message : '';
            errEl.style.display = isError ? 'block' : 'none';
        }
    }

    function validateField(input, min, max) {
        const val = input.value.trim();
        if (val === '') {
            setFieldState(input, true, 'This field is required.');
        } else if (val.length < min) {
            setFieldState(input, true, 'Must be at least ' + min + ' characters. Currently: ' + val.length + '.');
        } else if (val.length > max) {
            setFieldState(input, true, 'Cannot exceed ' + max + ' characters.');
        } else {
            setFieldState(input, false, '');
        }
    }

    function deleteImage(btn) {
        if (!confirm('Remove this image?')) return;
        var url = btn.getAttribute('data-url');
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(function(r) {
            if (!r.ok) throw new Error('Server error: ' + r.status);
            return r.json();
        })
        .then(function(data) {
            if (data.success) {
                btn.closest('.img-thumb').remove();
            } else {
                alert('Could not delete image. Please try again.');
            }
        })
        .catch(function(err) {
            console.error('Delete image error:', err);
            alert('Could not delete image. Please try again.');
        });
    }

    document.getElementById('edit-product-form').addEventListener('submit', function(e) {
        var hasError = false;

        var pn = document.getElementById('product_name');
        if (pn.value.trim().length < 2) {
            setFieldState(pn, true, pn.value.trim() === ''
                ? 'Product name is required.'
                : 'Product name must be at least 2 characters.');
            hasError = true;
        }

        var sq = document.getElementById('stock_quantity');
        if (sq.value === '' || parseInt(sq.value) < 0) {
            setFieldState(sq, true, sq.value === '' ? 'Stock quantity is required.' : 'Stock quantity cannot be negative.');
            hasError = true;
        }

        var cat = document.getElementById('category_id');
        if (!cat.value) {
            setFieldState(cat, true, 'Please select a category.');
            hasError = true;
        }

        var sup = document.getElementById('supplier_id');
        if (!sup.value) {
            setFieldState(sup, true, 'Please select a supplier.');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            var first = document.querySelector('.field-error[style*="block"]');
            if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var cb = document.getElementById('is_active');
        if (cb) {
            cb.style.background  = cb.checked ? '#2C2825' : '#fff';
            cb.style.borderColor = cb.checked ? '#2C2825' : '#B0A898';
        }
    });
</script>

@endsection