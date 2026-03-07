@extends('layouts.admin')

@section('title', 'Add New Product — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Inventory</span>
            <h1 class="pa-page-title">Add New Product</h1>
        </div>
        <a href="{{ route('admin.products.index') }}" class="pa-table-link"
           style="font-size:0.85rem; letter-spacing:0.05em; text-transform:none;">
            ← Back to Products
        </a>
    </div>

    {{-- ── Global Error Summary ── --}}
    @if($errors->any())
        <div style="max-width:700px; margin:0 auto 1.5rem; background:#FDF2F2; border:1.5px solid #C97A7A; padding:1rem 1.25rem; border-radius:2px;">
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

    {{-- ── Centered Form Container ── --}}
    <div style="max-width:700px; margin:0 auto; width:100%;">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="create-product-form" novalidate>
            @csrf

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
                               value="{{ old('product_name') }}"
                               minlength="2" maxlength="255" required
                               placeholder="e.g. Oud Royale Intense"
                               style="background:#fff; border:1.5px solid {{ $errors->has('product_name') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               oninput="validateField(this, 2, 255)"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="validateField(this, 2, 255)">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span id="product_name-error" class="field-error" style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('product_name') ? 'block' : 'none' }};">
                                @error('product_name') {{ $message }} @enderror
                            </span>
                            <span id="product_name-counter" style="font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; margin-left:auto;">
                                {{ strlen(old('product_name', '')) }}/255
                            </span>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="description" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Description
                            <span style="font-size:0.72rem; color:#8C8078; font-weight:400;"> (min. 10 characters if filled)</span>
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  minlength="10" maxlength="2000"
                                  placeholder="Describe the fragrance notes, mood, occasion…"
                                  style="background:#fff; border:1.5px solid {{ $errors->has('description') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; resize:vertical; min-height:110px; transition:border-color 0.2s; border-radius:2px;"
                                  oninput="validateTextarea(this, 10, 2000)"
                                  onfocus="this.style.borderColor='#B5975A'"
                                  onblur="validateTextarea(this, 10, 2000)">{{ old('description') }}</textarea>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span id="description-error" class="field-error" style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('description') ? 'block' : 'none' }};">
                                @error('description') {{ $message }} @enderror
                            </span>
                            <span id="description-counter" style="font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; margin-left:auto;">
                                {{ strlen(old('description', '')) }}/2000
                            </span>
                        </div>
                    </div>

                    {{-- Variant --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="variant" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Variant
                        </label>
                        <input type="text" name="variant" id="variant"
                               value="{{ old('variant') }}" placeholder="e.g. 50ml, 100ml, EDP"
                               style="background:#fff; border:1.5px solid #B0A898; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='#B0A898'">
                    </div>

                </div>
            </div>

            {{-- ── Section: Pricing & Inventory ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Pricing & Inventory
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem;">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">

                        {{-- Initial Price --}}
                        <div style="display:flex; flex-direction:column; gap:0.4rem;">
                            <label for="initial_price" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                                Cost Price
                            </label>
                            <div style="position:relative;">
                                <span style="position:absolute; left:0.85rem; top:50%; transform:translateY(-50%); font-size:0.9rem; color:#8C8078; pointer-events:none;">₱</span>
                                <input type="number" step="0.01" min="0" name="initial_price" id="initial_price"
                                       value="{{ old('initial_price') }}" placeholder="0.00"
                                       style="background:#fff; border:1.5px solid {{ $errors->has('initial_price') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem 0.75rem 2rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                                       oninput="validateNumeric(this)"
                                       onfocus="this.style.borderColor='#B5975A'"
                                       onblur="validateNumeric(this)">
                            </div>
                            <span id="initial_price-error" class="field-error" style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('initial_price') ? 'block' : 'none' }};">
                                @error('initial_price') {{ $message }} @enderror
                            </span>
                        </div>

                        {{-- Selling Price --}}
                        <div style="display:flex; flex-direction:column; gap:0.4rem;">
                            <label for="selling_price" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                                Selling Price
                            </label>
                            <div style="position:relative;">
                                <span style="position:absolute; left:0.85rem; top:50%; transform:translateY(-50%); font-size:0.9rem; color:#8C8078; pointer-events:none;">₱</span>
                                <input type="number" step="0.01" min="0" name="selling_price" id="selling_price"
                                       value="{{ old('selling_price') }}" placeholder="0.00"
                                       style="background:#fff; border:1.5px solid {{ $errors->has('selling_price') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem 0.75rem 2rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                                       oninput="validateNumeric(this)"
                                       onfocus="this.style.borderColor='#B5975A'"
                                       onblur="validateNumeric(this)">
                            </div>
                            <span id="selling_price-error" class="field-error" style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('selling_price') ? 'block' : 'none' }};">
                                @error('selling_price') {{ $message }} @enderror
                            </span>
                        </div>

                    </div>

                    {{-- Stock Quantity --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="stock_quantity" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Stock Quantity <span style="color:#C97A7A;">*</span>
                        </label>
                        <input type="number" min="0" name="stock_quantity" id="stock_quantity"
                               value="{{ old('stock_quantity') }}" required placeholder="0"
                               style="background:#fff; border:1.5px solid {{ $errors->has('stock_quantity') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; max-width:180px; transition:border-color 0.2s; border-radius:2px;"
                               oninput="validateStock(this)"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="validateStock(this)">
                        <span id="stock_quantity-error" class="field-error" style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('stock_quantity') ? 'block' : 'none' }};">
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
                        <div style="position:relative;">
                            <select name="category_id" id="category_id" required
                                    style="background:#fff; border:1.5px solid {{ $errors->has('category_id') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 2.5rem 0.75rem 1rem; outline:none; width:100%; appearance:none; -webkit-appearance:none; cursor:pointer; transition:border-color 0.2s; border-radius:2px;"
                                    onchange="validateSelect(this)"
                                    onfocus="this.style.borderColor='#B5975A'"
                                    onblur="validateSelect(this)">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); color:#8C8078; font-size:0.8rem; pointer-events:none;">▾</span>
                        </div>
                        <span id="category_id-error" class="field-error" style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('category_id') ? 'block' : 'none' }};">
                            @error('category_id') {{ $message }} @enderror
                        </span>
                    </div>

                    {{-- Supplier --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="supplier_id" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Supplier <span style="color:#C97A7A;">*</span>
                        </label>
                        <div style="position:relative;">
                            <select name="supplier_id" id="supplier_id" required
                                    style="background:#fff; border:1.5px solid {{ $errors->has('supplier_id') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 2.5rem 0.75rem 1rem; outline:none; width:100%; appearance:none; -webkit-appearance:none; cursor:pointer; transition:border-color 0.2s; border-radius:2px;"
                                    onchange="validateSelect(this)"
                                    onfocus="this.style.borderColor='#B5975A'"
                                    onblur="validateSelect(this)">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_id }}" {{ old('supplier_id') == $supplier->supplier_id ? 'selected' : '' }}>
                                        {{ $supplier->supplier_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); color:#8C8078; font-size:0.8rem; pointer-events:none;">▾</span>
                        </div>
                        <span id="supplier_id-error" class="field-error" style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('supplier_id') ? 'block' : 'none' }};">
                            @error('supplier_id') {{ $message }} @enderror
                        </span>
                    </div>

                </div>
            </div>

            {{-- ── Section: Images ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Product Images
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1rem;">

                    <label for="images" id="dropzone"
                           style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:0.6rem; padding:2rem 1.5rem; border:2px dashed #B0A898; background:#fff; cursor:pointer; transition:border-color 0.25s, background 0.25s; border-radius:2px;"
                           onmouseover="this.style.borderColor='#B5975A'; this.style.background='#F5F0E8'"
                           onmouseout="this.style.borderColor='#B0A898'; this.style.background='#fff'">
                        <span style="font-size:2rem; line-height:1; color:#B0A898;">↑</span>
                        <span id="dropzone-label" style="font-size:0.88rem; font-weight:500; color:#5A524A; font-family:'Jost',sans-serif; text-align:center;">
                            Click to choose images
                        </span>
                        <span style="font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif;">
                            JPG, PNG, WEBP — multiple files supported (max 4MB each)
                        </span>
                    </label>

                    <input type="file" name="images[]" id="images" accept="image/jpeg,image/png,image/webp" multiple style="display:none;" onchange="validateImages(this)">
                    <span id="images-error" class="field-error" style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('images') || $errors->has('images.*') ? 'block' : 'none' }};">
                        @error('images') {{ $message }} @enderror
                        @error('images.*') {{ $message }} @enderror
                    </span>
                    <div id="image-preview" style="display:none; grid-template-columns:repeat(5,1fr); gap:6px;"></div>

                </div>
            </div>

            {{-- ── Section: Visibility ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Visibility
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:1.5rem 2rem; display:flex; align-items:center; justify-content:space-between; gap:2rem;">
                    <div>
                        <span style="font-size:0.88rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif; display:block; margin-bottom:0.3rem;">
                            Active Listing
                        </span>
                        <span style="font-size:0.82rem; color:#8C8078; font-family:'Jost',sans-serif;">
                            Show this product to customers on the storefront
                        </span>
                    </div>
                    <label style="display:flex; align-items:center; gap:0.6rem; cursor:pointer; flex-shrink:0;">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
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
                    Create Product
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
    /* ── Helpers ── */
    function setFieldState(input, isError, message) {
        const name  = input.name.replace('[]', '');
        const errEl = document.getElementById(name + '-error');
        input.style.borderColor = isError ? '#C97A7A' : '#B5975A';
        if (errEl) {
            errEl.textContent   = isError ? message : '';
            errEl.style.display = isError ? 'block' : 'none';
        }
    }

    function updateCounter(input, max) {
        const counter = document.getElementById(input.id + '-counter');
        if (!counter) return;
        const len = input.value.length;
        counter.textContent = len + '/' + max;
        counter.style.color = len > max ? '#C97A7A' : '#8C8078';
    }

    /* ── Field Validators ── */
    function validateField(input, min, max) {
        const val = input.value.trim();
        updateCounter(input, max);
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

    function validateTextarea(textarea, min, max) {
        const val = textarea.value.trim();
        updateCounter(textarea, max);
        if (val === '') {
            // optional — clear error when empty
            const errEl = document.getElementById('description-error');
            if (errEl) { errEl.textContent = ''; errEl.style.display = 'none'; }
            textarea.style.borderColor = '#B0A898';
            return;
        }
        if (val.length < min) {
            setFieldState(textarea, true, 'Description must be at least ' + min + ' characters. Currently: ' + val.length + '.');
        } else if (val.length > max) {
            setFieldState(textarea, true, 'Cannot exceed ' + max + ' characters.');
        } else {
            setFieldState(textarea, false, '');
        }
    }

    function validateNumeric(input) {
        const val = input.value;
        if (val === '') { setFieldState(input, false, ''); return; } // optional
        if (isNaN(val) || parseFloat(val) < 0) {
            setFieldState(input, true, 'Must be a valid non-negative number.');
        } else {
            setFieldState(input, false, '');
        }
    }

    function validateStock(input) {
        const val = input.value.trim();
        if (val === '') {
            setFieldState(input, true, 'Stock quantity is required.');
        } else if (!Number.isInteger(Number(val)) || Number(val) < 0) {
            setFieldState(input, true, 'Must be a whole number (0 or more).');
        } else {
            setFieldState(input, false, '');
        }
    }

    function validateSelect(select) {
        if (!select.value) {
            setFieldState(select, true, 'Please select an option.');
        } else {
            setFieldState(select, false, '');
        }
    }

    function validateImages(input) {
        const errEl   = document.getElementById('images-error');
        const preview = document.getElementById('image-preview');
        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
        const maxSize = 4 * 1024 * 1024; // 4MB
        let errorMsg  = '';

        preview.innerHTML = '';

        if (!input.files || input.files.length === 0) {
            preview.style.display = 'none';
            document.getElementById('dropzone-label').textContent = 'Click to choose images';
            errEl.style.display = 'none';
            return;
        }

        Array.from(input.files).forEach((file) => {
            if (!allowed.includes(file.type)) {
                errorMsg = '"' + file.name + '" is not a valid image type. Use JPG, PNG, or WEBP.';
            } else if (file.size > maxSize) {
                errorMsg = '"' + file.name + '" exceeds the 4MB limit.';
            }
        });

        if (errorMsg) {
            errEl.textContent     = errorMsg;
            errEl.style.display   = 'block';
            input.value           = '';
            preview.style.display = 'none';
            document.getElementById('dropzone-label').textContent = 'Click to choose images';
            return;
        }

        errEl.style.display   = 'none';
        preview.style.display = 'grid';
        Array.from(input.files).forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const wrap  = document.createElement('div');
                wrap.style.cssText = 'aspect-ratio:1/1; overflow:hidden; background:#EDE8DF; border:1.5px solid #B5975A; position:relative; border-radius:2px;';
                const img   = document.createElement('img');
                img.src     = e.target.result;
                img.style.cssText = 'width:100%; height:100%; object-fit:cover; display:block;';
                const badge = document.createElement('span');
                badge.textContent = i + 1;
                badge.style.cssText = 'position:absolute; top:4px; left:4px; background:rgba(26,23,20,0.7); color:#fff; font-family:Jost,sans-serif; font-size:0.65rem; font-weight:500; padding:2px 7px;';
                wrap.appendChild(img);
                wrap.appendChild(badge);
                preview.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        });
        document.getElementById('dropzone-label').textContent =
            input.files.length + ' image' + (input.files.length > 1 ? 's' : '') + ' selected';
    }

    /* ── Client-side form guard before submit ── */
    document.getElementById('create-product-form').addEventListener('submit', function(e) {
        let hasError = false;

        // Product Name
        const pn = document.getElementById('product_name');
        if (pn.value.trim().length < 2) {
            setFieldState(pn, true, pn.value.trim() === ''
                ? 'Product name is required.'
                : 'Product name must be at least 2 characters.');
            hasError = true;
        }

        // Description (optional but min 10 if filled)
        const desc = document.getElementById('description');
        if (desc.value.trim().length > 0 && desc.value.trim().length < 10) {
            setFieldState(desc, true, 'Description must be at least 10 characters.');
            hasError = true;
        }

        // Stock Quantity
        const sq = document.getElementById('stock_quantity');
        if (sq.value.trim() === '' || !Number.isInteger(Number(sq.value)) || Number(sq.value) < 0) {
            setFieldState(sq, true, sq.value.trim() === ''
                ? 'Stock quantity is required.'
                : 'Must be a whole number (0 or more).');
            hasError = true;
        }

        // Category & Supplier
        ['category_id', 'supplier_id'].forEach(id => {
            const el = document.getElementById(id);
            if (!el.value) {
                setFieldState(el, true, 'Please select an option.');
                hasError = true;
            }
        });

        if (hasError) {
            e.preventDefault();
            const first = document.querySelector('.field-error[style*="block"]');
            if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    /* ── Init checkbox ── */
    document.addEventListener('DOMContentLoaded', () => {
        const cb = document.getElementById('is_active');
        if (cb) {
            cb.style.background  = cb.checked ? '#2C2825' : '#fff';
            cb.style.borderColor = cb.checked ? '#2C2825' : '#B0A898';
        }
    });
</script>

@endsection