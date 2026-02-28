@extends('layouts.app')

@section('title', 'Register — Prestige Perfumery')

@section('content')

<div class="pp-auth-wrap">
    <div class="pp-auth-card">

        <div class="pp-auth-header">
            <span class="pp-auth-header-eyebrow">Join the Maison</span>
            <h1>Create Account</h1>
        </div>

        <div class="pp-auth-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="pp-auth-field">
                    <label for="name" class="pp-auth-label">Full Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Your name"
                        class="pp-auth-input @error('name') is-invalid @enderror"
                        required
                        autocomplete="name"
                        autofocus
                    >
                    @error('name')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

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
                        autocomplete="new-password"
                    >
                    @error('password')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="pp-auth-field">
                    <label for="password-confirm" class="pp-auth-label">Confirm Password</label>
                    <input
                        id="password-confirm"
                        type="password"
                        name="password_confirmation"
                        placeholder="••••••••"
                        class="pp-auth-input"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="pp-auth-divider"></div>

                <button type="submit" class="pp-auth-submit">
                    Create Account
                </button>

            </form>

            <p class="pp-auth-footer">
                Already have an account?
                <a href="{{ route('login') }}">Sign in</a>
            </p>
        </div>

    </div>
</div>

@endsection