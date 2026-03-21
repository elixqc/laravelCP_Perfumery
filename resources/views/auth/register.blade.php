@extends('layouts.app')

@section('title', 'Register — Prestige Perfumery')

@section('content')

<style>
.pp-reg-wrap {
    min-height: calc(100vh - 72px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1.5rem;
    background: var(--ivory);
}

.pp-reg-card {
    width: 100%;
    max-width: 440px;
}

/* Header */
.pp-reg-head {
    text-align: center;
    margin-bottom: 2.5rem;
}

.pp-reg-eyebrow {
    display: block;
    font-size: 0.6rem;
    letter-spacing: 0.35em;
    text-transform: uppercase;
    color: var(--gold);
    font-family: 'Jost', sans-serif;
    font-weight: 400;
    margin-bottom: 0.6rem;
}

.pp-reg-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem;
    font-weight: 400;
    letter-spacing: 0.06em;
    color: var(--ink);
    font-style: italic;
    line-height: 1;
    margin-bottom: 1.2rem;
}

.pp-reg-divider {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
}

.pp-reg-divider-line {
    width: 48px;
    height: 1px;
    background: linear-gradient(to right, transparent, var(--stone));
}

.pp-reg-divider-line:last-child {
    background: linear-gradient(to left, transparent, var(--stone));
}

.pp-reg-divider-gem {
    width: 4px;
    height: 4px;
    background: var(--gold);
    transform: rotate(45deg);
    flex-shrink: 0;
}

/* Form */
.pp-reg-form {
    background: #FDFBF8;
    border: 1px solid var(--cream);
    padding: 2.2rem 2rem;
}

.pp-reg-field {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
    margin-bottom: 1.1rem;
}

.pp-reg-field:last-of-type {
    margin-bottom: 0;
}

.pp-reg-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.8rem;
    margin-bottom: 1.1rem;
}

.pp-reg-label {
    font-size: 0.68rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--charcoal);
    font-family: 'Jost', sans-serif;
    font-weight: 400;
}

.pp-reg-label .opt {
    color: var(--stone);
    font-weight: 300;
    text-transform: none;
    letter-spacing: 0;
    font-size: 0.65rem;
}

.pp-reg-input {
    background: var(--ivory);
    border: 1px solid var(--cream);
    color: var(--ink);
    font-family: 'Jost', sans-serif;
    font-weight: 300;
    font-size: 0.9rem;
    padding: 0.7rem 0.85rem;
    outline: none;
    transition: border-color 0.2s ease;
    width: 100%;
    border-radius: 0;
    -webkit-appearance: none;
}

