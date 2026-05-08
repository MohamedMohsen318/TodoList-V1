@extends('layout.auth')

@section('title', 'Admin Forgot Password')

@section('content')
    <div class="panel">
        <form action="{{ route('admin.password.email') }}" method="POST" style="display: grid; gap: 16px;">
            @csrf

            <div>
                <label class="label" for="email">Admin email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <button class="btn btn-primary" type="submit" style="width: 100%;">Send reset code</button>

            <div style="padding-top: 6px; border-top: 1px solid #e2e8f0; text-align: center;">
                <a href="{{ route('admin.login') }}" class="helper" style="text-decoration: none; font-weight: 600;">Back to admin sign in</a>
            </div>
        </form>
    </div>
@endsection
