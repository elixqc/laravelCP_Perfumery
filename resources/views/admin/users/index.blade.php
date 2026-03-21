@extends('layouts.admin')

@section('title', 'Users — Prestige Admin')

@section('content')
{{-- ── Toast container ── --}}
<div id="pa-toast-stack"></div>

<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">User Management</span>
            <h1 class="pa-page-title">Members &amp; Accounts</h1>
        </div>
        <div class="pa-page-header-meta">
            <span class="pa-header-date" id="current-date"></span>
        </div>
    </div>

    <div class="pa-section">

        {{-- ── Stats Ribbon ── --}}
        <div class="pa-stats-ribbon">
            <div class="pa-stat-tile">
                <span class="pa-stat-tile__label">Total Users</span>
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
                <span class="pa-stat-tile__label">Admins</span>
                <span class="pa-stat-tile__value" id="stat-admins">—</span>
                <span class="pa-stat-tile__rule pa-stat-tile__rule--gold"></span>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div class="pa-table-shell">
            <table id="users-table" class="pa-users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
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

{{-- ── DataTables CDN (page-specific; not in prestige.css) ── --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

{{-- ── DataTables chrome overrides (kept here; irrelevant to other pages) ── --}}
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

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #B5975A;
        background: #FDFBF8;
    }

    .dataTables_wrapper .dataTables_filter input::placeholder {
        color: #B0A898;
        opacity: 1;
    }

    /* ── Length select ── */
    .dataTables_wrapper .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 0;
    }

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

    .dataTables_wrapper .dataTables_length select:focus {
        border-color: #B5975A;
    }

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

    /* ── Info text ── */
    .dataTables_wrapper .dataTables_info {
        font-size: 0.68rem;
        letter-spacing: 0.06em;
        color: #A09890;
        font-weight: 300;
    }

    /* ── Toast notifications ── */
    #pa-toast-stack {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        pointer-events: none;
    }

    .pa-toast {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #1A1714;
        border: 1px solid rgba(181, 151, 90, 0.25);
        padding: 0.95rem 1.2rem;
        min-width: 280px;
        max-width: 380px;
        pointer-events: all;
        position: relative;
        overflow: hidden;
        transform: translateX(calc(100% + 2.5rem));
        opacity: 0;
        transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1),
                    opacity 0.35s ease;
    }

    .pa-toast.pa-toast--in  { transform: translateX(0); opacity: 1; }
    .pa-toast.pa-toast--out { transform: translateX(calc(100% + 2.5rem)); opacity: 0; }

    /* Gold progress bar that drains left to right */
    .pa-toast::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        background: #B5975A;
        width: 100%;
        transform-origin: left center;
        animation: pa-toast-drain 3.5s linear forwards;
    }

    @keyframes pa-toast-drain {
        from { transform: scaleX(1); }
        to   { transform: scaleX(0); }
    }

    .pa-toast__icon {
        flex-shrink: 0;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }

    .pa-toast__icon--role   { background: rgba(181,151,90,0.15); color: #B5975A; }
    .pa-toast__icon--active { background: rgba(74,103,65,0.2);   color: #7FA872; }
    .pa-toast__icon--error  { background: rgba(139,58,58,0.2);   color: #C97A7A; }

    .pa-toast__body {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .pa-toast__title {
        font-family: 'Jost', sans-serif;
        font-size: 0.8rem;
        font-weight: 400;
        color: #F8F5F0;
        letter-spacing: 0.02em;
        line-height: 1.3;
    }

    .pa-toast__sub {
        font-family: 'Jost', sans-serif;
        font-size: 0.62rem;
        font-weight: 300;
        color: rgba(200, 190, 178, 0.55);
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .pa-toast__close {
        flex-shrink: 0;
        background: none;
        border: none;
        color: rgba(200, 190, 178, 0.3);
        cursor: pointer;
        font-size: 0.9rem;
        line-height: 1;
        padding: 0;
        align-self: flex-start;
        transition: color 0.2s ease;
    }

    .pa-toast__close:hover { color: #B5975A; }

    /* ── Processing indicator ── */
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

        // ── DataTables init ──
        const table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/admin/users/data',
                type: 'GET',
                dataType: 'json',
                crossDomain: false,
                xhrFields: { withCredentials: true },
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                error: (xhr, error, thrown) => {
                    console.error('DataTables AJAX error', xhr, error, thrown);
                    alert('Unable to load users. Please refresh the page.');
                },
            },
            columns: [
                {
                    data: 'user_id',
                    name: 'user_id',
                    render: (data) =>
                        `<span class="u-id">#${String(data).padStart(4, '0')}</span>`,
                },
                {
                    data: 'username',
                    name: 'username',
                    render: (data) =>
                        `<span class="u-name">${data}</span>`,
                },
                {
                    data: 'email',
                    name: 'email',
                    render: (data) =>
                        `<a href="mailto:${data}" class="u-email">${data}</a>`,
                },
                // Role — HTML built server-side by usersData() → pass through raw
                {
                    data: 'role',
                    name: 'role',
                    orderable: false,
                    searchable: false,
                },
                // Status — HTML built server-side by usersData() → pass through raw
                {
                    data: 'status',
                    name: 'is_active',
                    orderable: false,
                    searchable: false,
                },
                // Actions — HTML built server-side by usersData() → pass through raw
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
                searchPlaceholder: 'Search members…',
                lengthMenu: 'Display _MENU_ members',
                info: 'Showing _START_–_END_ of _TOTAL_',
                infoEmpty: 'No members found',
                processing: 'Loading…',
                zeroRecords: 'No members match your search',
                paginate: {
                    first:    '←',
                    last:     '→',
                    next:     '›',
                    previous: '‹',
                },
            },
            drawCallback: (settings) => {
                attachListeners();
                updateStats(settings);
            },
            createdRow: () => { /* td padding handled by prestige.css */ },
        });

        // ── Listeners re-bound after every DataTables draw ──
        function attachListeners() {

            // Toggle active / inactive
            $('.user-toggle-active').off('click').on('click', function () {
                const userId   = $(this).data('user-id');
                const isActive = parseInt($(this).data('active'));
                const username = $(this).closest('tr').find('.u-name').text().trim();
                const next     = isActive ? 0 : 1;

                updateUser(userId, { is_active: next }, () => {
                    showToast({
                        icon: next ? '◉' : '◎',
                        iconClass: next ? 'pa-toast__icon--active' : 'pa-toast__icon--error',
                        title: `<strong>${username}</strong> ${next ? 'activated' : 'deactivated'}`,
                        sub: next ? 'Account is now active' : 'Account is now inactive',
                    });
                });
            });

            // Role change
            $('.user-role-select').off('change').on('change', function () {
                const userId   = $(this).data('user-id');
                const role     = $(this).val();
                const username = $(this).closest('tr').find('.u-name').text().trim();
                const label    = role === 'admin' ? 'Administrator' : 'Customer';

                updateUser(userId, { role }, () => {
                    showToast({
                        icon: '◈',
                        iconClass: 'pa-toast__icon--role',
                        title: `<strong>${username}</strong> role changed`,
                        sub: `Now ${label}`,
                    });
                });
            });
        }

        // ── PATCH via axios ──
        function updateUser(userId, payload, onSuccess) {
            axios.patch(`/admin/users/${userId}`, payload)
                .then(() => {
                    table.ajax.reload(null, false);
                    if (typeof onSuccess === 'function') onSuccess();
                })
                .catch((error) => {
                    const msg = error.response?.data?.message || 'An error occurred. Please try again.';
                    showToast({
                        icon: '✕',
                        iconClass: 'pa-toast__icon--error',
                        title: 'Update failed',
                        sub: msg,
                    });
                });
        }

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

            // Slide in
            requestAnimationFrame(() => {
                requestAnimationFrame(() => toast.classList.add('pa-toast--in'));
            });

            // Dismiss on close button
            toast.querySelector('.pa-toast__close').addEventListener('click', () => dismiss(toast));

            // Auto-dismiss after 3.5 s (matches the drain animation)
            const timer = setTimeout(() => dismiss(toast), 3500);
            toast.dataset.timer = timer;

            function dismiss(el) {
                clearTimeout(parseInt(el.dataset.timer));
                el.classList.replace('pa-toast--in', 'pa-toast--out');
                el.addEventListener('transitionend', () => el.remove(), { once: true });
            }
        }

        // ── Stats bar ──
        function updateStats(settings) {
            const json = settings.json;
            if (!json) return;

            document.getElementById('stat-total').textContent = json.recordsTotal ?? '—';

            const data     = json.data || [];
            const active   = data.filter(u => parseInt(u.is_active_raw) === 1).length;
            const inactive = data.filter(u => parseInt(u.is_active_raw) === 0).length;
            const admins   = data.filter(u => u.role_raw === 'admin').length;

            document.getElementById('stat-active').textContent   = active   || '0';
            document.getElementById('stat-inactive').textContent = inactive || '0';
            document.getElementById('stat-admins').textContent   = admins   || '0';
        }
    });
</script>
@endsection