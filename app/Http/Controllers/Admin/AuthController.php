<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendResetPassword;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'identifier' => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ]);

        $loginField = filter_var($credentials['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (! Auth::guard('admin')->attempt([
            $loginField => $credentials['identifier'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            return back()
                ->withErrors(['identifier' => 'The provided admin credentials do not match our records.'])
                ->onlyInput('identifier');
        }

        $request->session()->regenerate();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Admin signed in successfully.');
    }

    public function showForgotPassword(): View
    {
        return view('admin.auth.forgot-password');
    }

    public function forgotPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email|exists:admins,email',
        ]);

        $token = (string) random_int(100000, 999999);
        $createdAt = now();
        $expiresAt = $createdAt->copy()->addMinutes(config('auth.passwords.admins.expire'));

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => $createdAt],
        );

        Mail::to($request->email)->send(new SendResetPassword($token, $expiresAt));

        return redirect()
            ->route('admin.password.request')
            ->with('success', 'Check your email for the admin reset instructions.');
    }

    public function showResetPassword(string $token): View
    {
        return view('admin.auth.reset-password', compact('token'));
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|string|email|exists:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $result = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (! $result) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Invalid admin reset token.');
        }

        $expired = Carbon::parse($result->created_at)
            ->addMinutes(config('auth.passwords.admins.expire', 60))
            ->isPast();

        if ($expired) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return redirect()->route('admin.password.request')
                ->with('error', 'Admin reset token expired.');
        }

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        $admin = Admin::where('email', $request->email)->firstOrFail();
        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Admin password reset successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Admin signed out successfully.');
    }
}
