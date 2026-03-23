@extends('layouts.admin')

@section('title', 'Reviews — {{ $product->product_name }} — Prestige Admin')

@section('content')

<div id="pa-toast-stack"></div>

{{-- Delete modal --}}
<div class="pa-overlay" id="pa-delete-overlay" aria-modal="true" role="dialog">
    <div class="pa-modal">
        <div class="pa-modal__head">
            <span class="pa-modal__eyebrow">Permanent action</span>
            <h2 class="pa-modal__title">Delete this review?</h2>
        </div>
        <div class="pa-modal__body">
            <span class="pa-modal__product-name" id="pa-modal-review-label">—</span>
            <p class="pa-modal__text">
                This review will be permanently removed and cannot be recovered.
            </p>
        </div>
        <div class="pa-modal__foot">
            <button class="pa-modal__cancel" id="pa-modal-cancel">Cancel</button>
            <button class="pa-modal__confirm" id="pa-modal-confirm">Delete review</button>
        </div>
    </div>
</div>

<div class="pa-page">

    {{-- Page Header --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Products</span>
            <h1 class="pa-page-title">
                Reviews
                <span style="font-family:'Jost',sans-serif; font-size:1rem; font-weight:300; color:var(--stone); font-style:normal; letter-spacing:0.06em; margin-left:0.5rem;">
                    — {{ $product->product_name }}
                </span>
            </h1>
        </div>
        <div class="pa-page-header-meta">
            <a href="{{ route('admin.products.index') }}" class="pa-btn-outline">
                ← Back to Products
            </a>
        </div>
    </div>

    <div class="pa-section">

        {{-- Stats Ribbon --}}
        <div class="pa-stats-ribbon">
            <div class="pa-stat-tile">
                <span class="pa-stat-tile__label">Total Reviews</span>
                <span class="pa-stat-tile__value" id="stat-total">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--accent">
                <span class="pa-stat-tile__label">Avg Rating</span>
                <span class="pa-stat-tile__value" id="stat-avg">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--muted">
                <span class="pa-stat-tile__label">5 Star Reviews</span>
                <span class="pa-stat-tile__value" id="stat-five">—</span>
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
            <table id="reviews-table" class="pa-products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Date</th>
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

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
    /* ── Stars ── */
    .pa-stars { display:inline-flex; align-items:center; gap:1px; font-size:0.75rem; color:var(--gold); }
    .pa-stars .empty { color:#D0C8BE; }
    .pa-stars__num { font-family:'Cormorant Garamond',serif; font-size:0.95rem; font-weight:300; color:var(--ink); margin-left:0.4rem; }

    /* ── Review text ── */
    .pa-review-text { font-family:'Jost',sans-serif; font-size:0.82rem; font-weight:300; color:#5A524A; font-style:italic; max-width:420px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; display:block; }

    /* ── DataTables chrome — identical to products page ── */
    .dataTables_wrapper { padding:0; }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter { padding:1.4rem 1.6rem 1.2rem; border-bottom:1px solid #EEEBE4; background:#FDFBF8; }
    .dataTables_wrapper .dataTables_length { float:left; }
    .dataTables_wrapper .dataTables_filter { float:right; }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate { font-family:'Jost',sans-serif; font-size:0.72rem; letter-spacing:0.06em; color:#8C8078; font-weight:300; }
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate { padding:1.1rem 1.6rem; }
    .dataTables_wrapper::after { content:''; display:table; clear:both; }
    .dataTables_wrapper .dataTables_filter input { background:#F5F1EC; border:1px solid #D0C8BE; color:#1A1714; font-family:'Jost',sans-serif; font-size:0.8rem; font-weight:300; padding:0.52rem 0.9rem; outline:none; border-radius:0; margin-left:0.6rem; min-width:220px; transition:border-color 0.25s ease; }
    .dataTables_wrapper .dataTables_filter input:focus { border-color:#B5975A; background:#FDFBF8; }
    .dataTables_wrapper .dataTables_filter input::placeholder { color:#B0A898; opacity:1; }
    .dataTables_wrapper .dataTables_length label { display:flex; align-items:center; }
    .dataTables_wrapper .dataTables_length select { background:#F5F1EC; border:1px solid #D0C8BE; color:#1A1714; font-family:'Jost',sans-serif; font-size:0.8rem; font-weight:300; padding:0.45rem 1.6rem 0.45rem 0.6rem; outline:none; border-radius:0; margin:0 0.5rem; cursor:pointer; appearance:none; -webkit-appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='5' viewBox='0 0 8 5'%3E%3Cpath d='M0 0l4 5 4-5z' fill='%23B0A898'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 0.5rem center; background-size:7px; }
    .dataTables_wrapper .dataTables_length select:focus { border-color:#B5975A; }
    .dataTables_wrapper .dataTables_paginate { border-top:1px solid #EEEBE4; display:flex; align-items:center; justify-content:flex-end; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { font-family:'Jost',sans-serif !important; font-size:0.68rem !important; color:#8C8078 !important; background:transparent !important; border:1px solid transparent !important; border-radius:0 !important; padding:0.38rem 0.75rem !important; margin:0 1px; cursor:pointer; transition:all 0.2s ease !important; font-weight:300 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) { background:rgba(181,151,90,0.1) !important; border-color:rgba(181,151,90,0.3) !important; color:#B5975A !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover { background:#1A1714 !important; border-color:#1A1714 !important; color:#F8F5F0 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover { color:#D0C8BE !important; border-color:transparent !important; background:transparent !important; cursor:default; }
    .dataTables_wrapper .dataTables_info { font-size:0.68rem; color:#A09890; font-weight:300; }
    .dataTables_wrapper .dataTables_processing { font-family:'Jost',sans-serif; font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; color:#9A9088; background:rgba(253,251,248,0.95); border:1px solid #E2DDD5; padding:0.85rem 2rem; top:50%; }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after { display:none !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const CSRF      = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const productId = {{ $product->product_id }};

    function renderStars(n) {
        n = parseInt(n) || 0;
        let html = '<span class="pa-stars">';
        for (let i = 1; i <= 5; i++) html += `<span class="${i <= n ? '' : 'empty'}">★</span>`;
        html += `<span class="pa-stars__num">${n}.0</span></span>`;
        return html;
    }

    // ── DataTables ──
    const table = $('#reviews-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `/admin/products/${productId}/reviews/data`,
            type: 'GET',
            xhrFields: { withCredentials: true },
            headers: { 'X-CSRF-TOKEN': CSRF },
            error: () => showToast({ icon:'✕', iconClass:'pa-toast__icon--error', title:'Failed to load reviews', sub:'Please refresh.' }),
        },
        columns: [
            {
                data: 'review_id',
                name: 'review_id',
                render: d => `<span class="u-id">#${String(d).padStart(4,'0')}</span>`,
            },
            {
                data: 'user',
                name: 'user',
                render: d => `<span class="u-name" style="font-weight:300;">${d ?? '—'}</span>`,
            },
            {
                data: 'rating',
                name: 'rating',
                render: d => renderStars(d),
            },
            {
                data: 'review_text',
                name: 'review_text',
                orderable: false,
                render: d => {
                    const text = d ? `"${d}"` : '—';
                    return `<span class="pa-review-text" title="${d ?? ''}">${text}</span>`;
                },
            },
            {
                data: 'date_reviewed',
                name: 'date_reviewed',
                render: d => {
                    if (!d) return '<span class="u-id">—</span>';
                    const date = new Date(d);
                    return `<span style="font-family:'Jost',sans-serif;font-size:0.8rem;font-weight:300;color:#6A6058;">${date.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})}</span>`;
                },
            },
            {
                data: 'review_id',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: (d, type, row) =>
                    `<button type="button"
                         class="pa-action-link pa-action-link--danger pa-review-delete"
                         data-id="${d}"
                         data-label="Review by ${row.user ?? 'user'}">
                         Delete
                     </button>`,
            },
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        language: {
            search: '',
            searchPlaceholder: 'Search reviews…',
            lengthMenu: 'Show _MENU_ reviews',
            info: 'Showing _START_–_END_ of _TOTAL_',
            infoEmpty: 'No reviews found',
            processing: 'Loading…',
            zeroRecords: 'No reviews match your search',
            paginate: { first:'←', last:'→', next:'›', previous:'‹' },
        },
        drawCallback(settings) {
            updateStats(settings);
            bindDeleteButtons();
        },
    });

    // ── Stats ribbon ──
    function updateStats(settings) {
        const json = settings.json;
        if (!json) return;
        const data    = json.data || [];
        const ratings = data.map(r => parseInt(r.rating)).filter(Boolean);

        document.getElementById('stat-total').textContent = json.recordsTotal ?? '—';
        document.getElementById('stat-page').textContent  = data.length || '0';
        document.getElementById('stat-five').textContent  = ratings.filter(r => r === 5).length || '0';
        document.getElementById('stat-avg').textContent   = ratings.length
            ? (ratings.reduce((a, b) => a + b, 0) / ratings.length).toFixed(1)
            : '—';
    }

    // ── Delete modal ──
    const overlay    = document.getElementById('pa-delete-overlay');
    const labelEl    = document.getElementById('pa-modal-review-label');
    const confirmBtn = document.getElementById('pa-modal-confirm');
    const cancelBtn  = document.getElementById('pa-modal-cancel');
    let pendingId = null, pendingLabel = null;

    function bindDeleteButtons() {
        document.querySelectorAll('.pa-review-delete').forEach(btn => {
            btn.removeEventListener('click', onDeleteClick);
            btn.addEventListener('click', onDeleteClick);
        });
    }

    function onDeleteClick() {
        pendingId          = this.dataset.id;
        pendingLabel       = this.dataset.label;
        labelEl.textContent = pendingLabel;
        overlay.classList.add('pa-overlay--visible');
        setTimeout(() => confirmBtn.focus(), 320);
    }

    function closeModal() {
        overlay.classList.remove('pa-overlay--visible');
        pendingId = pendingLabel = null;
    }

    cancelBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    confirmBtn.addEventListener('click', () => {
        if (!pendingId) return;
        const id = pendingId, label = pendingLabel;
        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Deleting…';

        const deleteUrl = `{{ url('admin/reviews') }}/${id}`;
        axios.delete(deleteUrl, { headers: { 'X-CSRF-TOKEN': CSRF } })
            .then(() => {
                closeModal();
                table.ajax.reload(null, false);
                showToast({ icon:'◌', iconClass:'pa-toast__icon--delete', title:`<strong>${label}</strong> deleted`, sub:'Review removed permanently' });
            })
            .catch(err => {
                closeModal();
                showToast({ icon:'✕', iconClass:'pa-toast__icon--error', title:'Delete failed', sub: err.response?.data?.message || 'Please try again.' });
            })
            .finally(() => {
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Delete review';
            });
    });

    // ── Toast ──
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