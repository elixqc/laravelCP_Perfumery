@extends('layouts.app')

@section('title', 'My Account — Prestige Perfumery')

@section('content')

{{-- ── Hero ── --}}
<div class="pp-hero" style="padding:3rem 0 2.5rem; text-align:center; border-bottom:1px solid var(--cream);">
    <div class="pp-section-inner">
        <div style="display:flex; align-items:center; justify-content:center; gap:0.6rem; margin-bottom:1rem;">
            <a href="{{ route('home') }}" style="font-size:0.72rem; letter-spacing:0.15em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; text-decoration:none; transition:color 0.2s;"
               onmouseover="this.style.color='var(--gold)'"
               onmouseout="this.style.color='var(--stone)'">Home</a>
            <span style="color:var(--stone); font-size:0.6rem;">›</span>
            <span style="font-size:0.72rem; letter-spacing:0.15em; text-transform:uppercase; color:var(--charcoal); font-family:'Jost',sans-serif; font-weight:300;">My Account</span>
        </div>
        <div class="pp-hero-rule"></div>
        <h1 style="font-family:'Cormorant Garamond',serif; font-size:2.6rem; font-weight:300; color:var(--charcoal); font-style:italic; margin:0.75rem 0 0;">
            My Account
        </h1>
    </div>
</div>

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div style="max-width:700px; margin:2rem auto 0; padding:0 1.5rem;">
        <div style="background:#F0F5EE; border-left:3px solid #4A6741; padding:1rem 1.25rem; display:flex; align-items:center; gap:0.75rem;">
            <span style="color:#4A6741; font-size:1rem;">✓</span>
            <span style="font-family:'Jost',sans-serif; font-size:0.88rem; color:#4A6741; font-weight:400;">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if($errors->any())
    <div style="max-width:700px; margin:2rem auto 0; padding:0 1.5rem;">
        <div style="background:#F8EEEE; border-left:3px solid #8B3A3A; padding:1rem 1.25rem;">
            <span style="font-family:'Jost',sans-serif; font-size:0.88rem; color:#8B3A3A; font-weight:400; display:block; margin-bottom:0.4rem;">Please correct the following:</span>
            @foreach($errors->all() as $error)
                <span style="font-family:'Jost',sans-serif; font-size:0.82rem; color:#8B3A3A; font-weight:300; display:block; padding-left:0.5rem;">— {{ $error }}</span>
            @endforeach
        </div>
    </div>
@endif

