<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;  // ini buat Response
use Illuminate\Support\Facades\Auth; // ini penting buat auth()

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Hanya cek apakah guard 'admin' terautentikasi
        if (!Auth::guard('admin')->check()) {
            abort(403, 'You do not have sufficient privileges.');
        }

        return $next($request);
    }
}