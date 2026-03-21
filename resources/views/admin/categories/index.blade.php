@extends('layouts.admin')

@section('title', 'Categories — Prestige Admin')

@section('content')

{{-- ── Toast stack ── --}}
<div id="pa-toast-stack"></div>

{{-- ── Delete confirmation modal ── --}}
<div class="pa-overlay" id="pa-delete-overlay" aria-modal="true" role="dialog">
    <div class="pa-modal">
        <div class="pa-modal__head">
            <span class="pa-modal__eyebrow">Permanent action</span>
            <h2 class="pa-modal__title">Delete this category?</h2>
        </div>
        <div class="pa-modal__body">
            <span class="pa-modal__product-name" id="pa-modal-category-name">—</span>
            <p class="pa-modal__text">
                This category will be permanently deleted. Products assigned to it
                will need to be re-categorised.
            </p>
        </div>
        <div class="pa-modal__foot">
            <button class="pa-modal__cancel" id="pa-modal-cancel">Cancel</button>
            <button class="pa-modal__confirm" id="pa-modal-confirm">Delete category</button>
        </div>
    </div>
</div>

{{-- ── Add / Edit inline modal ── --}}
<div class="pa-overlay" id="pa-form-overlay" aria-modal="true" role="dialog">
    <div class="pa-modal" id="pa-form-modal">
        <div class="pa-modal__head">
            <span class="pa-modal__eyebrow" id="pa-form-eyebrow" style="color:#B5975A;">New Category</span>
            <h2 class="pa-modal__title" id="pa-form-title">Add Category</h2>
        </div>
        <div class="pa-modal__body">
            <p class="pa-modal__text" style="margin-bottom:1.4rem;">
                Category names appear on the storefront and are used to group and filter products.
                Keep them short and descriptive.
            </p>
            <div style="display:flex; flex-direction:column; gap:0.5rem;">
                <label style="font-size:0.57rem; letter-spacing:0.3em; text-transform:uppercase; color:#9A9088; font-family:'Jost',sans-serif; font-weight:400;"
                       for="pa-category-input">Category Name</label>
                <input id="pa-category-input"
                       type="text"
                       placeholder="e.g. Women's Fragrances"
                       maxlength="50"
                       autocomplete="off"
                       style="background:#F5F1EC; border:1px solid #D0C8BE; color:#1A1714; font-family:'Jost',sans-serif; font-size:0.9rem; font-weight:300; letter-spacing:0.03em; padding:0.75rem 1rem; outline:none; border-radius:0; width:100%; transition:border-color 0.2s ease, background 0.2s ease;"
                       onfocus="this.style.borderColor='#B5975A'; this.style.background='#FDFBF8';"
                       onblur="this.style.borderColor='#D0C8BE'; this.style.background='#F5F1EC';">
                <span id="pa-category-error"
                      style="display:none; font-size:0.65rem; letter-spacing:0.1em; color:#8B3A3A; font-family:'Jost',sans-serif; font-weight:300; margin-top:0.15rem;"></span>
            </div>
        </div>
        <div class="pa-modal__foot">
            <button class="pa-modal__cancel" id="pa-form-cancel">Cancel</button>
            <button class="pa-modal__confirm" id="pa-form-confirm"
                    style="background:#1A1714; border-color:#1A1714;">Save Category</button>
        </div>
    </div>
</div>

