<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class LocaleController extends Controller
{
    private const SUPPORTED_LOCALES = ['en', 'uk'];

    /**
     * Switch the application locale
     */
    public function switch(Request $request)
    {
        $validated = $request->validate([
            'locale' => 'required|in:en,uk',
        ]);

        $locale = $validated['locale'];

        // Store locale in session
        Session::put('locale', $locale);

        // Set the application locale immediately
        App::setLocale($locale);

        // Set URL defaults for this request
        URL::defaults(['locale' => $locale]);

        // Get the redirect path
        $redirectPath = $this->buildRedirectPath($request, $locale);

        return Redirect::to($redirectPath);
    }

    /**
     * Build the redirect path with the new locale
     */
    private function buildRedirectPath(Request $request, string $locale): string
    {
        // Get the current path
        $currentPath = $request->path();

        // Remove leading/trailing slashes
        $currentPath = trim($currentPath, '/');

        // Split into segments
        $segments = $currentPath ? explode('/', $currentPath) : [];

        // Remove old locale if present
        if (!empty($segments) && in_array($segments[0], self::SUPPORTED_LOCALES)) {
            array_shift($segments);
        }

        // Build new path with locale
        $newPath = '/' . $locale;
        if (!empty($segments)) {
            $newPath .= '/' . implode('/', $segments);
        }

        // Preserve query string
        $queryString = $request->getQueryString();
        if ($queryString) {
            $newPath .= '?' . $queryString;
        }

        return $newPath;
    }
}