{{-- ── Main Content ── --}}
<div style="max-width:700px; margin:3rem auto 5rem; padding:0 1.5rem; display:flex; flex-direction:column; gap:2.5rem;">

    {{-- ═══ Profile Section ═══ --}}
    <div>
        <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.75rem;">
            Profile Information
        </p>

        <form method="POST" action="{{ route('user.account.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Avatar + name row --}}
            <div style="display:flex; align-items:center; gap:1.5rem; margin-bottom:2rem; padding:1.5rem; background:#FDFBF8; border:1px solid #D6D0C8;">
                <div id="avatar-wrap" style="width:72px; height:72px; border-radius:50%; overflow:hidden; background:#EDE8DF; border:2px solid #D6D0C8; flex-shrink:0; position:relative; cursor:pointer;" onclick="document.getElementById('profile_picture').click()">
                    @if(auth()->user()->profile_picture)
                        <img id="avatar-preview" src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture"
                             style="width:100%; height:100%; object-fit:cover; display:block;">
                    @else
                        <div id="avatar-initials" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                            <span style="font-family:'Cormorant Garamond',serif; font-size:1.6rem; font-weight:300; color:#B0A898; font-style:italic;">
                                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                    <div style="position:absolute; inset:0; background:rgba(26,23,20,0.45); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity 0.2s; border-radius:50%;"
                         onmouseover="this.style.opacity='1'"
                         onmouseout="this.style.opacity='0'">
                        <span style="font-size:0.6rem; letter-spacing:0.1em; text-transform:uppercase; color:#F8F5F0; font-family:'Jost',sans-serif;">Edit</span>
                    </div>
                </div>
                <div>
                    <span style="font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:300; color:var(--charcoal); font-style:italic; display:block;">
                        {{ auth()->user()->full_name ?? auth()->user()->username }}
                    </span>
                    <span style="font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; letter-spacing:0.05em;">
                        Click the avatar to change your photo
                    </span>
                </div>
            </div>

            {{-- Hidden file input --}}
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                   style="display:none;" onchange="previewAvatar(this)">

            {{-- Username + Full Name grid --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-bottom:1.5rem;">

                <div style="display:flex; flex-direction:column; gap:0.5rem;">
                    <label for="username" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                        Username <span style="color:#C97A7A;">*</span>
                    </label>
                    <input type="text" id="username" name="username"
                           value="{{ old('username', auth()->user()->username) }}" required
                           style="background:#fff; border:1.5px solid {{ $errors->has('username') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                           onfocus="this.style.borderColor='#B5975A'"
                           onblur="this.style.borderColor='{{ $errors->has('username') ? '#C97A7A' : '#B0A898' }}'">
                    @error('username')
                        <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display:flex; flex-direction:column; gap:0.5rem;">
                    <label for="full_name" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                        Full Name <span style="color:#C97A7A;">*</span>
                    </label>
                    <input type="text" id="full_name" name="full_name"
                           value="{{ old('full_name', auth()->user()->full_name) }}" required
                           style="background:#fff; border:1.5px solid {{ $errors->has('full_name') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                           onfocus="this.style.borderColor='#B5975A'"
                           onblur="this.style.borderColor='{{ $errors->has('full_name') ? '#C97A7A' : '#B0A898' }}'">
                    @error('full_name')
                        <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Contact Number --}}
            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1.5rem;">
                <label for="contact_number" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                    Contact Number
                </label>
                <input type="text" id="contact_number" name="contact_number"
                       value="{{ old('contact_number', auth()->user()->contact_number) }}"
                       style="background:#fff; border:1.5px solid {{ $errors->has('contact_number') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                       autocomplete="tel"
                       onfocus="this.style.borderColor='#B5975A'"
                       onblur="this.style.borderColor='{{ $errors->has('contact_number') ? '#C97A7A' : '#B0A898' }}'">
                @error('contact_number')
                    <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Address --}}
            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:2rem;">
                <label for="address" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                    Address
                </label>
                <textarea id="address" name="address" rows="2"
                          style="background:#fff; border:1.5px solid {{ $errors->has('address') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; border-radius:2px; resize:vertical;"
                          placeholder="Your address"
                          onfocus="this.style.borderColor='#B5975A'"
                          onblur="this.style.borderColor='{{ $errors->has('address') ? '#C97A7A' : '#B0A898' }}'">{{ old('address', auth()->user()->address) }}</textarea>
                @error('address')
                    <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email (disabled) --}}
            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:2rem;">
                <label for="email" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                    Email Address
                </label>
                <div style="position:relative;">
                    <input type="email" id="email" name="email"
                           value="{{ old('email', auth()->user()->email) }}" disabled
                           style="background:#F5F1EC; border:1.5px solid #D6D0C8; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; font-size:0.95rem; padding:0.75rem 1rem; outline:none; width:100%; border-radius:2px; cursor:not-allowed;">
                    <span style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); font-size:0.65rem; letter-spacing:0.12em; text-transform:uppercase; color:#B0A898; font-family:'Jost',sans-serif;">
                        Read only
                    </span>
                </div>
                <span style="font-size:0.75rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;">
                    Contact support to change your email address.
                </span>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    style="background:#2C2825; color:#F8F5F0; border:none; font-family:'Jost',sans-serif; font-size:0.85rem; font-weight:500; letter-spacing:0.1em; text-transform:uppercase; padding:0.85rem 2.5rem; cursor:pointer; transition:background 0.25s, color 0.25s; border-radius:2px;"
                    onmouseover="this.style.background='#B5975A'; this.style.color='#1A1714'"
                    onmouseout="this.style.background='#2C2825'; this.style.color='#F8F5F0'">
                Save Changes
            </button>

        </form>
    </div>

    {{-- ═══ Password Section ═══ --}}
    <div>
        <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.75rem;">
            Change Password
        </p>

        <form method="POST" action="{{ route('user.account.password') }}">
            @csrf
            @method('PUT')

            <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem; display:flex; flex-direction:column; gap:1.5rem; margin-bottom:1.75rem;">

                {{-- Current password --}}
                <div style="display:flex; flex-direction:column; gap:0.5rem;">
                    <label for="current_password" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                        Current Password <span style="color:#C97A7A;">*</span>
                    </label>
                    <div style="position:relative;">
                        <input type="password" id="current_password" name="current_password" required
                               style="background:#fff; border:1.5px solid {{ $errors->has('current_password') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 3rem 0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='{{ $errors->has('current_password') ? '#C97A7A' : '#B0A898' }}'">
                        <button type="button" onclick="togglePassword('current_password', this)"
                                style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; letter-spacing:0.08em; text-transform:uppercase; padding:0;">
                            Show
                        </button>
                    </div>
                    @error('current_password')
                        <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="height:1px; background:#EDE8DF;"></div>

                {{-- New password --}}
                <div style="display:flex; flex-direction:column; gap:0.5rem;">
                    <label for="password" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                        New Password <span style="color:#C97A7A;">*</span>
                    </label>
                    <div style="position:relative;">
                        <input type="password" id="password" name="password" required
                               style="background:#fff; border:1.5px solid {{ $errors->has('password') ? '#C97A7A' : '#B0A898' }}; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 3rem 0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='{{ $errors->has('password') ? '#C97A7A' : '#B0A898' }}'">
                        <button type="button" onclick="togglePassword('password', this)"
                                style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; letter-spacing:0.08em; text-transform:uppercase; padding:0;">
                            Show
                        </button>
                    </div>
                    @error('password')
                        <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm password --}}
                <div style="display:flex; flex-direction:column; gap:0.5rem;">
                    <label for="password_confirmation" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                        Confirm New Password <span style="color:#C97A7A;">*</span>
                    </label>
                    <div style="position:relative;">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               style="background:#fff; border:1.5px solid #B0A898; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 3rem 0.75rem 1rem; outline:none; width:100%; transition:border-color 0.2s; border-radius:2px;"
                               onfocus="this.style.borderColor='#B5975A'"
                               onblur="this.style.borderColor='#B0A898'"
                               oninput="checkMatch()">
                        <button type="button" onclick="togglePassword('password_confirmation', this)"
                                style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; letter-spacing:0.08em; text-transform:uppercase; padding:0;">
                            Show
                        </button>
                    </div>
                    <span id="match-hint" style="font-size:0.75rem; font-family:'Jost',sans-serif; font-weight:300; display:none;"></span>
                </div>

            </div>

            <button type="submit"
                    style="background:#2C2825; color:#F8F5F0; border:none; font-family:'Jost',sans-serif; font-size:0.85rem; font-weight:500; letter-spacing:0.1em; text-transform:uppercase; padding:0.85rem 2.5rem; cursor:pointer; transition:background 0.25s, color 0.25s; border-radius:2px;"
                    onmouseover="this.style.background='#B5975A'; this.style.color='#1A1714'"
                    onmouseout="this.style.background='#2C2825'; this.style.color='#F8F5F0'">
                Update Password
            </button>

        </form>
    </div>

