@extends('layout.auth')

@section('title', 'Sign Up')

@section('content')
    <div class="panel">
        <div style="margin-bottom: 18px;">
            <p class="helper" style="margin-bottom: 8px;">Create your account</p>
            <h2 style="font-size: 30px; font-weight: 800; margin: 0 0 8px;">Sign up</h2>
            <p class="helper" style="margin: 0;">Create a simple account, then start managing tasks.</p>
        </div>

        <div class="auth-switch">
            <a href="{{ route('login') }}" class="auth-link">Sign in</a>
            <a href="{{ route('showRegister') }}" class="auth-link active">Sign up</a>
        </div>

        <form action="{{ route('register') }}" method="POST" style="display: grid; gap: 16px; margin-top: 22px;">
            @csrf

            <div>
                <label class="label" for="name">Name</label>
                <input class="input" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Your name" autocomplete="name" required>
                @error('name')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="label" for="email">Email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required>
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="label" for="password">Password</label>
                <input class="input" id="password" type="password" name="password" placeholder="At least 6 characters" autocomplete="new-password" required>
                @error('password')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="label" for="password_confirmation">Confirm password</label>
                <input class="input" id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat the password" autocomplete="new-password" required>
            </div>

            <button class="btn btn-primary" type="submit" style="width: 100%;">Create account</button>
        </form>
    </div>
@endsection
