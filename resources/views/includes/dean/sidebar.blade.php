<div class="relative flex flex-col min-h-screen">
    <div class="relative z-20 flex flex-col flex-1 h-0 overflow-y-auto">
        <a href="/" class="flex items-center justify-center h-16 p-2 border-2 border-white banner bg-primary-500">
            <div class="w-12 logo">
                <img src="{{ asset('img/sksulogo.png') }}" alt="logo">
            </div>
            <h1 class="mx-3 text-xl font-semibold text-white">E-LeaDs</h1>
        </a>
        <div class="flex items-center justify-center py-3 mx-2 border-b-2 border-white">
            <div class="w-12 h-12 avatar">
                <img class="object-cover w-full h-full rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="avatar">
            </div>
            <div class="mx-4">
                <h1>{{ auth()->user()->name }}</h1>
                <h1 class="flex items-center">
                    <div class="w-3 h-3 mr-1 rounded-full bg-primary-500"></div>Online
                </h1>
            </div>
        </div>
        <div class="flex flex-col flex-1 p-3 overflow-y-auto font-semibold bg-opacity-75 min-h-halfscreen links bg-primary-600">
            <h1 class="text-sm font-semibold">Dean</h1>
            <div class="actions">
                <a href="{{ route('dean.home') }}"
                    class="flex {{ strpos(url()->current(), 'home') ? 'bg-gray-400' : '' }} items-center p-2 bg-opacity-75 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-home"></i>
                    <h1 class="text-sm font-semibold">Home</h1>
                </a>
                <a href="{{ route('dean.programhead_manager') }}"
                    class="flex {{ strpos(url()->current(), 'manage-program-heads') ? 'bg-gray-400' : '' }} items-center p-2 bg-opacity-75 rounded-md hover:bg-gray-400 item">
                    <i class="mr-2 icofont-users-alt-1"></i>
                    <h1 class="text-sm font-semibold">Program Head Manager</h1>
                </a>

            </div>
            @if (auth()
        ->user()
        ->isTeacher())
                <h1 class="mt-5 text-sm font-semibold">Actions</h1>
                <div class="actions">
                    <a href="{{ route('teacher.home') }}" class="flex items-center p-2 bg-opacity-75 rounded-md hover:bg-gray-400 item">
                        <i class="mr-2 icofont-external"></i>
                        <h1 class="text-sm font-semibold">Faculty Dashboard</h1>
                    </a>
                </div>
            @endif
        </div>
    </div>
    <div class="absolute inset-0 z-0 flex items-center justify-center mx-auto overflow-hidden logo">
        <div class="w-11/12">
            <img src="{{ asset('img/sksulogo.png') }}" alt="logo" class="object-cover w-full">
        </div>
    </div>
</div>
