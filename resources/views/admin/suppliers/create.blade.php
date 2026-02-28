@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-black flex items-center justify-center px-4 py-8">
    <div class="max-w-2xl w-full">
        <!-- Luxury Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-serif font-bold text-gold-400 mb-2 tracking-wider">ADD SUPPLIER</h1>
            <p class="text-gold-300 text-sm font-light tracking-widest uppercase">New Supply Partner</p>
        </div>

        <!-- Form Card -->
        <div class="bg-black/40 backdrop-blur-sm border border-gold-400/20 rounded-lg p-8 shadow-2xl">
            <form method="POST" action="{{ route('admin.suppliers.store') }}" class="space-y-6">
                @csrf

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gold-300 mb-2">Company Name</label>
                    <input type="text"
                           name="company_name"
                           id="company_name"
                           value="{{ old('company_name') }}"
                           class="w-full bg-gray-800/50 border border-gold-400/30 rounded-md px-4 py-3 text-white placeholder-gold-400/50 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:border-transparent transition-all duration-200"
                           placeholder="Enter company name"
                           required>
                    @error('company_name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Person -->
                <div>
                    <label for="contact_person" class="block text-sm font-medium text-gold-300 mb-2">Contact Person</label>
                    <input type="text"
                           name="contact_person"
                           id="contact_person"
                           value="{{ old('contact_person') }}"
                           class="w-full bg-gray-800/50 border border-gold-400/30 rounded-md px-4 py-3 text-white placeholder-gold-400/50 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:border-transparent transition-all duration-200"
                           placeholder="Enter contact person name"
                           required>
                    @error('contact_person')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gold-300 mb-2">Email Address</label>
                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email') }}"
                           class="w-full bg-gray-800/50 border border-gold-400/30 rounded-md px-4 py-3 text-white placeholder-gold-400/50 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:border-transparent transition-all duration-200"
                           placeholder="supplier@company.com"
                           required>
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gold-300 mb-2">Phone Number</label>
                    <input type="text"
                           name="phone"
                           id="phone"
                           value="{{ old('phone') }}"
                           class="w-full bg-gray-800/50 border border-gold-400/30 rounded-md px-4 py-3 text-white placeholder-gold-400/50 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:border-transparent transition-all duration-200"
                           placeholder="+1 (555) 123-4567"
                           required>
                    @error('phone')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gold-300 mb-2">Address</label>
                    <textarea name="address"
                              id="address"
                              rows="4"
                              class="w-full bg-gray-800/50 border border-gold-400/30 rounded-md px-4 py-3 text-white placeholder-gold-400/50 focus:outline-none focus:ring-2 focus:ring-gold-400 focus:border-transparent transition-all duration-200 resize-none"
                              placeholder="Enter supplier address">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex space-x-4 pt-4">
                    <a href="{{ route('admin.suppliers.index') }}"
                       class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded-md transition-all duration-200 text-center">
                        Cancel
                    </a>
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-gold-500 to-gold-600 hover:from-gold-600 hover:to-gold-700 text-black font-semibold py-3 px-4 rounded-md transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-gold-400/25">
                        Add Supplier
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Text -->
        <div class="text-center mt-8">
            <p class="text-gold-400/60 text-xs tracking-wider">BUILDING LUXURY PARTNERSHIPS</p>
        </div>
    </div>
</div>
@endsection