@extends('layouts.admin')

@section('title', 'Orders — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Orders</span>
            <h1 class="pa-page-title">Orders</h1>
        </div>
    </div>

    <div class="pa-section">

        {{-- ── Stats Bar ── --}}
        <div style="display:flex; gap:1px; background:#D6D0C8; border:1px solid #D6D0C8; margin-bottom:2rem;">
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Total Orders</span>
                <span id="stat-total" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#1A1714; line-height:1;">—</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Pending</span>
                <span id="stat-pending" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#856404; line-height:1;">—</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Processing</span>
                <span id="stat-processing" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#3A5580; line-height:1;">—</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Completed</span>
                <span id="stat-completed" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#4A6741; line-height:1;">—</span>
            </div>
            <div style="background:#1A1714; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:rgba(200,190,178,0.6); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Cancelled</span>
                <span id="stat-cancelled" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#B5975A; line-height:1;">—</span>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div style="border:1px solid #D6D0C8; overflow-x:auto;">
            <table id="orders-table" style="width:100%; border-collapse:collapse; background:#FDFBF8;">
                <thead>
                    <tr style="border-bottom:2px solid #D6D0C8; background:#F5F1EC;">
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Order ID</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Customer</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Date</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Items</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Total</th>
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

    #orders-table tbody tr {
        border-bottom: 1px solid #EDE8DF;
        transition: background 0.15s;
    }
    #orders-table tbody tr:hover { background: #F5F1EC; }
    #orders-table tbody tr:last-child { border-bottom: none; }

    #orders-table thead th.sorting_asc::after  { content: ' ↑'; color: #B5975A; }
    #orders-table thead th.sorting_desc::after { content: ' ↓'; color: #B5975A; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {

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
            error: (xhr, error, thrown) => {
                console.error('DataTables AJAX error', xhr, error, thrown);
                alert('Unable to load orders. Please refresh the page.');
            },
        },
        columns: [
            {
                data: 'order_id',
                name: 'order_id',
                render: (data) =>
                    `<span style="font-family:'Cormorant Garamond',serif; font-size:1rem; font-weight:300; color:#B5975A; letter-spacing:0.04em;">#${data}</span>`,
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
                name: 'total_amount',
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
        language: {
            search: '',
            searchPlaceholder: 'Search orders…',
            lengthMenu: 'Show _MENU_ orders',
            info: 'Showing _START_–_END_ of _TOTAL_ orders',
            infoEmpty: 'No orders found',
            processing: 'Loading…',
            zeroRecords: `<span style="font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:300; color:#C8BEB2; font-style:italic;">No orders match your search</span>`,
        },
        drawCallback: (settings) => {
            updateStats(settings);
        },
        createdRow: (row) => {
            $(row).find('td').css({ padding: '1rem 1.2rem', verticalAlign: 'middle' });
        },
    });

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

});
</script>
@endsection