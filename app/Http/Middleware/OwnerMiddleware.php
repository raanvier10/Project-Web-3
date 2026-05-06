<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     * Only allow users with role 'owner' to proceed.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isOwner()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin owner.');
        }

        return $next($request);
    }
}
