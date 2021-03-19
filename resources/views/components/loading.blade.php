@props(['message'])
<div {{ $attributes }} x-data x-cloak class="fixed inset-0 z-50 grid w-screen h-screen bg-gray-500 bg-opacity-50 place-items-center">
    <div class="flex flex-col items-center justify-center space-y-3">
        <i class="text-6xl fas fa-spinner fa-spin text-primary-600"></i>
        <h1 class="text-xl text-white">{{ $message }}</h1>
    </div>
</div>
