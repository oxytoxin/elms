<!DOCTYPE html>
<html oncontextmenu="return false" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="turbolinks-cache-control" content="no-cache"> --}}
    @stack('metas')
    <title>{{ config('app.name', 'ELMS') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa-min.css') }}">
    <link rel="stylesheet" href="{{ asset('icofont/icofont.min.css') }}">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.x/dist/alpine.js" defer></script>
    @if (strpos(url()->full(),"calendar") != false || strpos(url()->full(),"gradebook") != false)
    @else
    {{-- <script src="{{ asset('js/tblinks.js') }}" defer></script> --}}
    @endif
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('styles')
    <style>
        .filepond--credits {
            display: none;
        }

    </style>
</head>

<body class="antialiased bg-gray-100">
    @livewire('leina.chatbot', key('leina-chatbot'))
    <audio id="notifAudio">
        <source src="{{ asset('notification.ogg') }}" type="audio/ogg">
    </audio>
    <audio id="messageAudio">
        <source src="{{ asset('message.wav') }}" type="audio/wav">
    </audio>
    <div class="flex w-full" x-data="{showSidebar:true, mobile: false}" x-init="()=>{
        if(window.matchMedia('(max-width: 768px)').matches){mobile=true; showSidebar=false;}
    }">
        <aside @click.away="if(mobile)showSidebar = false" x-show="showSidebar" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-x-40" x-transition:enter-end="opacity-100 transform" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform" x-transition:leave-end="opacity-0 transform -translate-x-40" class="fixed top-0 left-0 z-50 flex-shrink-0 h-screen overflow-y-hidden text-white md:sticky max-w-72 bg-primary-600">
            @yield('sidebar')
        </aside>
        <main class="flex flex-col w-full min-h-screen">
            <header class="sticky top-0 z-40 flex flex-col items-center justify-between px-3 font-semibold text-white min-h-16 md:flex-row bg-primary-500">
                <h1 class="flex items-center text-center">
                    <div x-cloak x-show="!showSidebar" class="w-12 mx-3 logo">
                        <img src="{{ asset('img/sksulogo.png') }}" alt="logo">
                    </div><span class="uppercase">SULTAN KUDARAT STATE UNIVERSITY{{ auth()->user()->campus ? ' - ' . auth()->user()->campus->name : '' }}</span>
                </h1>
                <nav class="text-2xl whitespace-nowrap">
                    <a @click="showSidebar = !showSidebar"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-navigation-menu"></i></a>
                    <a data-turbolinks="false" href="{{ route("$whereami.messages") }}"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-wechat"></i></a>
                    @livewire('notification-component')
                    <a data-turbolinks="false" href="{{ route("$whereami.calendar") }}"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-ui-calendar"></i></a>
                    <a href="#"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-question-circle"></i></a>
                    <a href="{{ route('profile.show') }}"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-user-alt-4"></i></a>
                    <form class="inline-block" method="POST" action="{{ route('logout') }}">
                        <button type="submit"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-logout"></i></button>
                    </form>
                </nav>
            </header>
            <article class="flex flex-1 w-full">
                <section class="flex-grow h-full p-5 overflow-hidden">
                    @yield('content')
                </section>
                <section x-show.transition.duration.750ms.origin.center.right="showSidebar" class="relative flex-col flex-shrink-0 hidden w-64 p-3 lg:flex pinned-items">
                    @livewire('layouts.sidelist')
                </section>
            </article>
        </main>
    </div>
    @stack('modals')
    <script src='https://meet.jit.si/external_api.js'></script>
    @stack('scripts')
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <x-livewire-alert::scripts />
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
</body>

</html>
