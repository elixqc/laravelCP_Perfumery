<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%231A1714'/><text x='50' y='72' font-size='62' font-family='Georgia,serif' text-anchor='middle' fill='%23B5975A'>P</text></svg>">
    <title>{{ config('app.name', 'Prestige Perfumery') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Jost:wght@200;300;400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div id="app">

    {{-- ── SEARCH OVERLAY ── --}}
    <div class="pp-search-overlay" id="searchOverlay" aria-hidden="true">
        <div class="pp-search-overlay__inner">
            <div class="pp-hero-rule">
                <span></span>
                <em>Discover</em>
                <span></span>
            </div>
            <h2 class="pp-search-overlay__heading">Find Your Signature Scent</h2>
            <form method="GET" action="{{ route('home') }}" class="pp-search-bar">
                <input
                    type="text"
                    name="search"
                    placeholder="Search fragrances..."
                    value="{{ request('search') }}"
                    class="pp-search-bar__input"
                    id="searchInput"
                    autocomplete="off"
                >
                <select name="category" class="pp-search-bar__select">
                    <option value="">All Categories</option>
                    @foreach(App\Models\Category::all() as $category)
                        <option value="{{ $category->category_id }}"
                            {{ request('category') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="pp-search-bar__btn">Search</button>
            </form>
        </div>
        <button class="pp-search-overlay__close" id="searchClose" aria-label="Close search">&#10005;</button>
    </div>
    <div class="pp-search-backdrop" id="searchBackdrop"></div>

    {{-- ── HEADER ── --}}
    <header>
        <div class="header-inner">

            <nav class="nav-left">
                <a href="{{ route('products.index') }}" class="nav-link">Collection</a>
                @auth
                    <span class="nav-divider"></span>
                    <a href="{{ route('cart.index') }}" class="nav-link">Cart</a>
                    <span class="nav-divider"></span>
                    <a href="{{ route('orders.index') }}" class="nav-link">Orders</a>
                @endauth
            </nav>

            <a href="{{ url('/') }}" class="logo">
                <span class="logo-name">PRESTIGE PERFUMERY</span>
                <span class="logo-tag">Maison de Parfum</span>
            </a>

            <div class="nav-right">
                {{-- Search trigger --}}
                <button class="nav-search-btn" id="searchTrigger" aria-label="Open search">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="5.5" cy="5.5" r="4.5" stroke="currentColor" stroke-width="1.2"/>
                        <line x1="8.85355" y1="9" x2="13" y2="13.1464" stroke="currentColor" stroke-width="1.2" stroke-linecap="square"/>
                    </svg>
                </button>

                @guest
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <span class="nav-divider"></span>
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                @else
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Back to Dashboard</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="nav-link" style="display:inline-flex;align-items:center;gap:0.5rem;">
                            <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}" alt="Profile" style="width:28px;height:28px;border-radius:50%;object-fit:cover;vertical-align:middle;">
                            Edit Profile
                        </a>
                    @endif
                    <span class="nav-divider"></span>
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                @endguest
            </div>

        </div>
    </header>

    {{-- ── FLASH MESSAGES ── --}}
    @if(session('success') || session('error') || session('status'))
        <div class="flash-zone">
            @if(session('success'))
                <div class="flash flash-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash flash-error">{{ session('error') }}</div>
            @endif
            @if(session('status'))
                <div class="flash flash-status">{{ session('status') }}</div>
            @endif
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    {{-- ── FOOTER ── --}}
    <footer>
        <div class="footer-inner">
            <div class="footer-logo">{{ config('app.name', 'Prestige Perfumery') }}</div>
            <div class="footer-rule"></div>
            <div class="footer-copy">&copy; {{ date('Y') }} &ensp; All rights reserved</div>
        </div>
        <div class="footer-bottom">
            <p>Crafted with care &middot; Luxury defined</p>
        </div>
    </footer>

</div>

<script>
    const trigger   = document.getElementById('searchTrigger');
    const overlay   = document.getElementById('searchOverlay');
    const backdrop  = document.getElementById('searchBackdrop');
    const closeBtn  = document.getElementById('searchClose');
    const input     = document.getElementById('searchInput');

    function openSearch() {
        overlay.classList.add('is-open');
        backdrop.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        setTimeout(() => input.focus(), 300);
    }

    function closeSearch() {
        overlay.classList.remove('is-open');
        backdrop.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
    }

    trigger.addEventListener('click', openSearch);
    closeBtn.addEventListener('click', closeSearch);
    backdrop.addEventListener('click', closeSearch);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeSearch();
    });
</script>

</body>
</html>