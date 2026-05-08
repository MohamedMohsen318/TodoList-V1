<?php

namespace App\Http\Controllers;

use App\Mail\SendResetPassword;
use App\Models\User;
use App\Services\SlackNotifier;
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
    public function __construct(private readonly SlackNotifier $slackNotifier)
    {
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $userLogin = $request->validate([
            'identifier' => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ]);

        $loginField = filter_var($userLogin['identifier'],
            FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [$loginField => $userLogin['identifier'],
            'password' => $userLogin['password'],];

        if (! Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'identifier' => 'The provided credentials do not match our records.',
                ])
                ->onlyInput('identifier');
        }

        $request->session()->regenerate();

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Signed in successfully.');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $newUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone', 'regex:/^(\+20|0)?1[0125][0-9]{8}$/'],
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create($newUser);

        $user->assignRole('user');
        $this->slackNotifier->sendUserRegistered($user);

        return redirect()
            ->route('login')
            ->with('success', 'Account created successfully. You can sign in now.');
    }
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|string|email|exists:users,email',]);
        $token = (string) random_int(100000, 999999);
        $createdAt = now();
        $expiresAt = $createdAt->copy()->addMinutes(config('auth.passwords.users.expire'));

        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $request->email],
            ['token' => $token, 'created_at' => $createdAt,]);

        Mail::to($request->email)
            ->send(new SendResetPassword($token, $expiresAt));

        return redirect()->route('password.request')
            ->with('success', 'Check your email for instructions.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $result = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (! $result) {
            return redirect()->route('password.request')
                ->with('error', 'Invalid token.');
        }

        $expired = Carbon::parse($result->created_at)
            ->addMinutes(config('auth.passwords.users.expire', 60))
            ->isPast();

        if ($expired) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return redirect()->route('password.request')
                ->with('error', 'OTP expired.');
        }

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')
            ->with('success', 'Password reset successfully.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Signed out successfully.');
    }
}
