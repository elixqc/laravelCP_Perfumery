@extends('layouts.app')

@section('title', 'Verify Email — Prestige Perfumery')

@section('content')

<div class="pp-auth-wrap">
    <div class="pp-auth-card">

        <div class="pp-auth-header">
            <span class="pp-auth-header-eyebrow">Confirmation Required</span>
            <h1>Verify Email</h1>
        </div>

        <div class="pp-auth-body">
            @if (session('resent'))
                <div class="pp-auth-status">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="pp-auth-status">
                    {{ session('warning') }}
                </div>
            @endif

            <p style="margin-bottom: 1.5rem; font-size: 0.88rem; line-height: 1.6; color: var(--stone);">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
            </p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="pp-auth-submit">
                    {{ __('Request New Verification Link') }}
                </button>
            </form>
        </div>

    </div>
</div>

@endsection
