<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from URL segment, session, or config default
        $locale = $request->segment(1);

        // Check if the first segment is a valid locale
        if (!in_array($locale, ['en', 'uk'])) {
            // If not, get from session or config
            $locale = Session::get('locale', config('app.locale'));
        } else {
            // Store the locale from URL in session
            Session::put('locale', $locale);
        }

        // Ensure the locale is supported
        if (!in_array($locale, ['en', 'uk'])) {
            $locale = config('app.locale');
        }

        // Set the application locale
        App::setLocale($locale);

        // Set default locale for URL generation
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
