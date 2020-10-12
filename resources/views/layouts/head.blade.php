<!DOCTYPE html>
<html oncontextmenu="return false" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ELMS') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa-min.css') }}">
    <link rel="stylesheet" href="{{ asset('icofont/icofont.min.css') }}">
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.js" defer></script>
</head>

<body class="w-full overflow-x-hidden font-sans antialiased">
    <div x-data="{ sidebar: true}" class="flex min-h-screen bg-gray-100">

        <aside class="hidden md:block bg-primary-600">
            @include('includes.head.sidebar')
        </aside>

        <!-- Page Content -->
        <article class="w-full">
            @yield('content')
        </article>
    </div>

    @stack('modals')

    @livewireScripts
</body>
</html>