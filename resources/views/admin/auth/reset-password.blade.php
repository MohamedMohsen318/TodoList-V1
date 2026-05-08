@extends('layout.auth')

@section('title', 'Admin Reset Password')

@section('content')
    <div class="panel">
        <form action="{{ route('admin.password.update') }}" method="POST" style="display: grid; gap: 16px;">
            @csrf

            <div>
                <label class="label" for="email">Admin email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required>
            </div>

            <div>
                <label class="label" for="token">OTP</label>
                <input class="input" id="token" type="text" name="token" value="{{ old('token', $token ?? request()->route('token')) }}" required>
            </div>

            <div>
                <label class="label" for="password">New password</label>
                <input class="input" id="password" type="password" name="password" required>
            </div>

            <div>
                <label class="label" for="password_confirmation">Confirm password</label>
                <input class="input" id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <button class="btn btn-primary" type="submit" style="width: 100%;">Update admin password</button>

            <div style="padding-top: 6px; border-top: 1px solid #e2e8f0; text-align: center;">
                <a href="{{ route('admin.password.request') }}" class="helper" style="text-decoration: none; font-weight: 600;">Back to forgot password</a>
            </div>
        </form>
    </div>
@endsection
