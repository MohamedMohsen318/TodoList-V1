<?php

namespace App\Http\Controllers;

use App\Mail\SendResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $userLogin = $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:6',
        ]);

        if (! Auth::attempt($userLogin, $request->boolean('remember')))/*remember me*/
        {
            return back()
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()
            ->route('welcome')
            ->with('success', 'Signed in successfully.');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $newUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create($newUser);

        return redirect()
            ->route('login')
            ->with('success', 'Account created successfully. You can sign in now.');
    }
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|string|email|exists:users,email',]);
        $token = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $request->email],
            ['token' => $token, 'created_at' => now(),]);

        Mail::to($request->email)
            ->send(new SendResetPassword($token));

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
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Signed out successfully.');
    }
}
