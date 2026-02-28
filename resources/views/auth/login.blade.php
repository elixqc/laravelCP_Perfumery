@extends('layouts.app')

@section('title', 'Sign In — Prestige Perfumery')

@section('content')

<div class="pp-auth-wrap">
    <div class="pp-auth-card">

        <div class="pp-auth-header">
            <span class="pp-auth-header-eyebrow">Welcome Back</span>
            <h1>Sign In</h1>
        </div>

        <div class="pp-auth-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="pp-auth-field">
                    <label for="email" class="pp-auth-label">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        class="pp-auth-input @error('email') is-invalid @enderror"
                        required
                        autocomplete="email"
                        autofocus
                    >
                    @error('email')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="pp-auth-field">
                    <label for="password" class="pp-auth-label">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        class="pp-auth-input @error('password') is-invalid @enderror"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Remember Me + Forgot Password --}}
                <div class="pp-auth-meta">
                    <label class="pp-auth-remember">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            class="pp-auth-checkbox"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span>Remember me</span>
                    </label>

                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="pp-auth-forgot">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <div class="pp-auth-divider"></div>

                <button type="submit" class="pp-auth-submit">
                    Sign In
                </button>

            </form>

            <p class="pp-auth-footer">
                Don't have an account?
                <a href="{{ route('register') }}">Create one</a>
            </p>
        </div>

    </div>
</div>

@endsection