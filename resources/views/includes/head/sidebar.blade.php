<div class="sticky top-0 flex flex-col text-gray-300 root">
    <div class="flex items-center justify-center h-12 p-1 border-b border-white bg-primary-500 banner">
        <div class="h-full m-3"><img src="{{ asset('img/sksulogo.png') }}" class="object-cover h-full" alt="logo"></div>
        <a href="/">
            <h1 class="text-lg font-semibold text-white">E-LeaDs</h1>
        </a>
    </div>
    <div class="flex justify-center py-4 mx-2 border-b border-white profile">
        <div class="avatar h-11"><img src="{{ asset('img/avatar.jpg') }}" class="object-cover h-full rounded-full"
                alt="avatar"></div>
        <div class="ml-3">
            <h1>{{ auth()->user()->name }}</h1>
            <div class="flex items-center">
                <div class="w-3 h-3 mr-1 rounded-full bg-primary-500"></div>
                <h1 class="text-xs">Online</h1>
            </div>
        </div>
    </div>
    <div class="p-2 mt-3">
        <h1 class="text-sm font-semibold">Program Head</h1>
        <div class="actions">
            <a href="{{ route('head.home') }}"
                class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                <i class="mr-2 icofont-home"></i>
                <h1 class="text-sm font-semibold">Home</h1>
            </a>
            <a href="{{ route('head.courses') }}"
                class="flex items-center p-2 bg-opacity-25 rounded-md hover:bg-gray-400 item">
                <i class="mr-2 icofont-attachment"></i>
                <h1 class="text-sm font-semibold">Course Manager</h1>
            </a>
            <a href="{{ route('head.modules') }}"
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
    </div>
</div>