<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Inventory</span>
            <h1 class="pa-page-title">Categories</h1>
        </div>
        <div class="pa-page-actions">
            <button class="pa-btn-primary" id="pa-open-add">+ Add Category</button>
        </div>
    </div>

    <div class="pa-section">

        {{-- Stats Ribbon --}}
        <div class="pa-stats-ribbon">
            <div class="pa-stat-tile">
                <span class="pa-stat-tile__label">Total Categories</span>
                <span class="pa-stat-tile__value" id="stat-total">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--accent">
                <span class="pa-stat-tile__label">Active</span>
                <span class="pa-stat-tile__value" id="stat-active">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--muted">
                <span class="pa-stat-tile__label">Archived</span>
                <span class="pa-stat-tile__value" id="stat-archived">—</span>
                <span class="pa-stat-tile__rule"></span>
            </div>
            <div class="pa-stat-tile pa-stat-tile--dark">
                <span class="pa-stat-tile__label">Classification</span>
                <span class="pa-stat-tile__value" style="font-size:0.88rem;font-family:'Jost',sans-serif;font-weight:300;color:rgba(200,190,178,0.45);letter-spacing:0.03em;line-height:1.4;">
                    Groups products for storefront browsing
                </span>
                <span class="pa-stat-tile__rule pa-stat-tile__rule--gold"></span>
            </div>
        </div>

        {{-- Table --}}
        <div class="pa-table-shell">
            <table id="categories-table" class="pa-products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
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

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
    #pa-form-modal::before { background: linear-gradient(to right, #B5975A, #D4B87A); }

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
        font-family: 'Jost', sans-serif; font-size: 0.72rem;
        letter-spacing: 0.06em; color: #8C8078; font-weight: 300;
    }
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate { padding: 1.1rem 1.6rem; }
    .dataTables_wrapper::after { content: ''; display: table; clear: both; }
    .dataTables_wrapper .dataTables_filter input {
        background: #F5F1EC; border: 1px solid #D0C8BE; color: #1A1714;
        font-family: 'Jost', sans-serif; font-size: 0.8rem; font-weight: 300;
        padding: 0.52rem 0.9rem; outline: none; border-radius: 0;
        margin-left: 0.6rem; min-width: 220px;
        transition: border-color 0.25s ease, background 0.25s ease;
    }
    .dataTables_wrapper .dataTables_filter input:focus        { border-color: #B5975A; background: #FDFBF8; }
    .dataTables_wrapper .dataTables_filter input::placeholder { color: #B0A898; opacity: 1; }
    .dataTables_wrapper .dataTables_length label { display: flex; align-items: center; }
    .dataTables_wrapper .dataTables_length select {
        background: #F5F1EC; border: 1px solid #D0C8BE; color: #1A1714;
        font-family: 'Jost', sans-serif; font-size: 0.8rem; font-weight: 300;
        padding: 0.45rem 1.6rem 0.45rem 0.6rem; outline: none; border-radius: 0;
        margin: 0 0.5rem; cursor: pointer; appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='5' viewBox='0 0 8 5'%3E%3Cpath d='M0 0l4 5 4-5z' fill='%23B0A898'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 7px;
    }
    .dataTables_wrapper .dataTables_length select:focus { border-color: #B5975A; }
    .dataTables_wrapper .dataTables_paginate {
        border-top: 1px solid #EEEBE4; display: flex; align-items: center; justify-content: flex-end;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-family: 'Jost', sans-serif !important; font-size: 0.68rem !important;
        color: #8C8078 !important; background: transparent !important;
        border: 1px solid transparent !important; border-radius: 0 !important;
        padding: 0.38rem 0.75rem !important; margin: 0 1px; cursor: pointer;
        transition: all 0.2s ease !important; font-weight: 300 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
        background: rgba(181,151,90,0.1) !important; border-color: rgba(181,151,90,0.3) !important; color: #B5975A !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #1A1714 !important; border-color: #1A1714 !important; color: #F8F5F0 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #D0C8BE !important; border-color: transparent !important; background: transparent !important; cursor: default;
    }
    .dataTables_wrapper .dataTables_info { font-size: 0.68rem; color: #A09890; font-weight: 300; }
    .dataTables_wrapper .dataTables_processing {
        font-family: 'Jost', sans-serif; font-size: 0.65rem; letter-spacing: 0.3em;
        text-transform: uppercase; color: #9A9088; background: rgba(253,251,248,0.95);
        border: 1px solid #E2DDD5; padding: 0.85rem 2rem; top: 50%;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after { display: none !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ── DataTables ──
    const table = $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.categories.data') }}',
            type: 'GET',
            dataType: 'json',
            xhrFields: { withCredentials: true },
            headers: { 'X-CSRF-TOKEN': CSRF },
            error: () => showToast({ icon: '✕', iconClass: 'pa-toast__icon--error', title: 'Failed to load categories', sub: 'Please refresh.' }),
        },
        columns: [
            {
                data: 'category_id',
                name: 'category_id',
                render: (data) => `<span class="u-id">#${String(data).padStart(4, '0')}</span>`,
            },
            { data: 'name_col',   name: 'category_name', orderable: true,  searchable: true  },
            { data: 'status_col', name: 'deleted_at',    orderable: false, searchable: false },
            { data: 'actions',    name: 'actions',       orderable: false, searchable: false },
        ],
        order: [[0, 'asc']],
        pageLength: 25,
        language: {
            search: '', searchPlaceholder: 'Search categories…',
            lengthMenu: 'Display _MENU_ categories',
            info: 'Showing _START_–_END_ of _TOTAL_',
            infoEmpty: 'No categories found', processing: 'Loading…',
            zeroRecords: 'No categories match your search',
            paginate: { first: '←', last: '→', next: '›', previous: '‹' },
        },
        drawCallback: (settings) => {
            const json = settings.json;
            if (json?.stats) {
                document.getElementById('stat-total').textContent    = json.stats.total    ?? '—';
                document.getElementById('stat-active').textContent   = json.stats.active   ?? '—';
                document.getElementById('stat-archived').textContent = json.stats.archived ?? '—';
            }
            attachListeners();
        },
    });

    // ── Add / Edit modal ──
    const formOverlay = document.getElementById('pa-form-overlay');
    const formTitle   = document.getElementById('pa-form-title');
    const formEyebrow = document.getElementById('pa-form-eyebrow');
    const formInput   = document.getElementById('pa-category-input');
    const formError   = document.getElementById('pa-category-error');
    const formConfirm = document.getElementById('pa-form-confirm');
    const formCancel  = document.getElementById('pa-form-cancel');
    let editingId = null;

    document.getElementById('pa-open-add').addEventListener('click', () => openForm());

    function openForm(id = null, name = '') {
        editingId               = id;
        formTitle.textContent   = id ? 'Edit Category'  : 'Add Category';
        formEyebrow.textContent = id ? 'Editing'        : 'New Category';
        formConfirm.textContent = id ? 'Save Changes'   : 'Save Category';
        formInput.value         = name;
        formError.style.display = 'none';
        formOverlay.classList.add('pa-overlay--visible');
        setTimeout(() => formInput.focus(), 320);
    }

    function closeForm() {
        formOverlay.classList.remove('pa-overlay--visible');
        editingId = null;
        formInput.value = '';
        formInput.style.borderColor = '#D0C8BE';
        formInput.style.background  = '#F5F1EC';
        formError.style.display = 'none';
    }

    formCancel.addEventListener('click', closeForm);
    formOverlay.addEventListener('click', (e) => { if (e.target === formOverlay) closeForm(); });
    formInput.addEventListener('keydown', (e) => { if (e.key === 'Enter') formConfirm.click(); });

    formConfirm.addEventListener('click', () => {
        const name = formInput.value.trim();
        if (!name) {
            formError.textContent   = 'Category name is required.';
            formError.style.display = 'block';
            formInput.style.borderColor = '#C97A7A';
            formInput.focus();
            return;
        }
        formError.style.display = 'none';
        formInput.style.borderColor = '#D0C8BE';
        formConfirm.disabled    = true;
        formConfirm.textContent = editingId ? 'Saving…' : 'Creating…';

        const req = editingId
            ? axios.patch(`/admin/categories/${editingId}`, { category_name: name }, { headers: { 'X-CSRF-TOKEN': CSRF } })
            : axios.post(`/admin/categories`,               { category_name: name }, { headers: { 'X-CSRF-TOKEN': CSRF } });

        req.then(() => {
                closeForm();
                table.ajax.reload(null, false);
                showToast({
                    icon: '◈', iconClass: 'pa-toast__icon--role',
                    title: editingId ? `<strong>${name}</strong> updated` : `<strong>${name}</strong> created`,
                    sub:   editingId ? 'Category name saved' : 'New category added',
                });
            })
            .catch((err) => {
                const msg = err.response?.data?.errors?.category_name?.[0]
                         || err.response?.data?.message || 'Something went wrong.';
                formError.textContent       = msg;
                formError.style.display     = 'block';
                formInput.style.borderColor = '#C97A7A';
            })
            .finally(() => {
                formConfirm.disabled    = false;
                formConfirm.textContent = editingId ? 'Save Changes' : 'Save Category';
            });
    });

    // ── Delete modal ──
    const deleteOverlay = document.getElementById('pa-delete-overlay');
    const deleteNameEl  = document.getElementById('pa-modal-category-name');
    const deleteConfirm = document.getElementById('pa-modal-confirm');
    const deleteCancel  = document.getElementById('pa-modal-cancel');
    let pendingDeleteId = null, pendingDeleteName = null;

    function attachListeners() {
        document.querySelectorAll('.pa-category-edit').forEach(btn => {
            btn.removeEventListener('click', onEditClick);
            btn.addEventListener('click', onEditClick);
        });
        document.querySelectorAll('.pa-category-delete').forEach(btn => {
            btn.removeEventListener('click', onDeleteClick);
            btn.addEventListener('click', onDeleteClick);
        });
    }

    function onEditClick()   { openForm(this.dataset.categoryId, this.dataset.categoryName); }
    function onDeleteClick() {
        pendingDeleteId          = this.dataset.categoryId;
        pendingDeleteName        = this.dataset.categoryName;
        deleteNameEl.textContent = pendingDeleteName;
        deleteOverlay.classList.add('pa-overlay--visible');
        setTimeout(() => deleteConfirm.focus(), 320);
    }

    function closeDelete() {
        deleteOverlay.classList.remove('pa-overlay--visible');
        pendingDeleteId = pendingDeleteName = null;
    }

    deleteCancel.addEventListener('click', closeDelete);
    deleteOverlay.addEventListener('click', (e) => { if (e.target === deleteOverlay) closeDelete(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeForm(); closeDelete(); } });

    deleteConfirm.addEventListener('click', () => {
        if (!pendingDeleteId) return;
        const id = pendingDeleteId, name = pendingDeleteName;
        deleteConfirm.disabled    = true;
        deleteConfirm.textContent = 'Deleting…';

        axios.delete(`/admin/categories/${id}`, { headers: { 'X-CSRF-TOKEN': CSRF } })
            .then(() => {
                closeDelete();
                table.ajax.reload(null, false);
                showToast({ icon: '◌', iconClass: 'pa-toast__icon--delete', title: `<strong>${name}</strong> deleted`, sub: 'Category removed permanently' });
            })
            .catch((err) => {
                closeDelete();
                showToast({ icon: '✕', iconClass: 'pa-toast__icon--error', title: 'Delete failed', sub: err.response?.data?.message || 'Please try again.' });
            })
            .finally(() => { deleteConfirm.disabled = false; deleteConfirm.textContent = 'Delete category'; });
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