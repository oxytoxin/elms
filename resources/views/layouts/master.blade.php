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
    <style>
        [x-cloak] { display: none; }
    </style>
    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-200">
    <div class="flex w-full" x-data="{showSidebar:true, mobile: false}" x-init="()=>{
        if(window.matchMedia('(max-width: 480px)').matches){mobile=true; showSidebar=false;}
    }">
        <aside @click.away="if(mobile)showSidebar = false" x-show="showSidebar"
        x-transition:enter="transition ease-out du ration-200"
        x-transition:enter-start="opacity-0 transform -translate-x-40"
        x-transition:enter-end="opacity-100 transform"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform"
        x-transition:leave-end="opacity-0 transform -translate-x-40"
        class="fixed top-0 z-50 flex-shrink-0 h-screen text-white md:sticky max-w-72 bg-primary-600">
                @yield('sidebar')
        </aside>
        <main class="w-full">
            <header class="sticky top-0 z-40 flex flex-col items-center justify-between px-3 font-semibold text-white min-h-16 md:flex-row bg-primary-500">
                <h1 class="flex items-center text-center"><div x-show="!showSidebar" class="w-12 mx-3 logo">
                    <img src="{{ asset('img/sksulogo.png') }}" alt="logo">
                </div>SULTAN KUDARAT STATE UNIVERSITY - ISULAN CAMPUS</h1>
                <nav class="text-2xl">
                    <a @click="showSidebar = !showSidebar"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-navigation-menu"></i></a>
                    <a><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-wechat"></i></a>
                    <a href="#"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-alarm"></i></a>
                    <a href="{{ \Request()->route()->getPrefix().'/calendar' }}"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-ui-calendar"></i></a>
                    <a href="#"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-question-circle"></i></a>
                    <a href="{{ route('profile.show') }}"><i
                            class="mx-2 cursor-pointer hover:text-primary-600 icofont-user-alt-4"></i></a>
                    <form class="inline-block" method="POST" action="{{ route('logout') }}">
                        <button type="submit"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-logout"></i></button>
                    </form>
                </nav>
            </header>
            <article class="flex w-full">
                <section class="w-full pb-5">
                    @yield('content')
                </section>
                <section x-show.transition.duration.750ms.origin.center.right="showSidebar" class="relative flex-col flex-shrink-0 hidden w-64 p-3 lg:flex pinned-items">
                    @livewire('layouts.sidelist')
                </section>
            </article>
        </main>
    </div>

    @stack('modals')
    @stack('scripts')
    @livewireScripts
</body>

</html>