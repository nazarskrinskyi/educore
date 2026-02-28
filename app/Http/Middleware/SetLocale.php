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
     * Supported locales
     */
    private const SUPPORTED_LOCALES = ['en', 'uk'];

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->determineLocale($request);

        // Store locale in session
        Session::put('locale', $locale);

        // Set the application locale
        App::setLocale($locale);

        // Set default locale for URL generation
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }

    /**
     * Determine the locale from request
     *
     * @param Request $request
     * @return string
     */
    private function determineLocale(Request $request): string
    {
        // First, check if the first URL segment is a valid locale
        $urlLocale = $request->segment(1);

        if ($this->isValidLocale($urlLocale)) {
            return $urlLocale;
        }

        // Second, check session
        $sessionLocale = Session::get('locale');

        if ($this->isValidLocale($sessionLocale)) {
            return $sessionLocale;
        }

        // Finally, fall back to config default
        $defaultLocale = config('app.locale', 'en');

        return $this->isValidLocale($defaultLocale) ? $defaultLocale : 'en';
    }

    /**
     * Check if locale is valid
     *
     * @param mixed $locale
     * @return bool
     */
    private function isValidLocale(mixed $locale): bool
    {
        return is_string($locale) && in_array($locale, self::SUPPORTED_LOCALES, true);
    }
}
