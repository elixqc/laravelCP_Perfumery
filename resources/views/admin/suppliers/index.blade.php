@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-black">
    <div class="container mx-auto px-4 py-8">
        <!-- Luxury Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-serif font-bold text-gold-400 mb-4 tracking-wider">SUPPLIER MANAGEMENT</h1>
            <p class="text-gold-300 text-lg font-light tracking-widest uppercase">Prestige Supply Partners</p>
        </div>

        <!-- Add Supplier Button -->
        <div class="mb-8 text-center">
            <a href="{{ route('admin.suppliers.create') }}"
               class="inline-flex items-center bg-gradient-to-r from-gold-500 to-gold-600 hover:from-gold-600 hover:to-gold-700 text-black font-semibold py-3 px-8 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-gold-400/25">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Supplier
            </a>
        </div>

        <!-- Suppliers Table -->
        <div class="bg-black/40 backdrop-blur-sm border border-gold-400/20 rounded-lg shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gold-400/10">
                        <tr>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">ID</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Company Name</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Contact Person</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Email</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Phone</th>
                            <th class="border-b border-gold-400/20 px-6 py-4 text-left text-sm font-semibold text-gold-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gold-400/10">
                        @forelse($suppliers as $supplier)
                            <tr class="hover:bg-gold-400/5 transition-colors duration-200">
                                <td class="px-6 py-4 text-sm text-white font-mono">{{ $supplier->supplier_id }}</td>
                                <td class="px-6 py-4 text-sm text-white font-medium">{{ $supplier->company_name }}</td>
                                <td class="px-6 py-4 text-sm text-white">{{ $supplier->contact_person }}</td>
                                <td class="px-6 py-4 text-sm text-gold-300">{{ $supplier->email }}</td>
                                <td class="px-6 py-4 text-sm text-white">{{ $supplier->phone }}</td>
                                <td class="px-6 py-4 text-sm space-x-3">
                                    <a href="{{ route('admin.suppliers.edit', $supplier->supplier_id) }}"
                                       class="inline-flex items-center text-gold-400 hover:text-gold-300 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier->supplier_id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center text-red-400 hover:text-red-300 transition-colors duration-200"
                                                onclick="return confirm('Are you sure you want to delete this supplier?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gold-300">
                                        <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No suppliers found</p>
                                        <p class="text-sm opacity-75">Start by adding your first luxury fragrance supplier</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($suppliers->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection