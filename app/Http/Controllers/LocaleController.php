<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch the application locale
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function switch(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:en,uk',
        ]);

        $locale = $request->input('locale');

        // Store locale in session
        Session::put('locale', $locale);

        // Set the application locale
        app()->setLocale($locale);

        // Get the current URL and replace the locale prefix
        $currentUrl = url()->previous();
        $currentPath = parse_url($currentUrl, PHP_URL_PATH);

        // Remove existing locale prefix if present
        $pathWithoutLocale = preg_replace('#^/(en|uk)(/|$)#', '/', $currentPath);

        // Ensure path starts with /
        if ($pathWithoutLocale === '') {
            $pathWithoutLocale = '/';
        }

        // Add locale prefix
        $newPath = '/'.$locale.($pathWithoutLocale === '/' ? '' : $pathWithoutLocale);

        // Use a regular redirect with a full page reload
        return redirect($newPath);
    }
}
