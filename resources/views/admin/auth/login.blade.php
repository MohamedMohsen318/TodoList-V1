@extends('layout.auth')

@section('title', 'Admin Sign In')

@section('content')
    <div class="panel">
        <div style="margin-bottom: 18px;">
            <p class="helper" style="margin-bottom: 8px;">Administration access</p>
            <h2 style="font-size: 30px; font-weight: 800; margin: 0 0 8px;">Admin sign in</h2>
            <p class="helper" style="margin: 0;">Use your admin account to access the control dashboard.</p>
        </div>

        <form action="{{ route('admin.login.attempt') }}" method="POST" style="display: grid; gap: 16px; margin-top: 22px;">
            @csrf

            <div>
                <label class="label" for="identifier">Email or phone</label>
                <input class="input" id="identifier" type="text" name="identifier" value="{{ old('identifier') }}" required>
            </div>

            <div>
                <label class="label" for="password">Password</label>
                <input class="input" id="password" type="password" name="password" required>
            </div>

            <label for="remember" style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; color: #475569;">
                <input id="remember" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                Remember me
            </label>

            <button class="btn btn-primary" type="submit" style="width: 100%;">Sign in as admin</button>

            <div style="display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('admin.password.request') }}" class="helper" style="text-decoration: none; font-weight: 600;">Reset admin password</a>
                <a href="{{ route('login') }}" class="helper" style="text-decoration: none; font-weight: 600;">User sign in</a>
            </div>
        </form>
    </div>
@endsection
