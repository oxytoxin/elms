@props(['message'])
<div {{ $attributes }} x-data x-cloak class="fixed inset-0 z-50 w-screen h-screen bg-gray-500 bg-opacity-50">
    <div class="grid w-full h-full place-items-center">
        <div class="flex flex-col items-center justify-center space-y-3">
            <img src="{{ asset('img/leina.png') }}" alt="leina" class="self-end h-full animate-pulse w-44">
            <div class="flex items-center space-x-2">
                <h1 class="text-white uppercase">{{ $message }}</h1>
                <i class="fas fa-spinner fa-spin text-primary-600"></i>
            </div>
        </div>
    </div>
</div>
