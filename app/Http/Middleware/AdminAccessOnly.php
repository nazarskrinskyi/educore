<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || (!auth()->user()->isAdmin() && !auth()->user()->isInstructor())) {
            abort(403);
        }

        return $next($request);
    }
}
