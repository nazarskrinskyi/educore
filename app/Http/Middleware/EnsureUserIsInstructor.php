<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsInstructor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('instructor.login');
        }

        if (auth()->user()->role !== RoleEnum::INSTRUCTOR && auth()->user()->role !== RoleEnum::ADMIN) {
            abort(403, 'Access denied. This area is for instructors only.');
        }

        return $next($request);
    }
}
