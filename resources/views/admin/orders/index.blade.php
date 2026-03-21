@extends('layouts.admin')

@section('title', 'Orders — Prestige Admin')

@section('content')

{{-- ── Toast stack ── --}}
<div id="pa-toast-stack"></div>

<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Orders</span>
            <h1 class="pa-page-title">Orders</h1>
        </div>
        <div class="pa-page-header-meta">
            <span class="pa-header-date" id="current-date"></span>
        </div>
    </div>

    <div class="pa-section">

        {{-- ── Stats Ribbon ── --}}
        <div class="pa-stats-ribbon" style="grid-template-columns: repeat(5, 1fr);">
            <div class="pa-stat-tile">
                <span class="pa-stat-tile__label">Total Orders</span>
                <span class="pa-stat-tile__value" id="stat-total">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--muted">
                <span class="pa-stat-tile__label">Pending</span>
                <span class="pa-stat-tile__value" id="stat-pending" style="color:#856404;">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile" style="background:#F0F4FA;">
                <span class="pa-stat-tile__label">Processing</span>
                <span class="pa-stat-tile__value" id="stat-processing" style="color:#3A5580;">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--accent">
                <span class="pa-stat-tile__label">Completed</span>
                <span class="pa-stat-tile__value" id="stat-completed">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--dark">
                <span class="pa-stat-tile__label">Cancelled</span>
                <span class="pa-stat-tile__value" id="stat-cancelled">—</span>
                <span class="pa-stat-tile__rule pa-stat-tile__rule--gold"></span>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="pa-table-shell">
            <table id="orders-table" class="pa-products-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@section('scripts')

