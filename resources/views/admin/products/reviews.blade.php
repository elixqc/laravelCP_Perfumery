@extends('layouts.admin')

@section('title', 'Reviews — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Products</span>
            <h1 class="pa-page-title">
                Reviews
                <span style="font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:300; font-style:italic; color:#8C8078; margin-left:0.5rem;">
                    — {{ $product->product_name }}
                </span>
            </h1>
        </div>
        <a href="{{ route('admin.products.index') }}"
           style="font-size:0.85rem; letter-spacing:0.05em; font-family:'Jost',sans-serif; font-weight:400; color:#5A524A; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
           onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
           onmouseout="this.style.color='#5A524A'; this.style.borderBottomColor='transparent'">
            ← Back to Products
        </a>
    </div>

    <div class="pa-section">

        {{-- ── Stats Bar ── --}}
        <div style="display:flex; gap:1px; background:#D6D0C8; border:1px solid #D6D0C8; margin-bottom:2rem;">
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Total Reviews</span>
                <span id="stat-total" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#1A1714; line-height:1;">—</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Avg Rating</span>
                <span id="stat-avg" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#B5975A; line-height:1;">—</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">5-Star Reviews</span>
                <span id="stat-five" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#4A6741; line-height:1;">—</span>
            </div>
            <div style="background:#1A1714; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:rgba(200,190,178,0.6); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">This Page</span>
                <span id="stat-page" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#B5975A; line-height:1;">—</span>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div style="border:1px solid #D6D0C8; overflow-x:auto;">
            <table id="reviews-table" style="width:100%; border-collapse:collapse; background:#FDFBF8;">
                <thead>
                    <tr style="border-bottom:2px solid #D6D0C8; background:#F5F1EC;">
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">ID</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">User</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Rating</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Review</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Date</th>
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
        background: rgba(253,251,248,0.92);
        border: 1px solid #D6D0C8;
        padding: 0.75rem 1.5rem;
    }

    /* ── Table rows ── */
    #reviews-table tbody tr {
        border-bottom: 1px solid #EDE8DF;
        transition: background 0.15s;
    }
    #reviews-table tbody tr:hover  { background: #F5F1EC; }
    #reviews-table tbody tr:last-child { border-bottom: none; }

    /* Sorting arrows */
    #reviews-table thead th.sorting_asc::after  { content: ' ↑'; color: #B5975A; }
    #reviews-table thead th.sorting_desc::after { content: ' ↓'; color: #B5975A; }

    /* ── Delete button (server-rendered pa-button classes) ── */
    .pa-button {
        display: inline-block;
        font-family: 'Jost', sans-serif;
        font-size: 0.72rem;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 0.28rem 0.85rem;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .pa-button:hover    { opacity: 0.8; }
    .pa-button--small   { font-size: 0.68rem; padding: 0.22rem 0.65rem; }
    .pa-button--danger  { background: #F8EEEE; color: #8B3A3A; }
    .pa-button--danger:hover { background: #8B3A3A; color: #F8F5F0; opacity: 1; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const productId = {{ $product->product_id }};

        const table = $('#reviews-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `/admin/products/${productId}/reviews/data`,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                error: () => alert('Unable to load reviews. Please refresh the page.'),
            },
            columns: [
                // ID
                {
                    data: 'review_id',
                    name: 'review_id',
                    render: (data) =>
                        `<span style="font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;">#${data}</span>`,
                },
                // User — server-rendered string from addColumn('user')
                {
                    data: 'user',
                    name: 'user',
                    render: (data) =>
                        `<span style="font-size:0.92rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400;">${data}</span>`,
                },
                // Rating — client-rendered stars
                {
                    data: 'rating',
                    name: 'rating',
                    render: (data) => {
                        const stars = Array.from({ length: 5 }, (_, i) => {
                            const filled = i < data;
                            return `<svg width="12" height="12" viewBox="0 0 20 20" style="fill:${filled ? '#B5975A' : '#E8E2D9'}; flex-shrink:0;">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>`;
                        }).join('');
                        return `<div style="display:flex; align-items:center; gap:3px;">
                                    <div style="display:flex; gap:1px;">${stars}</div>
                                    <span style="font-family:'Cormorant Garamond',serif; font-size:1rem; font-weight:300; color:#B5975A; font-style:italic; margin-left:4px;">${data}.0</span>
                                </div>`;
                    },
                },
                // Review text — truncated with italic style
                {
                    data: 'review_text',
                    name: 'review_text',
                    render: (data) => {
                        const truncated = data && data.length > 80 ? data.substring(0, 80) + '…' : (data || '—');
                        return `<span style="font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:300; font-style:italic; line-height:1.5;">"${truncated}"</span>`;
                    },
                },
                // Date
                {
                    data: 'date_reviewed',
                    name: 'date_reviewed',
                    render: (data) => {
                        if (!data) return '<span style="color:#C8BEB2; font-size:0.82rem;">—</span>';
                        const d = new Date(data);
                        const formatted = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        return `<span style="font-size:0.82rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:300;">${formatted}</span>`;
                    },
                },
                // Actions — server-rendered pa-button HTML
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                },
            ],
            order: [[0, 'desc']],
            pageLength: 25,
            language: {
                search: '',
                searchPlaceholder: 'Search reviews…',
                lengthMenu: 'Show _MENU_ reviews',
                info: 'Showing _START_–_END_ of _TOTAL_ reviews',
                infoEmpty: 'No reviews found',
                processing: 'Loading…',
                zeroRecords: `<span style="font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:300; color:#C8BEB2; font-style:italic;">No reviews found</span>`,
            },
            drawCallback: (settings) => updateStats(settings),
            createdRow: (row) => {
                $(row).find('td').css({ padding: '1rem 1.2rem', verticalAlign: 'middle' });
            },
        });

        // ── Delete review ──────────────────────────────────────
        $('#reviews-table').on('click', '.delete-review', function () {
            if (!confirm('Delete this review? This cannot be undone.')) return;

            const reviewId = $(this).data('id');
            const btn = $(this);
            btn.text('Deleting…').prop('disabled', true);

            $.ajax({
                url: `/admin/reviews/${reviewId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                success: () => table.ajax.reload(null, false),
                error:   () => {
                    alert('Failed to delete review. Please try again.');
                    btn.text('Delete').prop('disabled', false);
                },
            });
        });

        // ── Stats bar ─────────────────────────────────────────
        function updateStats(settings) {
            const json = settings.json;
            if (!json) return;

            const data = json.data || [];
            document.getElementById('stat-total').textContent = json.recordsTotal ?? '—';
            document.getElementById('stat-page').textContent  = data.length || '0';

            const ratings = data.map(r => parseInt(r.rating)).filter(Boolean);
            if (ratings.length) {
                const avg = (ratings.reduce((a, b) => a + b, 0) / ratings.length).toFixed(1);
                document.getElementById('stat-avg').textContent  = avg;
                document.getElementById('stat-five').textContent = ratings.filter(r => r === 5).length;
            } else {
                document.getElementById('stat-avg').textContent  = '—';
                document.getElementById('stat-five').textContent = '0';
            }
        }
    });
</script>
@endsection