@extends('layouts.admin')

@section('title', 'Products — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Inventory</span>
            <h1 class="pa-page-title">Products</h1>
        </div>
        <div style="display:flex; gap:0.75rem; align-items:center;">
            <a href="{{ route('admin.products.importForm') }}"
               style="background:transparent; color:#5A524A; border:1.5px solid #B0A898; font-family:'Jost',sans-serif; font-size:0.82rem; font-weight:400; letter-spacing:0.06em; text-transform:uppercase; padding:0.65rem 1.5rem; text-decoration:none; transition:border-color 0.25s, color 0.25s; display:inline-block; border-radius:2px; white-space:nowrap;"
               onmouseover="this.style.borderColor='#B5975A'; this.style.color='#B5975A'"
               onmouseout="this.style.borderColor='#B0A898'; this.style.color='#5A524A'">
                Import Products
            </a>
            <a href="{{ route('admin.products.create') }}"
               style="background:#2C2825; color:#F8F5F0; border:1.5px solid #2C2825; font-family:'Jost',sans-serif; font-size:0.82rem; font-weight:500; letter-spacing:0.06em; text-transform:uppercase; padding:0.65rem 1.5rem; text-decoration:none; transition:background 0.25s, color 0.25s; display:inline-block; border-radius:2px; white-space:nowrap;"
               onmouseover="this.style.background='#B5975A'; this.style.borderColor='#B5975A'; this.style.color='#1A1714'"
               onmouseout="this.style.background='#2C2825'; this.style.borderColor='#2C2825'; this.style.color='#F8F5F0'">
                + Add Product
            </a>
        </div>
    </div>

    {{-- ── Table Section ── --}}
    <div class="pa-section">

        {{-- Stats row --}}
        <div style="display:flex; gap:1px; background:#D6D0C8; border:1px solid #D6D0C8; margin-bottom:2rem;">
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Total Products</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#1A1714; line-height:1;">{{ $products->total() }}</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Active</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#4A6741; line-height:1;">{{ $products->where('is_active', true)->count() }}</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Inactive</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#856404; line-height:1;">{{ $products->where('is_active', false)->count() }}</span>
            </div>
            <div style="background:#1A1714; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:rgba(200,190,178,0.6); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">This Page</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#B5975A; line-height:1;">{{ $products->count() }}</span>
            </div>
        </div>

        {{-- Table --}}
        <div style="border:1px solid #D6D0C8; overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; background:#FDFBF8;">
                <thead>
                    <tr style="border-bottom:2px solid #D6D0C8; background:#F5F1EC;">
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">
                            ID
                        </th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">
                            Product Name
                        </th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">
                            Cost Price
                        </th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">
                            Selling Price
                        </th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">
                            Stock
                        </th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">
                            Status
                        </th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr style="border-bottom:1px solid #EDE8DF; transition:background 0.15s; {{ $product->trashed() ? 'opacity:0.55;' : '' }}"
                            onmouseover="this.style.background='#F5F1EC'"
                            onmouseout="this.style.background='transparent'">

                            {{-- ID --}}
                            <td style="padding:1rem 1.2rem; font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; vertical-align:middle;">
                                #{{ $product->product_id }}
                            </td>

                            {{-- Name + image --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle; min-width:220px;">
                                <div style="display:flex; align-items:center; gap:0.85rem;">
                                    @php
                                        $thumb = $product->productImages->first();
                                        $thumbUrl = $thumb ? asset('storage/' . $thumb->image_path) : null;
                                    @endphp
                                    @if($thumbUrl)
                                        <div style="width:42px; height:42px; overflow:hidden; background:#EDE8DF; border:1px solid #D6D0C8; flex-shrink:0;">
                                            <img src="{{ $thumbUrl }}" alt="{{ $product->product_name }}"
                                                 style="width:100%; height:100%; object-fit:cover; display:block;">
                                        </div>
                                    @else
                                        <div style="width:42px; height:42px; background:#EDE8DF; border:1px solid #D6D0C8; flex-shrink:0; display:flex; align-items:center; justify-content:center;">
                                            <span style="font-size:0.55rem; color:#B0A898; font-family:'Jost',sans-serif;">N/A</span>
                                        </div>
                                    @endif
                                    <div>
                                        <span style="font-size:0.92rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; display:block; line-height:1.3;">
                                            {{ $product->product_name }}
                                        </span>
                                        @if($product->variant)
                                            <span style="font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;">
                                                {{ $product->variant }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Cost Price --}}
                            <td style="padding:1rem 1.2rem; font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:300; vertical-align:middle;">
                                @if($product->initial_price !== null)
                                    ${{ number_format($product->initial_price, 2) }}
                                @else
                                    <span style="color:#C8BEB2;">—</span>
                                @endif
                            </td>

                            {{-- Selling Price --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                @if($product->selling_price !== null)
                                    <span style="font-family:'Cormorant Garamond',serif; font-size:1.05rem; font-weight:300; color:#B5975A; letter-spacing:0.02em;">
                                        ${{ number_format($product->selling_price, 2) }}
                                    </span>
                                @else
                                    <span style="color:#C8BEB2; font-size:0.88rem;">—</span>
                                @endif
                            </td>

                            {{-- Stock --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                @php
                                    $qty = $product->stock_quantity;
                                    $stockColor = $qty > 10 ? '#4A6741' : ($qty > 0 ? '#856404' : '#8B3A3A');
                                    $stockBg    = $qty > 10 ? '#F0F5EE' : ($qty > 0 ? '#FEF3CD' : '#F8EEEE');
                                @endphp
                                <span style="display:inline-block; background:{{ $stockBg }}; color:{{ $stockColor }}; font-family:'Jost',sans-serif; font-size:0.75rem; font-weight:500; letter-spacing:0.08em; padding:0.2rem 0.65rem; border-radius:2px;">
                                    {{ $qty }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <div style="display:flex; flex-wrap:wrap; gap:0.4rem; align-items:center;">
                                    <span style="display:inline-block; font-size:0.68rem; letter-spacing:0.15em; text-transform:uppercase; font-family:'Jost',sans-serif; font-weight:400; padding:0.25rem 0.7rem; border-radius:2px;
                                        {{ $product->is_active
                                            ? 'background:#F0F5EE; color:#4A6741;'
                                            : 'background:#F8EEEE; color:#8B3A3A;' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if($product->trashed())
                                        <span style="display:inline-block; font-size:0.68rem; letter-spacing:0.15em; text-transform:uppercase; font-family:'Jost',sans-serif; font-weight:400; padding:0.25rem 0.7rem; background:#F8EEEE; color:#8B3A3A; border-radius:2px;">
                                            Deleted
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle; white-space:nowrap;">
                                @if($product->trashed())
                                    <form method="POST" action="{{ route('admin.products.restore', $product->product_id) }}" style="display:inline;"
                                          onsubmit="return confirm('Restore this product?')">
                                        @csrf
                                        <button type="submit"
                                                style="background:none; border:none; cursor:pointer; font-family:'Jost',sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:0.08em; color:#4A6741; text-decoration:none; padding:0; transition:color 0.2s;"
                                                onmouseover="this.style.color='#2D5A25'"
                                                onmouseout="this.style.color='#4A6741'">
                                            Restore
                                        </button>
                                    </form>
                                @else
                                    <div style="display:flex; align-items:center; gap:1rem;">
                                        <a href="{{ route('admin.products.edit', $product->product_id) }}"
                                           style="font-family:'Jost',sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:0.08em; color:#2C2825; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
                                           onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
                                           onmouseout="this.style.color='#2C2825'; this.style.borderBottomColor='transparent'">
                                            Edit
                                        </a>
                                        <span style="color:#D6D0C8; font-size:0.7rem;">|</span>
                                        <a href="{{ route('admin.products.reviews', $product->product_id) }}"
                                           style="font-family:'Jost',sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:0.08em; color:#4A6741; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
                                           onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
                                           onmouseout="this.style.color='#4A6741'; this.style.borderBottomColor='transparent'">
                                            View Reviews
                                        </a>
                                        <span style="color:#D6D0C8; font-size:0.7rem;">|</span>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product->product_id) }}" style="display:inline;"
                                              onsubmit="return confirm('Delete this product? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    style="background:none; border:none; cursor:pointer; font-family:'Jost',sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:0.08em; color:#8B3A3A; padding:0; transition:color 0.2s;"
                                                    onmouseover="this.style.color='#C97A7A'"
                                                    onmouseout="this.style.color='#8B3A3A'">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:4rem 1.2rem; text-align:center;">
                                <span style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:300; color:#C8BEB2; font-style:italic; display:block; margin-bottom:0.5rem;">
                                    No products found
                                </span>
                                <a href="{{ route('admin.products.create') }}"
                                   style="font-size:0.78rem; color:#B5975A; font-family:'Jost',sans-serif; font-weight:400; letter-spacing:0.1em; text-decoration:none; border-bottom:1px solid #B5975A; padding-bottom:1px;">
                                    Add your first product →
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="pp-pagination" style="margin-top:2rem;">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</div>
@endsection