{{-- ── DataTables CDN (page-specific) ── --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

{{-- ── DataTables chrome overrides only ── --}}
<style>
    .dataTables_wrapper { padding: 0; }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        padding: 1.4rem 1.6rem 1.2rem;
        border-bottom: 1px solid #EEEBE4;
        background: #FDFBF8;
    }

    .dataTables_wrapper .dataTables_length { float: left; }
    .dataTables_wrapper .dataTables_filter { float: right; }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-family: 'Jost', sans-serif;
        font-size: 0.72rem;
        letter-spacing: 0.06em;
        color: #8C8078;
        font-weight: 300;
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate { padding: 1.1rem 1.6rem; }

    .dataTables_wrapper::after { content: ''; display: table; clear: both; }

    .dataTables_wrapper .dataTables_filter input {
        background: #F5F1EC;
        border: 1px solid #D0C8BE;
        color: #1A1714;
        font-family: 'Jost', sans-serif;
        font-size: 0.8rem;
        font-weight: 300;
        letter-spacing: 0.04em;
        padding: 0.52rem 0.9rem;
        outline: none;
        border-radius: 0;
        margin-left: 0.6rem;
        min-width: 220px;
        transition: border-color 0.25s ease, background 0.25s ease;
    }

    .dataTables_wrapper .dataTables_filter input:focus        { border-color: #B5975A; background: #FDFBF8; }
    .dataTables_wrapper .dataTables_filter input::placeholder { color: #B0A898; opacity: 1; }

    .dataTables_wrapper .dataTables_length label { display: flex; align-items: center; }

    .dataTables_wrapper .dataTables_length select {
        background: #F5F1EC;
        border: 1px solid #D0C8BE;
        color: #1A1714;
        font-family: 'Jost', sans-serif;
        font-size: 0.8rem;
        font-weight: 300;
        padding: 0.45rem 1.6rem 0.45rem 0.6rem;
        outline: none;
        border-radius: 0;
        margin: 0 0.5rem;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='5' viewBox='0 0 8 5'%3E%3Cpath d='M0 0l4 5 4-5z' fill='%23B0A898'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 7px;
        transition: border-color 0.2s ease;
    }

    .dataTables_wrapper .dataTables_length select:focus { border-color: #B5975A; }

    .dataTables_wrapper .dataTables_paginate {
        border-top: 1px solid #EEEBE4;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-family: 'Jost', sans-serif !important;
        font-size: 0.68rem !important;
        letter-spacing: 0.06em !important;
        color: #8C8078 !important;
        background: transparent !important;
        border: 1px solid transparent !important;
        border-radius: 0 !important;
        padding: 0.38rem 0.75rem !important;
        margin: 0 1px;
        cursor: pointer;
        transition: all 0.2s ease !important;
        font-weight: 300 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
        background: rgba(181, 151, 90, 0.1) !important;
        border-color: rgba(181, 151, 90, 0.3) !important;
        color: #B5975A !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #1A1714 !important;
        border-color: #1A1714 !important;
        color: #F8F5F0 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #D0C8BE !important;
        border-color: transparent !important;
        background: transparent !important;
        cursor: default;
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 0.68rem;
        letter-spacing: 0.06em;
        color: #A09890;
        font-weight: 300;
    }

    .dataTables_wrapper .dataTables_processing {
        font-family: 'Jost', sans-serif;
        font-size: 0.65rem;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        color: #9A9088;
        background: rgba(253, 251, 248, 0.95);
        border: 1px solid #E2DDD5;
        padding: 0.85rem 2rem;
        top: 50%;
        box-shadow: 0 4px 24px rgba(26, 23, 20, 0.06);
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after { display: none !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // ── Date display ──
    const dateEl = document.getElementById('current-date');
    if (dateEl) {
        dateEl.textContent = new Date().toLocaleDateString('en-US', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
    }

    // ═══════════════════════════════════════════════
    // DataTables
    // ═══════════════════════════════════════════════
    const table = $('#orders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.orders.data") }}',
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            error: () => showToast({
                icon: '✕',
                iconClass: 'pa-toast__icon--error',
                title: 'Failed to load orders',
                sub: 'Please refresh the page.',
            }),
        },
        columns: [
            {
                data: 'order_id',
                name: 'order_id',
                render: (data) =>
                    `<span style="font-family:'Cormorant Garamond',serif; font-size:1rem; font-weight:300; color:#B5975A; letter-spacing:0.04em;">#${String(data).padStart(4,'0')}</span>`,
            },
            {
                data: 'customer',
                name: 'user.full_name',
                orderable: false,
            },
            {
                data: 'date',
                name: 'order_date',
            },
            {
                data: 'items',
                name: 'items',
                orderable: false,
                searchable: false,
            },
            {
                data: 'total',
                name: 'total',
                orderable: false,
                searchable: false,
            },
            {
                data: 'status',
                name: 'order_status',
                orderable: true,
                searchable: false,
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
            },
        ],
        order: [[2, 'desc']],
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        language: {
            search: '',
            searchPlaceholder: 'Search orders…',
            lengthMenu: 'Display _MENU_ orders',
            info: 'Showing _START_–_END_ of _TOTAL_',
            infoEmpty: 'No orders found',
            processing: 'Loading…',
            zeroRecords: 'No orders match your search',
            paginate: { first: '←', last: '→', next: '›', previous: '‹' },
        },
        drawCallback: (settings) => {
            updateStats(settings);
        },
    });

    // ═══════════════════════════════════════════════
    // Stats ribbon — page-level counts from raw data
    // ═══════════════════════════════════════════════
    function updateStats(settings) {
        const json = settings.json;
        if (!json) return;

        document.getElementById('stat-total').textContent = json.recordsTotal ?? '—';

        const data = json.data || [];
        document.getElementById('stat-pending').textContent    = data.filter(o => o.order_status_raw === 'pending').length    || '0';
        document.getElementById('stat-processing').textContent = data.filter(o => o.order_status_raw === 'processing').length || '0';
        document.getElementById('stat-completed').textContent  = data.filter(o => o.order_status_raw === 'completed').length  || '0';
        document.getElementById('stat-cancelled').textContent  = data.filter(o => o.order_status_raw === 'cancelled').length  || '0';
    }

    // ═══════════════════════════════════════════════
    // Toast (for AJAX errors)
    // ═══════════════════════════════════════════════
    function showToast({ icon, iconClass, title, sub }) {
        const stack = document.getElementById('pa-toast-stack');
        const toast = document.createElement('div');
        toast.className = 'pa-toast';
        toast.innerHTML = `
            <span class="pa-toast__icon ${iconClass}">${icon}</span>
            <div class="pa-toast__body">
                <span class="pa-toast__title">${title}</span>
                <span class="pa-toast__sub">${sub}</span>
            </div>
            <button class="pa-toast__close" aria-label="Dismiss">&#x2715;</button>
        `;
        stack.appendChild(toast);
        requestAnimationFrame(() => requestAnimationFrame(() => toast.classList.add('pa-toast--in')));
        const timer = setTimeout(() => dismiss(toast), 3500);
        toast.dataset.timer = timer;
        toast.querySelector('.pa-toast__close').addEventListener('click', () => dismiss(toast));
        function dismiss(el) {
            clearTimeout(parseInt(el.dataset.timer));
            el.classList.replace('pa-toast--in', 'pa-toast--out');
            el.addEventListener('transitionend', () => el.remove(), { once: true });
        }
    }

});
</script>
@endsection