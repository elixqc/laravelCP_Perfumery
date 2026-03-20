@extends('layouts.admin')

@section('title', 'Edit Supplier — Prestige Admin')

@section('content')
<div class="pa-page">

    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Suppliers</span>
            <h1 class="pa-page-title">Edit Supplier</h1>
        </div>
        <a href="{{ route('admin.suppliers.index') }}"
           style="font-size:0.85rem; letter-spacing:0.05em; text-transform:none; font-family:'Jost',sans-serif; font-weight:400; color:#5A524A; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
           onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
           onmouseout="this.style.color='#5A524A'; this.style.borderBottomColor='transparent'">
            ← Back to Suppliers
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
        <form method="POST" action="{{ route('admin.suppliers.update', $supplier->supplier_id) }}" id="edit-supplier-form" novalidate>
            @csrf
            @method('PATCH')

            {{-- ── Supplier Information ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Supplier Information
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem;">

                    {{-- Supplier Name --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="supplier_name" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Company Name <span style="color:#C97A7A;">*</span>
                        </label>
                        <input type="text" name="supplier_name" id="supplier_name"
                               value="{{ old('supplier_name', $supplier->supplier_name) }}"
                               minlength="2" maxlength="255" required
                               placeholder="e.g. Maison Fragrance Co."
                               style="background:#fff; border:1.5px solid {{ $errors->has('supplier_name') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               oninput="validateField(this, 2, 255)"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="validateField(this, 2, 255)">
                        <span id="supplier_name-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('supplier_name') ? 'block' : 'none' }};">
                            @error('supplier_name') {{ $message }} @enderror
                        </span>
                    </div>

                    {{-- Contact Person --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="contact_person" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Contact Person
                        </label>
                        <input type="text" name="contact_person" id="contact_person"
                               value="{{ old('contact_person', $supplier->contact_person) }}"
                               maxlength="255"
                               placeholder="e.g. Jean-Pierre Moreau"
                               style="background:#fff; border:1.5px solid {{ $errors->has('contact_person') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='{{ $errors->has('contact_person') ? '#C97A7A' : '#B0A898' }}'">
                        <span id="contact_person-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('contact_person') ? 'block' : 'none' }};">
                            @error('contact_person') {{ $message }} @enderror
                        </span>
                    </div>

                </div>
            </div>

            {{-- ── Contact Details ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Contact Details
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem;">

                    {{-- Contact Number --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="contact_number" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Phone Number
                        </label>
                        <input type="text" name="contact_number" id="contact_number"
                               value="{{ old('contact_number', $supplier->contact_number) }}"
                               maxlength="50"
                               placeholder="+63 912 345 6789"
                               style="background:#fff; border:1.5px solid {{ $errors->has('contact_number') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='{{ $errors->has('contact_number') ? '#C97A7A' : '#B0A898' }}'">
                        <span id="contact_number-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('contact_number') ? 'block' : 'none' }};">
                            @error('contact_number') {{ $message }} @enderror
                        </span>
                    </div>

                    {{-- Address --}}
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        <label for="address" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Address
                        </label>
                        <textarea name="address" id="address" rows="4"
                                  maxlength="500"
                                  placeholder="Enter supplier address"
                                  style="background:#fff; border:1.5px solid {{ $errors->has('address') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; resize:vertical; min-height:110px; transition:border-color 0.2s; border-radius:2px;"
                                  onfocus="this.style.borderColor='#B5975A'"
                                  onblur="this.style.borderColor='{{ $errors->has('address') ? '#C97A7A' : '#B0A898' }}'">{{ old('address', $supplier->address) }}</textarea>
                        <span id="address-error" class="field-error"
                              style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif; display:{{ $errors->has('address') ? 'block' : 'none' }};">
                            @error('address') {{ $message }} @enderror
                        </span>
                    </div>

                </div>
            </div>

            {{-- ── Status ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Status
                </p>
                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:1.5rem 2rem; display:flex; align-items:center; justify-content:space-between; gap:2rem;">
                    <div>
                        <span style="font-size:0.88rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif; display:block; margin-bottom:0.3rem;">Active Supplier</span>
                        <span style="font-size:0.82rem; color:#8C8078; font-family:'Jost',sans-serif;">Mark this supplier as active and available for product assignments</span>
                    </div>
                    <label style="display:flex; align-items:center; gap:0.6rem; cursor:pointer; flex-shrink:0;">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}
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
                    Update Supplier
                </button>
                <a href="{{ route('admin.suppliers.index') }}"
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
        const errEl = document.getElementById(input.name + '-error');
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

    document.getElementById('edit-supplier-form').addEventListener('submit', function(e) {
        let hasError = false;

        const sn = document.getElementById('supplier_name');
        if (sn.value.trim().length < 2) {
            setFieldState(sn, true, sn.value.trim() === ''
                ? 'Company name is required.'
                : 'Company name must be at least 2 characters.');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            const first = document.querySelector('.field-error[style*="block"]');
            if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const cb = document.getElementById('is_active');
        if (cb) {
            cb.style.background  = cb.checked ? '#2C2825' : '#fff';
            cb.style.borderColor = cb.checked ? '#2C2825' : '#B0A898';
        }
    });
</script>

@endsection