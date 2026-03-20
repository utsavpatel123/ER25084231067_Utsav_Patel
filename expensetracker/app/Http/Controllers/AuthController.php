<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private const ADMIN_USERNAME = 'admin';
    private const ADMIN_PASSWORD = 'admin123';

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $username = $request->validated()['username'];
        $password = $request->validated()['password'];

        $validUser     = $username === self::ADMIN_USERNAME;
        $validPassword = $password === self::ADMIN_PASSWORD;

        if (!$validUser || !$validPassword) {
            Log::warning('Failed login attempt', [
                'username' => $username,
                'ip'       => $request->ip(),
            ]);

            return back()
                ->withInput($request->only('username'))
                ->withErrors(['password' => 'Invalid username or password.']);
        }

        $request->session()->regenerate();

        session([
            'admin_logged_in' => true,
            'admin_username'  => $username,
            'admin_name'      => 'Administrator',
            'login_time'      => now()->toDateTimeString(),
            'last_activity'   => now()->timestamp,
        ]);

        Log::info('Admin logged in', ['username' => $username, 'ip' => $request->ip()]);

        $intended = session()->pull('url.intended', route('dashboard'));
        return redirect($intended)->with('success', 'Welcome back, ' . ucfirst($username) . '!');
    }

    public function logout(Request $request)
    {
        $username = session('admin_username', 'unknown');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Admin logged out', ['username' => $username]);

        return redirect()->route('auth.login')
            ->with('success', 'You have been signed out successfully.');
    }
}
