@extends('layout.auth')

@section('title', 'Sign In')

@section('content')
    <div class="panel">
        <div style="margin-bottom: 18px;">
            <p class="helper" style="margin-bottom: 8px;">Welcome back</p>
            <h2 style="font-size: 30px; font-weight: 800; margin: 0 0 8px;">Sign in</h2>
            <p class="helper" style="margin: 0;">Use your account to open the task dashboard.</p>
        </div>

        <div class="auth-switch">
            <a href="{{ route('login') }}" class="auth-link active">Sign in</a>
            <a href="{{ route('showRegister') }}" class="auth-link">Sign up</a>
        </div>

        <form action="{{ route('login.post') }}" method="POST" style="display: grid; gap: 16px; margin-top: 22px;">
            @csrf

            <div>
                <label class="label" for="email">Email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required>
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="label" for="password">Password</label>
                <input class="input" id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                @error('password')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
                <label for="remember" style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; color: #475569; cursor: pointer;">
                    <input id="remember" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>

                <a href="{{ route('showRegister') }}" class="helper" style="text-decoration: none; font-weight: 600;">
                    Create new account
                </a>
            </div>

            <button class="btn btn-primary" type="submit" style="width: 100%;">Sign in</button>
        </form>
    </div>
@endsection
