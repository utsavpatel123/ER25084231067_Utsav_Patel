<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('admin_logged_in') && session('admin_logged_in')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
