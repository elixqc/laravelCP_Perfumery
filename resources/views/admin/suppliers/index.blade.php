@extends('layouts.admin')

@section('title', 'Suppliers — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Suppliers</span>
            <h1 class="pa-page-title">Suppliers</h1>
        </div>
        <a href="{{ route('admin.suppliers.create') }}"
           style="background:#2C2825; color:#F8F5F0; border:1.5px solid #2C2825; font-family:'Jost',sans-serif; font-size:0.82rem; font-weight:500; letter-spacing:0.06em; text-transform:uppercase; padding:0.65rem 1.5rem; text-decoration:none; transition:background 0.25s, color 0.25s; display:inline-block; border-radius:2px; white-space:nowrap;"
           onmouseover="this.style.background='#B5975A'; this.style.borderColor='#B5975A'; this.style.color='#1A1714'"
           onmouseout="this.style.background='#2C2825'; this.style.borderColor='#2C2825'; this.style.color='#F8F5F0'">
            + Add Supplier
        </a>
    </div>

    <div class="pa-section">

        {{-- ── Stats Bar ── --}}
        <div style="display:flex; gap:1px; background:#D6D0C8; border:1px solid #D6D0C8; margin-bottom:2rem;">
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Total Suppliers</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#1A1714; line-height:1;">{{ $suppliers->total() }}</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">This Page</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#B5975A; line-height:1;">{{ $suppliers->count() }}</span>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div style="border:1px solid #D6D0C8; overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; background:#FDFBF8;">

                <thead>
                    <tr style="border-bottom:2px solid #D6D0C8; background:#F5F1EC;">
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">ID</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Company Name</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Contact Person</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Email</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Phone</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr style="border-bottom:1px solid #EDE8DF; transition:background 0.15s;"
                            onmouseover="this.style.background='#F5F1EC'"
                            onmouseout="this.style.background='transparent'">

                            {{-- ID --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;">
                                    #{{ $supplier->supplier_id }}
                                </span>
                            </td>

                            {{-- Company Name --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="font-family:'Cormorant Garamond',serif; font-size:1.05rem; font-weight:300; color:#1A1714; letter-spacing:0.03em; font-style:italic;">
                                    {{ $supplier->company_name ?? $supplier->supplier_name }}
                                </span>
                            </td>

                            {{-- Contact Person --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="font-size:0.92rem; color:#2C2825; font-family:'Jost',sans-serif; font-weight:400;">
                                    {{ $supplier->contact_person ?? '—' }}
                                </span>
                            </td>

                            {{-- Email --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                @if($supplier->email)
                                    <a href="mailto:{{ $supplier->email }}"
                                       style="font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:300; text-decoration:none; border-bottom:1px solid transparent; transition:color 0.2s, border-color 0.2s;"
                                       onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
                                       onmouseout="this.style.color='#5A524A'; this.style.borderBottomColor='transparent'">
                                        {{ $supplier->email }}
                                    </a>
                                @else
                                    <span style="color:#C8BEB2; font-size:0.88rem;">—</span>
                                @endif
                            </td>

                            {{-- Phone --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:300;">
                                    {{ $supplier->phone ?? '—' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle; white-space:nowrap;">
                                <div style="display:flex; align-items:center; gap:1rem;">
                                    <a href="{{ route('admin.suppliers.edit', $supplier->supplier_id) }}"
                                       style="font-family:'Jost',sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:0.08em; color:#2C2825; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
                                       onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
                                       onmouseout="this.style.color='#2C2825'; this.style.borderBottomColor='transparent'">
                                        Edit
                                    </a>
                                    <span style="color:#D6D0C8; font-size:0.7rem;">|</span>
                                    <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier->supplier_id) }}"
                                          style="display:inline;"
                                          onsubmit="return confirm('Delete this supplier? This cannot be undone.')">
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
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:4rem 1.2rem; text-align:center;">
                                <span style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:300; color:#C8BEB2; font-style:italic; display:block; margin-bottom:0.5rem;">
                                    No suppliers found
                                </span>
                                <a href="{{ route('admin.suppliers.create') }}"
                                   style="font-size:0.78rem; color:#B5975A; font-family:'Jost',sans-serif; font-weight:400; letter-spacing:0.1em; text-decoration:none; border-bottom:1px solid #B5975A; padding-bottom:1px;">
                                    Add your first supplier →
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($suppliers->hasPages())
            <div class="pp-pagination" style="margin-top:2rem;">
                {{ $suppliers->links() }}
            </div>
        @endif

    </div>
</div>
@endsection