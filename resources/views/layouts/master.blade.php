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

<body class="font-sans antialiased bg-gray-400">
    <div class="flex w-full">
        <aside class="fixed top-0 z-50 flex-shrink-0 h-screen text-white md:sticky max-w-72 bg-primary-600">
            <a href="#" class="flex items-center justify-center h-16 p-2 border-2 border-white banner bg-primary-500">
                <div class="w-12 logo">
                    <img src="{{ asset('img/sksulogo.png') }}" alt="logo">
                </div>
                <h1 class="mx-3 text-xl font-semibold text-white">E-LeaDs</h1>
            </a>
            <div class="flex items-center justify-center py-3 mx-2 border-b-2 border-white">
                <div class="avatar">
                    <img class="w-12 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="avatar">
                </div>
                <div class="mx-4">
                    <h1>{{ auth()->user()->name }}</h1>
                    <h1 class="flex items-center"><div class="w-3 h-3 mr-1 rounded-full bg-primary-500"></div>Online</h1>
                </div>
            </div>
            <div class="m-3 font-semibold links">
                <h1 class="text-sm font-semibold">Teacher</h1>
            <div class="actions">
                <a href="{{ route('teacher.home') }}"
                    class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-home"></i>
                    <h1 class="text-sm font-semibold">Home</h1>
                </a>
                <a href="{{ route('teacher.modules') }}"
                    class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-book"></i>
                    <h1 class="text-sm font-semibold">Modules</h1>
                </a>
                <a href="#" class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-ui-calendar"></i>
                    <h1 class="text-sm font-semibold">Calendar</h1>
                </a>
                <a href="#" class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-file-pdf"></i>
                    <h1 class="text-sm font-semibold">Forms</h1>
                </a>
            </div>
            <h1 class="mt-5 text-sm font-semibold">Tasks</h1>
            <div class="actions">
                <a href="#" class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-ui-folder"></i>
                    <h1 class="text-sm font-semibold">Assigments</h1>
                </a>
                <a href="#" class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-ui-folder"></i>
                    <h1 class="text-sm font-semibold">Quizzes</h1>
                </a>
                <a href="#" class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-ui-folder"></i>
                    <h1 class="text-sm font-semibold">Activities</h1>
                </a>
                <a href="#" class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-ui-folder"></i>
                    <h1 class="text-sm font-semibold">Exams</h1>
                </a>
            </div>
            <h1 class="mt-5 text-sm font-semibold">Actions</h1>
            <div class="actions">
                <a href="{{ route('head.home') }}" class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-external"></i>
                    <h1 class="text-sm font-semibold">Program Head Dashboard</h1>
                </a>
            </div>
            </div>

        </aside>
        <main class="w-full">
            <header class="sticky top-0 flex flex-col items-center justify-between px-3 font-semibold text-white min-h-16 md:flex-row bg-primary-500">
                <h1 class="text-center">SULTAN KUDARAT STATE UNIVERSITY - ISULAN CAMPUS</h1>
                <nav class="text-2xl">
                    <a href="#"><i class="mx-2 cursor-pointer hover:text-white icofont-wechat"></i></a>
                    <a href="#"><i class="mx-2 cursor-pointer hover:text-white icofont-alarm"></i></a>
                    <a href="#"><i class="mx-2 cursor-pointer hover:text-white icofont-ui-calendar"></i></a>
                    <a href="#"><i class="mx-2 cursor-pointer hover:text-white icofont-question-circle"></i></a>
                    <a href="{{ route('profile.show') }}"><i
                            class="mx-2 cursor-pointer hover:text-white icofont-user-alt-4"></i></a>
                </nav>
            </header>
            <article class="flex w-full">
                <section class="w-full h-screen">
                    @yield('content')
                </section>
                <section class="flex flex-col flex-shrink-0 w-64 p-3 pinned-items">
                        <div class="bg-white rounded-sm shadow-md card">
                            <div class="flex justify-between px-3 py-1 border-b border-gray-500 title">
                                <h1 class="text-sm font-semibold">To Do</h1>
                                <a href="#"><i class="icofont-plus"></i></a>
                            </div>
                            <div class="min-h-16 content"></div>
                        </div>
                        <div class="mt-5 bg-white rounded-sm shadow-md card">
                            <div class="flex justify-between px-3 py-1 border-b border-gray-500 title">
                                <h1 class="text-sm font-semibold">Assignments</h1>
                            </div>
                            <div class="p-2 min-h-16 content">
                                <h1 class="text-xs">
                                    <i class="icofont-notepad"></i><a href="#">A Part of Precaution.....</a>
                                    <h1 class="text-xs text-red-600">(Due: 09-08-2020)</h1>
                                </h1>
                            </div>
                        </div>
                        <div class="mt-5 bg-white rounded-sm shadow-md card">
                            <div class="flex justify-between px-3 py-1 border-b border-gray-500 title">
                                <h1 class="text-sm font-semibold">Announcements</h1>
                            </div>
                            <div class="p-2 min-h-16 content">
                                <h1 class="text-xs">
                                    <i class="text-red-600 icofont-alarm"></i><a href="#">Resume of Payment</a>
                                    <i class="text-red-600 icofont-alarm"></i><a href="#">Enrollment Date</a>
                                </h1>
                            </div>
                        </div>
                </section>
            </article>
        </main>
    </div>

    @stack('modals')
    @stack('scripts')
    @livewireScripts
</body>

</html>