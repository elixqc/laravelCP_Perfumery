@extends('layouts.app')

@section('title', 'Create New Password — Prestige Perfumery')

@section('content')

<div class="pp-auth-wrap">
    <div class="pp-auth-card">

        <div class="pp-auth-header">
            <span class="pp-auth-header-eyebrow">Set New Credentials</span>
            <h1>New Password</h1>
        </div>

        <div class="pp-auth-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email --}}
                <div class="pp-auth-field">
                    <label for="email" class="pp-auth-label">{{ __('Email Address') }}</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ $email ?? old('email') }}"
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
                    <label for="password" class="pp-auth-label">{{ __('Password') }}</label>
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
                    <label for="password-confirm" class="pp-auth-label">{{ __('Confirm Password') }}</label>
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
                    {{ __('Reset Password') }}
                </button>

            </form>
        </div>

    </div>
</div>

@endsection
