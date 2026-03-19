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
               style="background:transparent; color:#5A524A; border:1.5px solid #B0A898; font-family:'Jost',sans-serif; font-size:0.82rem; font-weight:400; letter-spacing:0.06em; text-transform:uppercase; padding:0.65rem 1.5rem; text-decoration:none; transition:border-color 0.25s,color 0.25s; display:inline-block; border-radius:2px; white-space:nowrap;"
               onmouseover="this.style.borderColor='#B5975A'; this.style.color='#B5975A'"
               onmouseout="this.style.borderColor='#B0A898'; this.style.color='#5A524A'">
                Import Products
            </a>
            <a href="{{ route('admin.products.create') }}"
               style="background:#2C2825; color:#F8F5F0; border:1.5px solid #2C2825; font-family:'Jost',sans-serif; font-size:0.82rem; font-weight:500; letter-spacing:0.06em; text-transform:uppercase; padding:0.65rem 1.5rem; text-decoration:none; transition:background 0.25s,color 0.25s; display:inline-block; border-radius:2px; white-space:nowrap;"
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
                <span id="stat-total" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#1A1714; line-height:1;">—</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Active</span>
                <span id="stat-active" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#4A6741; line-height:1;">—</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Inactive</span>
                <span id="stat-inactive" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#856404; line-height:1;">—</span>
            </div>
            <div style="background:#1A1714; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:rgba(200,190,178,0.6); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">This Page</span>
                <span id="stat-page" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#B5975A; line-height:1;">—</span>
            </div>
        </div>

        {{-- Table --}}
        <div style="border:1px solid #D6D0C8; overflow-x:auto;">
            <table id="products-table" style="width:100%; border-collapse:collapse; background:#FDFBF8;">
                <thead>
                    <tr style="border-bottom:2px solid #D6D0C8; background:#F5F1EC;">
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">ID</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Product Name</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Cost Price</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Selling Price</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Stock</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Status</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@section('scripts')

{{-- DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
    /* ── DataTables chrome ── */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-family: 'Jost', sans-serif;
        font-size: 0.82rem;
        color: #5A524A;
        padding: 1rem 0;
    }

    .dataTables_wrapper .dataTables_filter input {
        background: #fff;
        border: 1.5px solid #B0A898;
        color: #1A1714;
        font-family: 'Jost', sans-serif;
        font-size: 0.88rem;
        padding: 0.5rem 0.85rem;
        outline: none;
        border-radius: 2px;
        margin-left: 0.5rem;
        transition: border-color 0.2s;
    }
    .dataTables_wrapper .dataTables_filter input:focus { border-color: #B5975A; }

    .dataTables_wrapper .dataTables_length select {
        background: #fff;
        border: 1.5px solid #B0A898;
        color: #1A1714;
        font-family: 'Jost', sans-serif;
        font-size: 0.88rem;
        padding: 0.45rem 0.75rem;
        outline: none;
        border-radius: 2px;
        margin: 0 0.4rem;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-family: 'Jost', sans-serif !important;
        font-size: 0.75rem !important;
        color: #5A524A !important;
        background: transparent !important;
        border: 1px solid #D6D0C8 !important;
        border-radius: 2px !important;
        padding: 0.3rem 0.7rem !important;
        margin: 0 2px;
        cursor: pointer;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #B5975A !important;
        border-color: #B5975A !important;
        color: #1A1714 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #2C2825 !important;
        border-color: #2C2825 !important;
        color: #F8F5F0 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #C8BEB2 !important;
        border-color: #EDE8DF !important;
        background: transparent !important;
        cursor: default;
    }

    .dataTables_wrapper .dataTables_processing {
        font-family: 'Jost', sans-serif;
        font-size: 0.78rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #8C8078;
        background: rgba(253,251,248,0.9);
        border: 1px solid #D6D0C8;
        padding: 0.75rem 1.5rem;
    }

    /* ── Table rows ── */
    #products-table tbody tr {
        border-bottom: 1px solid #EDE8DF;
        transition: background 0.15s;
    }
    #products-table tbody tr:hover  { background: #F5F1EC; }
    #products-table tbody tr:last-child { border-bottom: none; }

    /* Sorting arrows */
    #products-table thead th.sorting_asc::after  { content: ' ↑'; color: #B5975A; }
    #products-table thead th.sorting_desc::after { content: ' ↓'; color: #B5975A; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const table = $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.products.data') }}',
                type: 'GET',
                dataType: 'json',
                crossDomain: false,
                xhrFields: { withCredentials: true },
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                error: (xhr, error, thrown) => {
                    console.error('DataTables AJAX error', xhr, error, thrown);
                    alert('Unable to load products. Please refresh the page.');
                },
            },
            columns: [
                // ID
                {
                    data: 'product_id',
                    name: 'product_id',
                    render: (data) =>
                        `<span style="font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;">#${data}</span>`,
                },
                // Product Name + thumbnail (HTML built server-side)
                {
                    data: 'name_col',
                    name: 'product_name',
                    orderable: true,
                    searchable: true,
                },
                // Cost Price (HTML built server-side)
                {
                    data: 'cost_price',
                    name: 'initial_price',
                    orderable: true,
                    searchable: false,
                },
                // Selling Price (HTML built server-side)
                {
                    data: 'sell_price',
                    name: 'selling_price',
                    orderable: true,
                    searchable: false,
                },
                // Stock (HTML built server-side)
                {
                    data: 'stock',
                    name: 'stock_quantity',
                    orderable: true,
                    searchable: false,
                },
                // Status (HTML built server-side)
                {
                    data: 'status_display',
                    name: 'is_active',
                    orderable: false,
                    searchable: false,
                },
                // Actions (HTML built server-side)
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                },
            ],
            order: [[0, 'desc']],
            pageLength: 10,
            language: {
                search: '',
                searchPlaceholder: 'Search products…',
                lengthMenu: 'Show _MENU_ products',
                info: 'Showing _START_–_END_ of _TOTAL_ products',
                infoEmpty: 'No products found',
                processing: 'Loading…',
                zeroRecords: `<span style="font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:300; color:#C8BEB2; font-style:italic;">No products match your search</span>`,
            },
            drawCallback: (settings) => {
                updateStats(settings);
            },
            createdRow: (row) => {
                $(row).find('td').css({ padding: '1rem 1.2rem', verticalAlign: 'middle' });
            },
        });

        // ── Stats bar: global counts from server, this-page count from data length ──
        function updateStats(settings) {
            const json = settings.json;
            if (!json) return;

            // Global counts sent via ->with('stats', [...]) from the controller
            if (json.stats) {
                document.getElementById('stat-total').textContent   = json.stats.total   ?? '—';
                document.getElementById('stat-active').textContent  = json.stats.active  ?? '—';
                document.getElementById('stat-inactive').textContent= json.stats.inactive?? '—';
            }

            // This-page count
            document.getElementById('stat-page').textContent = (json.data || []).length || '0';
        }
    });
</script>
@endsection