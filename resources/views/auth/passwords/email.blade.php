@extends('layouts.app')

@section('title', 'Reset Password — Prestige Perfumery')

@section('content')

<div class="pp-auth-wrap">
    <div class="pp-auth-card">

        <div class="pp-auth-header">
            <span class="pp-auth-header-eyebrow">Recover Access</span>
            <h1>Reset Password</h1>
        </div>

        <div class="pp-auth-body">
            @if (session('status'))
                <div class="pp-auth-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Email --}}
                <div class="pp-auth-field">
                    <label for="email" class="pp-auth-label">{{ __('Email Address') }}</label>
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

                <div class="pp-auth-divider"></div>

                <button type="submit" class="pp-auth-submit">
                    {{ __('Send Reset Link') }}
                </button>

            </form>

            <p class="pp-auth-footer">
                <a href="{{ route('login') }}">{{ __('Back to sign in') }}</a>
            </p>
        </div>

    </div>
</div>

@endsection
