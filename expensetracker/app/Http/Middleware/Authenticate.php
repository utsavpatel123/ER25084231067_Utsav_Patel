<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_logged_in') || !session('admin_logged_in')) {
            // Store the intended URL so we can redirect after login
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            session()->put('url.intended', $request->fullUrl());
            return redirect()->route('auth.login')
                ->with('info', 'Please sign in to access ExpenseTracker.');
        }

        return $next($request);
    }
}