</div>

<script>
    // ── Avatar preview on file select ──
    function previewAvatar(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            const wrap = document.getElementById('avatar-wrap');
            // Replace contents with preview img
            wrap.innerHTML = `
                <img id="avatar-preview" src="${e.target.result}" alt="Preview"
                     style="width:100%; height:100%; object-fit:cover; display:block; border-radius:50%;">
                <div style="position:absolute; inset:0; background:rgba(26,23,20,0.45); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity 0.2s; border-radius:50%;"
                     onmouseover="this.style.opacity='1'"
                     onmouseout="this.style.opacity='0'">
                    <span style="font-size:0.6rem; letter-spacing:0.1em; text-transform:uppercase; color:#F8F5F0; font-family:'Jost',sans-serif;">Edit</span>
                </div>
            `;
        };
        reader.readAsDataURL(input.files[0]);
    }

    // ── Password show/hide toggle ──
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Hide';
        } else {
            input.type = 'password';
            btn.textContent = 'Show';
        }
    }

    // ── Live password match indicator ──
    function checkMatch() {
        const pw    = document.getElementById('password').value;
        const conf  = document.getElementById('password_confirmation').value;
        const hint  = document.getElementById('match-hint');
        const confInput = document.getElementById('password_confirmation');

        if (!conf) {
            hint.style.display = 'none';
            return;
        }

        if (pw === conf) {
            hint.textContent = '✓ Passwords match';
            hint.style.color = '#4A6741';
            hint.style.display = 'block';
            confInput.style.borderColor = '#4A6741';
        } else {
            hint.textContent = '✗ Passwords do not match';
            hint.style.color = '#8B3A3A';
            hint.style.display = 'block';
            confInput.style.borderColor = '#C97A7A';
        }
    }
</script>

@endsection