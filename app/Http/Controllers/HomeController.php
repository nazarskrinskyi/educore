<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PageConfiguration;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(Request $request): Response
    {
        if (auth()->check()) {
            $pageConfig = PageConfiguration::getPageConfig('dashboard');

            return Inertia::render('Dashboard', [
                'pageConfig' => $pageConfig,
            ]);
        }

        $pageConfig = PageConfiguration::getPageConfig('welcome');

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'pageConfig' => $pageConfig,
        ]);
    }
}
