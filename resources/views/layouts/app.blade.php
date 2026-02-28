<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Prestige Perfumery') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Jost:wght@200;300;400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div id="app">

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
                <span class="logo-name">{{ config('app.name', 'Prestige Perfumery') }}</span>
                <span class="logo-tag">Maison de Parfum</span>
            </a>

            <div class="nav-right">
                @guest
                    @if(Route::has('login'))
                        <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                    @endif
                    @if(Route::has('register'))
                        <span class="nav-divider"></span>
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    @endif
                @else
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="nav-divider"></span>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="nav-link">Leave</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                        @csrf
                    </form>
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
</body>
</html>