@extends('layouts.admin')

@section('title', 'Products — Prestige Admin')

@section('content')

{{-- ── Toast stack ── --}}
<div id="pa-toast-stack"></div>

{{-- ── Delete confirmation modal ── --}}
<div class="pa-overlay" id="pa-delete-overlay" aria-modal="true" role="dialog">
    <div class="pa-modal" id="pa-delete-modal">
        <div class="pa-modal__head">
            <span class="pa-modal__eyebrow">Irreversible action</span>
            <h2 class="pa-modal__title">Archive this product?</h2>
        </div>
        <div class="pa-modal__body">
            <span class="pa-modal__product-name" id="pa-modal-product-name">—</span>
            <p class="pa-modal__text">
                This product will be soft-deleted and hidden from the storefront.
                It can be restored at any time from the archive.
            </p>
        </div>
        <div class="pa-modal__foot">
            <button class="pa-modal__cancel" id="pa-modal-cancel">Cancel</button>
            <button class="pa-modal__confirm" id="pa-modal-confirm">Archive product</button>
        </div>
    </div>
</div>

<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Inventory</span>
            <h1 class="pa-page-title">Products</h1>
        </div>
        <div class="pa-page-actions">
            <a href="{{ route('admin.products.importForm') }}" class="pa-btn-outline">
                Import Products
            </a>
            <a href="{{ route('admin.products.create') }}" class="pa-btn-primary">
                + Add Product
            </a>
        </div>
    </div>

    {{-- ── Table Section ── --}}
    <div class="pa-section">

        {{-- Stats Ribbon --}}
        <div class="pa-stats-ribbon">
            <div class="pa-stat-tile">
                <span class="pa-stat-tile__label">Total Products</span>
                <span class="pa-stat-tile__value" id="stat-total">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--accent">
                <span class="pa-stat-tile__label">Active</span>
                <span class="pa-stat-tile__value" id="stat-active">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--muted">
                <span class="pa-stat-tile__label">Inactive</span>
                <span class="pa-stat-tile__value" id="stat-inactive">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--dark">
                <span class="pa-stat-tile__label">This Page</span>
                <span class="pa-stat-tile__value" id="stat-page">—</span>
                <span class="pa-stat-tile__rule pa-stat-tile__rule--gold"></span>
            </div>
        </div>

        {{-- Table --}}
        <div class="pa-table-shell">
            <table id="products-table" class="pa-products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Stock</th>
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

{{-- ── DataTables chrome overrides (only these stay here) ── --}}
<style>
    /* ── Wrapper layout ── */
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
    .dataTables_wrapper .dataTables_paginate {
        padding: 1.1rem 1.6rem;
    }

    /* Clearfix */
    .dataTables_wrapper::after { content: ''; display: table; clear: both; }

    /* ── Search input ── */
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

    .dataTables_wrapper .dataTables_filter input:focus  { border-color: #B5975A; background: #FDFBF8; }
    .dataTables_wrapper .dataTables_filter input::placeholder { color: #B0A898; opacity: 1; }

    /* ── Length select ── */
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

    /* ── Pagination ── */
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

    /* ── Info ── */
    .dataTables_wrapper .dataTables_info {
        font-size: 0.68rem;
        letter-spacing: 0.06em;
        color: #A09890;
        font-weight: 300;
    }

    /* ── Processing ── */
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

    /* ── Hide DataTables built-in sort icons (prestige.css handles them) ── */
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after {
        display: none !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // ═══════════════════════════════════════════════
        // DataTables
        // ═══════════════════════════════════════════════
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
                    showToast({ icon: '✕', iconClass: 'pa-toast__icon--error', title: 'Failed to load products', sub: 'Please refresh the page.' });
                },
            },
            columns: [
                // ID
                {
                    data: 'product_id',
                    name: 'product_id',
                    render: (data) =>
                        `<span class="u-id">#${String(data).padStart(4, '0')}</span>`,
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
                // Actions — delete button wired to modal below
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
                searchPlaceholder: 'Search products…',
                lengthMenu: 'Display _MENU_ products',
                info: 'Showing _START_–_END_ of _TOTAL_',
                infoEmpty: 'No products found',
                processing: 'Loading…',
                zeroRecords: 'No products match your search',
                paginate: { first: '←', last: '→', next: '›', previous: '‹' },
            },
            drawCallback: (settings) => {
                updateStats(settings);
                attachDeleteListeners();
            },
        });

        // ═══════════════════════════════════════════════
        // Stats ribbon
        // ═══════════════════════════════════════════════
        function updateStats(settings) {
            const json = settings.json;
            if (!json) return;

            if (json.stats) {
                document.getElementById('stat-total').textContent    = json.stats.total    ?? '—';
                document.getElementById('stat-active').textContent   = json.stats.active   ?? '—';
                document.getElementById('stat-inactive').textContent = json.stats.inactive ?? '—';
            }

            document.getElementById('stat-page').textContent = (json.data || []).length || '0';
        }

        // ═══════════════════════════════════════════════
        // Delete confirmation modal
        // ═══════════════════════════════════════════════
        const overlay     = document.getElementById('pa-delete-overlay');
        const nameEl      = document.getElementById('pa-modal-product-name');
        const confirmBtn  = document.getElementById('pa-modal-confirm');
        const cancelBtn   = document.getElementById('pa-modal-cancel');

        let pendingDeleteId   = null;
        let pendingDeleteName = null;

        // Re-bind after every DataTables draw (server-side)
        function attachDeleteListeners() {
            // Render delete buttons with: class="pa-product-delete" data-product-id="ID" data-product-name="NAME"
            document.querySelectorAll('.pa-product-delete').forEach(btn => {
                btn.removeEventListener('click', onDeleteClick);
                btn.addEventListener('click', onDeleteClick);
            });
        }

        function onDeleteClick(e) {
            e.preventDefault();
            pendingDeleteId   = this.dataset.productId;
            pendingDeleteName = this.dataset.productName || 'this product';
            nameEl.textContent = pendingDeleteName;
            openModal();
        }

        function openModal() {
            overlay.classList.add('pa-overlay--visible');
            // Trap focus on confirm button
            setTimeout(() => confirmBtn.focus(), 320);
        }

        function closeModal() {
            overlay.classList.remove('pa-overlay--visible');
            pendingDeleteId   = null;
            pendingDeleteName = null;
        }

        // Close on backdrop click
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal();
        });

        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && overlay.classList.contains('pa-overlay--visible')) closeModal();
        });

        cancelBtn.addEventListener('click', closeModal);

        // Confirm — send DELETE request
        confirmBtn.addEventListener('click', () => {
            if (!pendingDeleteId) return;

            const id   = pendingDeleteId;
            const name = pendingDeleteName;

            confirmBtn.disabled    = true;
            confirmBtn.textContent = 'Archiving…';

            axios.delete(`/admin/products/${id}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(() => {
                closeModal();
                table.ajax.reload(null, false);
                showToast({
                    icon: '◌',
                    iconClass: 'pa-toast__icon--delete',
                    title: `<strong>${name}</strong> archived`,
                    sub: 'Product soft-deleted successfully',
                });
            })
            .catch((err) => {
                closeModal();
                const msg = err.response?.data?.message || 'Delete failed. Please try again.';
                showToast({ icon: '✕', iconClass: 'pa-toast__icon--error', title: 'Archive failed', sub: msg });
            })
            .finally(() => {
                confirmBtn.disabled    = false;
                confirmBtn.textContent = 'Archive product';
            });
        });

        // ═══════════════════════════════════════════════
        // Toast
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