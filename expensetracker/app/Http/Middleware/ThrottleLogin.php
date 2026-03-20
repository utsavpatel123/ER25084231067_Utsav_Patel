<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleLogin
{
    protected RateLimiter $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'login:' . $request->ip();
        $maxAttempts = 5;
        $decaySeconds = 60;

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $seconds = $this->limiter->availableIn($key);
            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => "Too many login attempts. Please wait {$seconds} seconds before trying again.",
                ]);
        }

        $response = $next($request);

        // If login failed (redirect back with errors), count the attempt
        if ($response->isRedirect() && session()->has('errors')) {
            $this->limiter->hit($key, $decaySeconds);
        } else {
            // Successful login: clear attempts
            $this->limiter->clear($key);
        }

        return $response;
    }
}
