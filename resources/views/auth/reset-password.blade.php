@extends('layout.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="panel">
        @if(isset($resetPassword))
            <div style="display: grid; gap: 16px;">
                <div>
                    <label class="label">Reset password</label>
                    <p class="helper" style="margin: 0; line-height: 1.7;">
                        Click the button below to continue resetting your password, or use the OTP code on the reset page.
                    </p>
                </div>

                <a href="{{ $resetPassword }}" class="btn btn-primary" style="width: 100%; text-decoration: none;">
                    Reset password
                </a>

                <div style="padding: 14px 16px; border: 1px solid #dbe3f0; border-radius: 12px; background: #f8fbff;">
                    <p class="helper" style="margin: 0 0 6px;">OTP code</p>
                    <p style="margin: 0; font-size: 18px; font-weight: 700; color: #1d4ed8; letter-spacing: 1px;">
                        {{ $token }}
                    </p>
                </div>
            </div>
        @else
            <form action="{{ route('password.update') }}" method="POST" style="display: grid; gap: 16px;">
                @csrf

                <div>
                    <label class="label" for="email">Email</label>
                    <input class="input" id="email" type="email" name="email" value="{{ old('email', request('email')) }}" placeholder="name@example.com" autocomplete="email" required>
                    @error('email')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label" for="token_display">OTP</label>
                    <input class="input" id="token_display" type="text" name="token" value="{{ old('token', $token ?? request()->route('token')) }}" placeholder="Enter the 6-digit code" required>
                    @error('token')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label" for="password">New password</label>
                    <input class="input" id="password" type="password" name="password" placeholder="Enter a new password" autocomplete="new-password" required>
                    @error('password')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label" for="password_confirmation">Confirm password</label>
                    <input class="input" id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat your new password" autocomplete="new-password" required>
                </div>

                <button class="btn btn-primary" type="submit" style="width: 100%;">
                    Update password
                </button>

                <div style="padding-top: 6px; border-top: 1px solid #e2e8f0; text-align: center;">
                    <a href="{{ route('password.request') }}" class="helper" style="text-decoration: none; font-weight: 600;">
                        Back to forgot password
                    </a>
                </div>
            </form>
        @endif
    </div>
@endsection
