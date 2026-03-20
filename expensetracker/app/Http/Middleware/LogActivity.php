<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Log only authenticated non-GET requests (state-changing actions)
        if (session('admin_logged_in') && !in_array($request->method(), ['GET', 'HEAD'])) {
            Log::channel('daily')->info('Admin action', [
                'method'  => $request->method(),
                'url'     => $request->fullUrl(),
                'ip'      => $request->ip(),
                'admin'   => session('admin_username', 'unknown'),
                'status'  => $response->getStatusCode(),
            ]);
        }

        return $response;
    }
}
