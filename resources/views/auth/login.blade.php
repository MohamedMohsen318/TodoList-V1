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
            <a href="{{ route('register.show') }}" class="auth-link">Sign up</a>
        </div>

        <form action="{{ route('login.attempt') }}" method="POST" style="display: grid; gap: 16px; margin-top: 22px;">
            @csrf

            <div>
                <label class="label" for="identifier">Email or phone</label>
                <input class="input" id="identifier" type="text" name="identifier" value="{{ old('identifier') }}" placeholder="name@example.com or 01234567890" autocomplete="username" required>
                @error('identifier')
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

            <div style="display: grid; gap: 10px;">
                <label for="remember" style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; color: #475569; cursor: pointer;">
                    <input id="remember" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>

                <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                    <span class="helper" style="font-size: 13px;">Forgot your password?</span>
                    <a href="{{ route('password.request') }}" class="helper" style="text-decoration: none; font-weight: 600; color: #2563eb;">
                        Reset password
                    </a>
                </div>
            </div>

            <button class="btn btn-primary" type="submit" style="width: 100%;">Sign in</button>

            <div style="padding-top: 6px; border-top: 1px solid #e2e8f0; text-align: center;">
                <a href="{{ route('register.show') }}" class="helper" style="text-decoration: none; font-weight: 600;">
                    Create new account
                </a>
            </div>
        </form>
    </div>
@endsection
