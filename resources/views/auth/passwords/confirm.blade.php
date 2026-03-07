@extends('layouts.app')

@section('title', 'Confirm Password — Prestige Perfumery')

@section('content')

<div class="pp-auth-wrap">
    <div class="pp-auth-card">

        <div class="pp-auth-header">
            <span class="pp-auth-header-eyebrow">Security Check</span>
            <h1>Confirm Password</h1>
        </div>

        <div class="pp-auth-body">
            <p style="margin-bottom: 1.5rem; font-size: 0.88rem; line-height: 1.6; color: var(--stone);">
                {{ __('Please confirm your password before continuing.') }}
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

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
                        autocomplete="current-password"
                    >
                    @error('password')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pp-auth-divider"></div>

                <button type="submit" class="pp-auth-submit">
                    {{ __('Confirm Password') }}
                </button>

            </form>

            @if (Route::has('password.request'))
                <p class="pp-auth-footer">
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </p>
            @endif
        </div>

    </div>
</div>

@endsection
