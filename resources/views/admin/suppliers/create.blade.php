
@extends('layouts.admin')

@section('content')
<div class="pa-page">
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Suppliers</span>
            <h1 class="pa-page-title">Add Supplier</h1>
        </div>
    </div>
    <div class="pa-section">
        <form method="POST" action="{{ route('admin.suppliers.store') }}" class="pa-form">
            @csrf
            <div class="pa-form-group">
                <label for="company_name" class="pa-label">Company Name</label>
                <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" class="pa-input" required>
                @error('company_name')
                    <p class="pa-form-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="pa-form-group">
                <label for="contact_person" class="pa-label">Contact Person</label>
                <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}" class="pa-input" required>
                @error('contact_person')
                    <p class="pa-form-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="pa-form-group">
                <label for="email" class="pa-label">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="pa-input" required>
                @error('email')
                    <p class="pa-form-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="pa-form-group">
                <label for="phone" class="pa-label">Phone Number</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="pa-input" required>
                @error('phone')
                    <p class="pa-form-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="pa-form-group">
                <label for="address" class="pa-label">Address</label>
                <textarea name="address" id="address" rows="4" class="pa-input" placeholder="Enter supplier address">{{ old('address') }}</textarea>
                @error('address')
                    <p class="pa-form-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="pa-form-actions">
                <a href="{{ route('admin.suppliers.index') }}" class="pa-btn pa-btn--ghost">Cancel</a>
                <button type="submit" class="pa-btn pa-btn--gold">Add Supplier</button>
            </div>
        </form>
    </div>
</div>
@endsection