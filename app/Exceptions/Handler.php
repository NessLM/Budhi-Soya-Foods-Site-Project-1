<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Handle AJAX requests with JSON response
        if ($request->expectsJson()) {
            return $this->handleAjaxException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle AJAX exceptions with proper JSON response
     */
    protected function handleAjaxException(Request $request, Throwable $e): JsonResponse
    {
        $status = 500;
        $message = 'Terjadi kesalahan internal server';

        if ($e instanceof \Illuminate\Validation\ValidationException) {
            $status = 422;
            $message = 'Data tidak valid';
        } elseif ($e instanceof \Illuminate\Database\QueryException) {
            $status = 500;
            $message = 'Terjadi kesalahan database';
        } elseif ($e instanceof \Exception) {
            $status = 500;
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => config('app.debug') ? $e->getMessage() : null
        ], $status);
    }
} 