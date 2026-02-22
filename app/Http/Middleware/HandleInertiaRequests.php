<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $locale = App::getLocale();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'is_admin' => $request->user()?->isAdmin(),
            ],
            'flash' => [
                'successContactMessage' => $request->session()->get('successContactMessage'),
            ],
            'cart' => function () {
                return Session::get('cart', []);
            },
            'locale' => $locale,
            'translations' => function () use ($locale) {
                $translationFile = lang_path("{$locale}/messages.php");
                if (file_exists($translationFile)) {
                    return require $translationFile;
                }

                return [];
            },
        ];
    }
}
