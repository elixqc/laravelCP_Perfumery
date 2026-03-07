@extends('layouts.admin')

@section('title', 'Import Products — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Inventory</span>
            <h1 class="pa-page-title">Import Products</h1>
        </div>
        <a href="{{ route('admin.products.index') }}"
           style="font-size:0.85rem; letter-spacing:0.05em; text-transform:none; font-family:'Jost',sans-serif; font-weight:400; color:#5A524A; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
           onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
           onmouseout="this.style.color='#5A524A'; this.style.borderBottomColor='transparent'">
            ← Back to Products
        </a>
    </div>

    {{-- ── Centered Card ── --}}
    <div style="max-width:620px; margin:0 auto; width:100%; display:flex; flex-direction:column; gap:1.5rem;">

        {{-- ── Upload Form ── --}}
        <div>
            <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                Upload File
            </p>

            <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem;">
                <form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- File input --}}
                    <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1.8rem;">
                        <label for="file" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                            Excel / CSV File <span style="color:#C97A7A;">*</span>
                        </label>

                        <label for="file" id="dropzone"
                               style="display:flex; flex-direction:column; align-items:center; justify-content:center; gap:0.6rem; padding:2.5rem 1.5rem; border:2px dashed #B0A898; background:#fff; cursor:pointer; transition:border-color 0.25s, background 0.25s; border-radius:2px;"
                               onmouseover="this.style.borderColor='#B5975A'; this.style.background='#F5F0E8'"
                               onmouseout="this.style.borderColor='#B0A898'; this.style.background='#fff'">
                            <span style="font-size:2rem; line-height:1; color:#B0A898;">↑</span>
                            <span id="dropzone-label" style="font-size:0.88rem; font-weight:500; color:#5A524A; font-family:'Jost',sans-serif; text-align:center;">
                                Click to choose a file
                            </span>
                            <span style="font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif;">
                                .xlsx, .xls, or .csv formats accepted
                            </span>
                        </label>

                        <input type="file" name="file" id="file"
                               accept=".xlsx,.xls,.csv" required
                               style="display:none;"
                               onchange="updateLabel(this)">

                        @error('file')
                            <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            style="width:100%; background:#2C2825; color:#F8F5F0; border:none; font-family:'Jost',sans-serif; font-size:0.88rem; font-weight:500; letter-spacing:0.1em; text-transform:uppercase; padding:0.9rem 2rem; cursor:pointer; transition:background 0.25s, color 0.25s; border-radius:2px;"
                            onmouseover="this.style.background='#B5975A'; this.style.color='#1A1714'"
                            onmouseout="this.style.background='#2C2825'; this.style.color='#F8F5F0'">
                        Import Products
                    </button>

                </form>
            </div>
        </div>

        {{-- ── Column Reference ── --}}
        <div>
            <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                Column Reference
            </p>

            <div style="background:#FDFBF8; border:1px solid #D6D0C8; overflow:hidden;">

                {{-- Required columns --}}
                <div style="padding:1.2rem 1.5rem; border-bottom:1px solid #EDE8DF; display:flex; align-items:baseline; gap:1rem;">
                    <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; font-family:'Jost',sans-serif; font-weight:500; color:#fff; background:#2C2825; padding:0.2rem 0.6rem; border-radius:2px; flex-shrink:0;">
                        Required
                    </span>
                    <div style="display:flex; flex-wrap:wrap; gap:0.5rem;">
                        @foreach(['product_name', 'stock_quantity'] as $col)
                            <code style="font-size:0.82rem; background:#F0EDE8; color:#2C2825; font-family:'Courier New', monospace; padding:0.2rem 0.6rem; border:1px solid #D6D0C8; border-radius:2px;">{{ $col }}</code>
                        @endforeach
                    </div>
                </div>

                {{-- Optional columns --}}
                <div style="padding:1.2rem 1.5rem; border-bottom:1px solid #EDE8DF; display:flex; align-items:baseline; gap:1rem;">
                    <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; font-family:'Jost',sans-serif; font-weight:500; color:#856404; background:#FEF3CD; padding:0.2rem 0.6rem; border-radius:2px; flex-shrink:0;">
                        Optional
                    </span>
                    <div style="display:flex; flex-wrap:wrap; gap:0.5rem;">
                        @foreach(['initial_price', 'selling_price', 'description', 'variant', 'is_active', 'category_id', 'supplier_id'] as $col)
                            <code style="font-size:0.82rem; background:#F0EDE8; color:#5A524A; font-family:'Courier New', monospace; padding:0.2rem 0.6rem; border:1px solid #D6D0C8; border-radius:2px;">{{ $col }}</code>
                        @endforeach
                    </div>
                </div>

                {{-- Note --}}
                <div style="padding:1.2rem 1.5rem; background:#F5F1EC; display:flex; gap:0.75rem; align-items:flex-start;">
                    <span style="font-size:1rem; line-height:1.2; flex-shrink:0;">ℹ</span>
                    <p style="font-size:0.82rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:400; line-height:1.65; margin:0;">
                        If both <code style="font-size:0.8rem; background:#E8E3DC; color:#2C2825; font-family:'Courier New',monospace; padding:1px 5px; border-radius:2px;">initial_price</code>
                        and <code style="font-size:0.8rem; background:#E8E3DC; color:#2C2825; font-family:'Courier New',monospace; padding:1px 5px; border-radius:2px;">selling_price</code>
                        are provided, <code style="font-size:0.8rem; background:#E8E3DC; color:#2C2825; font-family:'Courier New',monospace; padding:1px 5px; border-radius:2px;">price</code> is ignored.
                        If only <code style="font-size:0.8rem; background:#E8E3DC; color:#2C2825; font-family:'Courier New',monospace; padding:1px 5px; border-radius:2px;">price</code>
                        is provided, it will be used for both cost and selling price fields.
                    </p>
                </div>

            </div>
        </div>

    </div>

</div>

<script>
    function updateLabel(input) {
        const label = document.getElementById('dropzone-label');
        if (input.files && input.files.length > 0) {
            const file = input.files[0];
            const sizeKB = (file.size / 1024).toFixed(1);
            label.textContent = file.name + '  (' + sizeKB + ' KB)';
            document.getElementById('dropzone').style.borderColor = '#B5975A';
            document.getElementById('dropzone').style.background = '#F5F0E8';
        } else {
            label.textContent = 'Click to choose a file';
            document.getElementById('dropzone').style.borderColor = '#B0A898';
            document.getElementById('dropzone').style.background = '#fff';
        }
    }
</script>

@endsection