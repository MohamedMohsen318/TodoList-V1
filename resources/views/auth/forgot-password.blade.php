@extends('layout.auth')

@section('title', 'Forgot Password')

@section('content')
    <div class="panel">
        <form action="{{ route('password.email') }}" method="POST" style="display: grid; gap: 16px;">
            @csrf

            <div>
                <label class="label" for="email">Email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required>
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit" style="width: 100%;">
                Continue
            </button>

            <div style="padding-top: 6px; border-top: 1px solid #e2e8f0; text-align: center;">
                <a href="{{ route('login') }}" class="helper" style="text-decoration: none; font-weight: 600;">
                    Back to sign in
                </a>
            </div>
        </form>
    </div>
@endsection
