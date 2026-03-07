@extends('layouts.admin')

@section('title', 'Users — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Users</span>
            <h1 class="pa-page-title">User Management</h1>
        </div>
    </div>

    <div class="pa-section">

        {{-- ── Stats Bar ── --}}
        <div id="stats-bar" style="display:flex; gap:1px; background:#D6D0C8; border:1px solid #D6D0C8; margin-bottom:2rem;">
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Total Users</span>
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
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:rgba(200,190,178,0.6); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Admins</span>
                <span id="stat-admins" style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#B5975A; line-height:1;">—</span>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div style="border:1px solid #D6D0C8; overflow-x:auto;">
            <table id="users-table" style="width:100%; border-collapse:collapse; background:#FDFBF8;">
                <thead>
                    <tr style="border-bottom:2px solid #D6D0C8; background:#F5F1EC;">
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">ID</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Username</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Email</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Role</th>
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
    #users-table tbody tr {
        border-bottom: 1px solid #EDE8DF;
        transition: background 0.15s;
    }
    #users-table tbody tr:hover  { background: #F5F1EC; }
    #users-table tbody tr:last-child { border-bottom: none; }

    /* Sorting arrows */
    #users-table thead th.sorting_asc::after  { content: ' ↑'; color: #B5975A; }
    #users-table thead th.sorting_desc::after { content: ' ↓'; color: #B5975A; }

    /* ── Server-rendered: pa-status badges ── */
    .pa-status {
        display: inline-block;
        font-family: 'Jost', sans-serif;
        font-size: 0.68rem;
        font-weight: 500;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        padding: 0.28rem 0.75rem;
        border-radius: 2px;
    }
    .pa-status--success { background: #F0F5EE; color: #4A6741; }
    .pa-status--danger  { background: #F8EEEE; color: #8B3A3A; }

    /* ── Server-rendered: pa-select (role dropdown) ── */
    .pa-select {
        background: #fff;
        border: 1.5px solid #B0A898;
        color: #1A1714;
        font-family: 'Jost', sans-serif;
        font-size: 0.82rem;
        padding: 0.35rem 0.6rem;
        outline: none;
        border-radius: 2px;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .pa-select:focus { border-color: #B5975A; }
    .pa-select--small { font-size: 0.78rem; padding: 0.28rem 0.5rem; }

    /* ── Server-rendered: pa-button (toggle active) ── */
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
    .pa-button:hover   { opacity: 0.8; }
    .pa-button--small  { font-size: 0.68rem; padding: 0.22rem 0.65rem; }
    .pa-button--success { background: #F0F5EE; color: #4A6741; }
    .pa-button--danger  { background: #F8EEEE; color: #8B3A3A; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {

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
                // ID — rendered client-side (raw field)
                {
                    data: 'user_id',
                    name: 'user_id',
                        render: (data) =>
                            `<span style="font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;">#${data}</span>`,
                },
                // Username — rendered client-side (raw field)
                {
                    data: 'username',
                    name: 'username',
                    render: (data) =>
                        `<span style="font-size:0.92rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400;">${data}</span>`,
                },
                // Email — rendered client-side (raw field)
                {
                    data: 'email',
                    name: 'email',
                    render: (data) =>
                        `<a href="mailto:${data}"
                            style="font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:300; text-decoration:none; border-bottom:1px solid transparent;"
                            onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
                            onmouseout="this.style.color='#5A524A'; this.style.borderBottomColor='transparent'"
                         >${data}</a>`,
                },
                // Role — HTML built server-side by usersData() → pass through raw
                // Controller returns <select class="pa-select pa-select--small user-role-select" data-user-id="...">
                {
                    data: 'role',
                    name: 'role',
                    orderable: false,
                    searchable: false,
                },
                // Status — HTML built server-side by usersData() → pass through raw
                // Controller returns <span class="pa-status pa-status--success|danger">Active|Inactive</span>
                {
                    data: 'status',
                    name: 'is_active',
                    orderable: false,
                    searchable: false,
                },
                // Actions — HTML built server-side by usersData() → pass through raw
                // Controller returns <button class="pa-button pa-button--small user-toggle-active pa-button--danger|success" data-user-id="..." data-active="1|0">
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
                searchPlaceholder: 'Search users…',
                lengthMenu: 'Show _MENU_ users',
                info: 'Showing _START_–_END_ of _TOTAL_ users',
                infoEmpty: 'No users found',
                processing: 'Loading…',
                zeroRecords: `<span style="font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:300; color:#C8BEB2; font-style:italic;">No users match your search</span>`,
            },
            drawCallback: (settings) => {
                attachListeners();
                updateStats(settings);
            },
            createdRow: (row) => {
                $(row).find('td').css({ padding: '1rem 1.2rem', verticalAlign: 'middle' });
            },
        });

        // ── Listeners re-bound after every DataTables draw ──
        function attachListeners() {

            // Toggle active / inactive
            // Button has data-active="1|0" and class user-toggle-active — matches controller output exactly
            $('.user-toggle-active').off('click').on('click', function () {
                const userId    = $(this).data('user-id');
                const isActive  = parseInt($(this).data('active')); // 1 or 0 from controller
                const newActive = isActive ? 0 : 1;
                updateUser(userId, { is_active: newActive });
            });

            // Role change
            // Select has class user-role-select and data-user-id — matches controller output exactly
            // Values are 'admin' / 'customer' — matches controller validation rule
            $('.user-role-select').off('change').on('change', function () {
                const userId = $(this).data('user-id');
                const role   = $(this).val(); // 'admin' or 'customer'
                updateUser(userId, { role });
            });
        }

        // ── PATCH via axios — matches updateUser() in AdminController ──
        function updateUser(userId, payload) {
            axios.patch(`/admin/users/${userId}`, payload)
                .then(() => table.ajax.reload(null, false)) // reload without resetting page position
                .catch((error) => {
                    // Controller returns { success: false, message: '...' } on 422
                    const msg = error.response?.data?.message || 'An error occurred. Please try again.';
                    alert(msg);
                });
        }

        // ── Stats bar: reads recordsTotal from server + page data for breakdowns ──
        function updateStats(settings) {
            const json = settings.json;
            if (!json) return;

            // recordsTotal = full unfiltered count (Yajra provides this)
            document.getElementById('stat-total').textContent = json.recordsTotal ?? '—';

            // Per-page breakdowns (counts within the current page only)
            const data = json.data || [];
            const active   = data.filter(u => parseInt(u.is_active) === 1).length;
            const inactive = data.filter(u => parseInt(u.is_active) === 0).length;
            const admins   = data.filter(u => u.role === 'admin').length;  // 'admin' not 'Admin' — raw value

            document.getElementById('stat-active').textContent   = active   || '0';
            document.getElementById('stat-inactive').textContent = inactive || '0';
            document.getElementById('stat-admins').textContent   = admins   || '0';
        }
    });
</script>
@endsection 