<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        ValidationException::class,
        TokenMismatchException::class,
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        // Model not found → friendly 404
        $this->renderable(function (ModelNotFoundException $e, $request) {
            $model = class_basename($e->getModel());
            if ($request->expectsJson()) {
                return response()->json(['message' => "{$model} not found."], 404);
            }
            return response()->view('errors.404', [
                'message' => "{$model} not found. It may have been deleted.",
            ], 404);
        });

        // Route not found
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Resource not found.'], 404);
            }
            return response()->view('errors.404', [
                'message' => 'The page you are looking for does not exist.',
            ], 404);
        });

        // Method not allowed
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Method not allowed.'], 405);
            }
            return response()->view('errors.generic', [
                'code'    => 405,
                'title'   => 'Method Not Allowed',
                'message' => 'The HTTP method used is not supported for this route.',
            ], 405);
        });

        // CSRF token mismatch
        $this->renderable(function (TokenMismatchException $e, $request) {
            return redirect()->back()
                ->withInput($request->except(['password', '_token']))
                ->with('error', 'Your session expired. Please try again.');
        });

        // Database errors
        $this->renderable(function (QueryException $e, $request) {
            report($e);
            if ($request->expectsJson()) {
                return response()->json(['message' => 'A database error occurred.'], 500);
            }
            return response()->view('errors.500', [
                'message' => 'A database error occurred. Please try again or contact support.',
            ], 500);
        });

        // Generic HTTP exceptions (403, 500, etc.)
        $this->renderable(function (HttpException $e, $request) {
            $code = $e->getStatusCode();
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage() ?: 'HTTP Error'], $code);
            }
            if (view()->exists("errors.{$code}")) {
                return response()->view("errors.{$code}", ['message' => $e->getMessage()], $code);
            }
            return response()->view('errors.generic', [
                'code'    => $code,
                'title'   => 'Error ' . $code,
                'message' => $e->getMessage() ?: 'An unexpected error occurred.',
            ], $code);
        });
    }
}
