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
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                {{-- Username --}}
                <div class="pp-auth-field">
                    <label for="username" class="pp-auth-label">{{ __('Username') }}</label>
                    <input
                        id="username"
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Choose a username"
                        class="pp-auth-input @error('username') is-invalid @enderror"
                        required
                        autocomplete="username"
                        autofocus
                    >
                    @error('username')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Full Name --}}
                <div class="pp-auth-field">
                    <label for="full_name" class="pp-auth-label">{{ __('Full Name') }}</label>
                    <input
                        id="full_name"
                        type="text"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        placeholder="Your full name"
                        class="pp-auth-input @error('full_name') is-invalid @enderror"
                        required
                        autocomplete="name"
                    >
                    @error('full_name')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Contact Number --}}
                <div class="pp-auth-field">
                    <label for="contact_number" class="pp-auth-label">{{ __('Contact Number') }}</label>
                    <input
                        id="contact_number"
                        type="text"
                        name="contact_number"
                        value="{{ old('contact_number') }}"
                        placeholder="e.g. 0917xxxxxxx"
                        class="pp-auth-input @error('contact_number') is-invalid @enderror"
                        autocomplete="tel"
                    >
                    @error('contact_number')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="pp-auth-field">
                    <label for="address" class="pp-auth-label">{{ __('Address') }}</label>
                    <textarea
                        id="address"
                        name="address"
                        placeholder="Your address"
                        class="pp-auth-input @error('address') is-invalid @enderror"
                        rows="2"
                    >{{ old('address') }}</textarea>
                    @error('address')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

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

                {{-- Profile Picture --}}
                <div class="pp-auth-field">
                    <label for="profile_picture" class="pp-auth-label">{{ __('Profile Picture') }} <span style="color:var(--stone);font-size:0.85rem;">(Optional)</span></label>
                    <input
                        id="profile_picture"
                        type="file"
                        name="profile_picture"
                        accept="image/*"
                        class="pp-auth-input @error('profile_picture') is-invalid @enderror"
                    >
                    @error('profile_picture')
                        <span class="pp-auth-error" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="pp-auth-submit">
                    {{ __('Create Account') }}
                </button>

                <p class="pp-auth-note" style="margin-top: 1rem; font-size: 0.9rem; color: var(--stone);">
                    {{ __('After registering, you will receive an email with a verification link. You must verify your email before you can sign in.') }}
                </p>

            </form>

            <p class="pp-auth-footer">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}">{{ __('Sign in') }}</a>
            </p>
        </div>

    </div>
</div>

@endsection
