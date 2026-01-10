<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'EduCore') }}</title>

        <!-- SEO Meta Tags -->
        <meta name="description" content="EduCore - Your educational management system for modern learning">
        <meta name="keywords" content="education, learning, courses, online education">
        <meta name="author" content="EduCore">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="/favicon.ico">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <!-- Stripe.js -->
        <script src="https://js.stripe.com/v3/" defer></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