.pp-reg-input::placeholder { color: var(--stone); opacity: 0.55; }
.pp-reg-input:focus { border-color: var(--gold); background: var(--white); }
.pp-reg-input.is-invalid { border-color: #C97A7A; }

.pp-reg-error {
    font-size: 0.66rem;
    color: #8B3A3A;
    font-family: 'Jost', sans-serif;
    font-weight: 300;
}

.pp-reg-section-rule {
    height: 1px;
    background: var(--cream);
    margin: 1.4rem 0;
}

.pp-reg-submit {
    width: 100%;
    background: var(--ink);
    color: var(--ivory);
    border: 1px solid var(--ink);
    font-family: 'Jost', sans-serif;
    font-size: 0.68rem;
    font-weight: 400;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    padding: 0.9rem;
    cursor: pointer;
    transition: background 0.25s ease, border-color 0.25s ease, color 0.25s ease;
    margin-top: 1.4rem;
    border-radius: 0;
}

.pp-reg-submit:hover {
    background: var(--gold);
    border-color: var(--gold);
    color: var(--ink);
}

/* Footer */
.pp-reg-foot {
    text-align: center;
    margin-top: 1.4rem;
    font-size: 0.76rem;
    color: var(--stone);
    font-family: 'Jost', sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
}

.pp-reg-foot a {
    color: var(--charcoal);
    text-decoration: none;
    border-bottom: 1px solid var(--cream);
    padding-bottom: 1px;
    transition: color 0.2s ease, border-color 0.2s ease;
}

.pp-reg-foot a:hover {
    color: var(--gold);
    border-bottom-color: var(--gold);
}

.pp-reg-verify {
    text-align: center;
    margin-top: 1rem;
    font-size: 0.68rem;
    color: var(--stone);
    font-family: 'Jost', sans-serif;
    font-weight: 300;
    line-height: 1.6;
    opacity: 0.8;
}

@media (max-width: 480px) {
    .pp-reg-row { grid-template-columns: 1fr; }
    .pp-reg-form { padding: 1.8rem 1.4rem; }
}
</style>

<div class="pp-reg-wrap">
    <div class="pp-reg-card">

        <div class="pp-reg-head">
            <span class="pp-reg-eyebrow">Join the Maison</span>
            <h1 class="pp-reg-title">Create Account</h1>
            <div class="pp-reg-divider">
                <div class="pp-reg-divider-line"></div>
                <div class="pp-reg-divider-gem"></div>
                <div class="pp-reg-divider-line"></div>
            </div>
        </div>

        <div class="pp-reg-form">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                {{-- Username --}}
                <div class="pp-reg-field">
                    <label for="username" class="pp-reg-label">Username</label>
                    <input id="username" type="text" name="username"
                        value="{{ old('username') }}" placeholder="Choose a username"
                        class="pp-reg-input @error('username') is-invalid @enderror"
                        required autocomplete="username" autofocus>
                    @error('username')<span class="pp-reg-error">{{ $message }}</span>@enderror
                </div>

                {{-- Email --}}
                <div class="pp-reg-field">
                    <label for="email" class="pp-reg-label">Email Address</label>
                    <input id="email" type="email" name="email"
                        value="{{ old('email') }}" placeholder="you@example.com"
                        class="pp-reg-input @error('email') is-invalid @enderror"
                        required autocomplete="email">
                    @error('email')<span class="pp-reg-error">{{ $message }}</span>@enderror
                </div>

                {{-- Full Name --}}
                <div class="pp-reg-field">
                    <label for="full_name" class="pp-reg-label">Full Name</label>
                    <input id="full_name" type="text" name="full_name"
                        value="{{ old('full_name') }}" placeholder="Your full name"
                        class="pp-reg-input @error('full_name') is-invalid @enderror"
                        required autocomplete="name">
                    @error('full_name')<span class="pp-reg-error">{{ $message }}</span>@enderror
                </div>

                {{-- Password row --}}
                <div class="pp-reg-row">
                    <div class="pp-reg-field" style="margin-bottom:0">
                        <label for="password" class="pp-reg-label">Password</label>
                        <input id="password" type="password" name="password"
                            placeholder="••••••••"
                            class="pp-reg-input @error('password') is-invalid @enderror"
                            required autocomplete="new-password">
                        @error('password')<span class="pp-reg-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="pp-reg-field" style="margin-bottom:0">
                        <label for="password-confirm" class="pp-reg-label">Confirm</label>
                        <input id="password-confirm" type="password" name="password_confirmation"
                            placeholder="••••••••"
                            class="pp-reg-input"
                            required autocomplete="new-password">
                    </div>
                </div>

                <div class="pp-reg-section-rule"></div>

                {{-- Optional fields --}}
                <div class="pp-reg-row">
                    <div class="pp-reg-field" style="margin-bottom:0">
                        <label for="contact_number" class="pp-reg-label">
                            Contact <span class="opt">(optional)</span>
                        </label>
                        <input id="contact_number" type="text" name="contact_number"
                            value="{{ old('contact_number') }}" placeholder="0917 xxx xxxx"
                            class="pp-reg-input @error('contact_number') is-invalid @enderror"
                            autocomplete="tel">
                        @error('contact_number')<span class="pp-reg-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="pp-reg-field" style="margin-bottom:0">
                        <label for="address" class="pp-reg-label">
                            Address <span class="opt">(optional)</span>
                        </label>
                        <input id="address" type="text" name="address"
                            value="{{ old('address') }}" placeholder="Street, city"
                            class="pp-reg-input @error('address') is-invalid @enderror">
                        @error('address')<span class="pp-reg-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <button type="submit" class="pp-reg-submit">Create Account</button>

            </form>
        </div>

        <p class="pp-reg-verify">
            A verification link will be sent to your email after registering.
        </p>

        <p class="pp-reg-foot">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </p>

    </div>
</div>

@endsection