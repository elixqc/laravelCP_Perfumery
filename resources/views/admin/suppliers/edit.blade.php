@extends('layouts.admin')

@section('title', 'Edit Supplier — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
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

    {{-- ── Centered Form ── --}}
    <div style="max-width:700px; margin:0 auto; width:100%;">
        <form method="POST" action="{{ route('admin.suppliers.update', $supplier->supplier_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- ── Section: Supplier Details ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Supplier Information
                </p>

                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem;">

                    {{-- Company Name --}}
                    <div style="display:flex; flex-direction:column; gap:0.5rem;">
                        <label for="company_name" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Company Name <span style="color:#C97A7A;">*</span>
                        </label>
                        <input type="text"
                               name="company_name"
                               id="company_name"
                               value="{{ old('company_name', $supplier->company_name) }}"
                               required
                               placeholder="e.g. Maison Fragrance Co."
                               style="background:#fff; border:1.5px solid {{ $errors->has('company_name') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='{{ $errors->has('company_name') ? '#C97A7A' : '#B0A898' }}'">
                        @error('company_name')
                            <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Contact Person --}}
                    <div style="display:flex; flex-direction:column; gap:0.5rem;">
                        <label for="contact_person" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Contact Person <span style="color:#C97A7A;">*</span>
                        </label>
                        <input type="text"
                               name="contact_person"
                               id="contact_person"
                               value="{{ old('contact_person', $supplier->contact_person) }}"
                               required
                               placeholder="e.g. Jean-Pierre Moreau"
                               style="background:#fff; border:1.5px solid {{ $errors->has('contact_person') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='{{ $errors->has('contact_person') ? '#C97A7A' : '#B0A898' }}'">
                        @error('contact_person')
                            <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ── Section: Contact Details ── --}}
            <div style="margin-bottom:2rem;">
                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Contact Details
                </p>

                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem;">

                    {{-- Email + Phone side by side --}}
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">

                        {{-- Email --}}
                        <div style="display:flex; flex-direction:column; gap:0.5rem;">
                            <label for="email" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                                Email Address <span style="color:#C97A7A;">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email', $supplier->email) }}"
                                   required
                                   placeholder="contact@supplier.com"
                                   style="background:#fff; border:1.5px solid {{ $errors->has('email') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                                   onfocus="this.style.borderColor='#B5975A'"
                                   onblur="this.style.borderColor='{{ $errors->has('email') ? '#C97A7A' : '#B0A898' }}'">
                            @error('email')
                                <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div style="display:flex; flex-direction:column; gap:0.5rem;">
                            <label for="phone" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                                Phone Number <span style="color:#C97A7A;">*</span>
                            </label>
                            <input type="text"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone', $supplier->phone) }}"
                                   required
                                   placeholder="+1 (555) 000-0000"
                                   style="background:#fff; border:1.5px solid {{ $errors->has('phone') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                                   onfocus="this.style.borderColor='#B5975A'"
                                   onblur="this.style.borderColor='{{ $errors->has('phone') ? '#C97A7A' : '#B0A898' }}'">
                            @error('phone')
                                <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    {{-- Address --}}
                    <div style="display:flex; flex-direction:column; gap:0.5rem;">
                        <label for="address" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Address
                        </label>
                        <textarea name="address"
                                  id="address"
                                  rows="4"
                                  placeholder="Enter supplier address"
                                  style="background:#fff; border:1.5px solid {{ $errors->has('address') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; resize:vertical; min-height:110px; transition:border-color 0.2s; border-radius:2px;"
                                  onfocus="this.style.borderColor='#B5975A'"
                                  onblur="this.style.borderColor='{{ $errors->has('address') ? '#C97A7A' : '#B0A898' }}'">{{ old('address', $supplier->address) }}</textarea>
                        @error('address')
                            <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                        @enderror
                    </div>

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
@endsection