<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Only allow users with role 'admin' to proceed.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || (!auth()->user()->isAdmin() && !auth()->user()->isStaff())) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin admin atau staff.');
        }

        return $next($request);
    }
}
