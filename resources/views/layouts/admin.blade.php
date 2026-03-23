    <!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Prestige Perfumery — Admin</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Jost:wght@200;300;400&display=swap" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="pa-body">
    <div id="app" class="pa-app">

        {{-- ── ADMIN HEADER ── --}}
        <header class="pa-header">
            <div class="pa-header-inner">

                {{-- LOGO --}}
                <a href="{{ route('admin.dashboard') }}" class="pa-logo">
                    <span class="pa-logo-name">Prestige Perfumery</span>
                    <span class="pa-logo-tag">Admin</span>
                </a>

                {{-- MAIN NAV --}}
                <nav class="pa-nav">
                    <a href="{{ route('admin.dashboard') }}"
                    class="pa-nav-link {{ request()->routeIs('admin.dashboard') ? 'pa-nav-link--active' : '' }}">
                        Dashboard
                    </a>
                    <span class="pa-nav-divider"></span>
                    <a href="{{ route('admin.products.index') }}"
                    class="pa-nav-link {{ request()->routeIs('admin.products.*') ? 'pa-nav-link--active' : '' }}">
                        Products
                    </a>
                    <span class="pa-nav-divider"></span>
                    <a href="{{ route('admin.suppliers.index') }}"
                    class="pa-nav-link {{ request()->routeIs('admin.suppliers.*') ? 'pa-nav-link--active' : '' }}">
                        Suppliers
                    </a>
                    <span class="pa-nav-divider"></span>
                    <a href="{{ route('admin.categories.index') }}"
                    class="pa-nav-link {{ request()->routeIs('admin.categories.*') ? 'pa-nav-link--active' : '' }}">
                        Categories
                    </a>
                    <span class="pa-nav-divider"></span>
                    <a href="{{ route('admin.users.index') }}"
                    class="pa-nav-link {{ request()->routeIs('admin.users.*') ? 'pa-nav-link--active' : '' }}">
                        Users
                    </a>
                    <span class="pa-nav-divider"></span>
                    <a href="{{ route('admin.orders.index') }}"
                    class="pa-nav-link {{ request()->routeIs('admin.orders.*') ? 'pa-nav-link--active' : '' }}">
                        Orders
                    </a>
                    <span class="pa-nav-divider"></span>
                    <a href="{{ route('admin.charts.bestSelling') }}"
                    class="pa-nav-link {{ request()->routeIs('admin.charts.*') ? 'pa-nav-link--active' : '' }}">
                        Reports
                    </a>
                </nav>

                {{-- RIGHT: USER + LOGOUT --}}
                <div class="pa-header-right">
                    <span class="pa-admin-badge">Admin</span>
                    <span class="pa-user-name">{{ Auth::user()->name }}</span>
                    <span class="pa-nav-divider"></span>
                    <a href="{{ route('home') }}" class="pa-nav-link">← Storefront</a>
                    <span class="pa-nav-divider"></span>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('pa-logout-form').submit();"
                    class="pa-nav-link">Logout</a>
                    <form id="pa-logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                        @csrf
                    </form>
                </div>

            </div>
        </header>

        {{-- ── FLASH MESSAGES ── --}}
        @if(session('success') || session('error') || session('status'))
            <div class="pa-flash-zone">
                @if(session('success'))
                    <div class="pa-flash pa-flash--success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="pa-flash pa-flash--error">{{ session('error') }}</div>
                @endif
                @if(session('status'))
                    <div class="pa-flash pa-flash--status">{{ session('status') }}</div>
                @endif
            </div>
        @endif

        {{-- ── PAGE CONTENT ── --}}
        <main class="pa-main">
            @yield('content')
        </main>

        {{-- ── FOOTER ── --}}
        <footer class="pa-footer">
            <div class="pa-footer-inner">
                <span>&copy; {{ date('Y') }} {{ config('app.name') }} — Admin</span>
                <span class="pa-footer-divider">·</span>
                <span>All actions are logged</span>
            </div>
        </footer>

        @yield('scripts')
    </div>
    </body>
    </html>