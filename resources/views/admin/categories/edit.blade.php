@extends('layouts.admin')

@section('title', 'Edit Category — Prestige Admin')

@section('content')
<div class="pa-page">

    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Products</span>
            <h1 class="pa-page-title">Edit Category</h1>
        </div>
        <a href="{{ route('admin.categories.index') }}"
           style="font-size:0.85rem; letter-spacing:0.05em; text-transform:none; font-family:'Jost',sans-serif; font-weight:400; color:#5A524A; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
           onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
           onmouseout="this.style.color='#5A524A'; this.style.borderBottomColor='transparent'">
            ← Back to Categories
        </a>
    </div>

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

    <div style="max-width:700px; margin:0 auto; width:100%;">
        <form method="POST" action="{{ route('admin.categories.update', $category->category_id) }}" id="edit-category-form" novalidate>
            @csrf
            @method('PATCH')

            {{-- ── Category Information ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Category Information
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem;">

                    {{-- Category Name --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="category_name" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Category Name <span style="color:#C97A7A;">*</span>
                        </label>
                        <input type="text" name="category_name" id="category_name"
                               value="{{ old('category_name', $category->category_name) }}"
                               minlength="2" maxlength="50" required
                               placeholder="e.g. Floral, Woody, Fresh"
                               style="background:#fff; border:1.5px solid {{ $errors->has('category_name') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               oninput="validateField(this, 2, 50)"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="validateField(this, 2, 50)">
                        <span id="category_name-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('category_name') ? 'block' : 'none' }};">
                            @error('category_name') {{ $message }} @enderror
                        </span>
                    </div>

                </div>
            </div>

            {{-- ── Buttons ── --}}
            <div style="display:flex; gap:1rem; justify-content:flex-end; margin-top:2rem;">
                <a href="{{ route('admin.categories.index') }}" class="pa-btn-outline">
                    Cancel
                </a>
                <button type="submit" class="pa-btn-primary">
                    Update Category
                </button>
            </div>

        </form>
    </div>

</div>

<script>
function validateField(field, minLength, maxLength) {
    const value = field.value.trim();
    const errorElement = document.getElementById(field.id + '-error');
    
    if (!errorElement) return;

    if (value.length < minLength) {
        field.style.borderColor = '#C97A7A';
        errorElement.textContent = `Must be at least ${minLength} characters.`;
        errorElement.style.display = 'block';
    } else if (value.length > maxLength) {
        field.style.borderColor = '#C97A7A';
        errorElement.textContent = `Cannot exceed ${maxLength} characters.`;
        errorElement.style.display = 'block';
    } else {
        field.style.borderColor = '#B0A898';
        errorElement.style.display = 'none';
    }
}

document.getElementById('edit-category-form').addEventListener('submit', function(e) {
    const categoryName = document.getElementById('category_name');
    const value = categoryName.value.trim();

    if (value.length < 2 || value.length > 50) {
        e.preventDefault();
        validateField(categoryName, 2, 50);
    }
});
</script>

