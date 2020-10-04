@extends('layouts.head')
@section('content')
@include('includes.head.header')
<main class="p-3">
    <div class="flex min-h-screen">
        <div class="w-5/6 mx-4">
            <h1 class="p-2 text-2xl font-semibold">MODULES MANAGER</h1>
            <div class="grid grid-cols-4 gap-2 p-2">
                @forelse($modules as $module)
                <div class="w-full overflow-hidden h-80">
                    <div class="h-1/2"><img src="{{ asset('img/course.jpg') }}" class="object-cover w-full h-full"
                            alt="course"></div>
                    <div class="p-2 text-white h-4/12 bg-secondary-500">
                        <h1 class="text-sm text-center">{{ $module->name }}</h1>
                    </div>
                    <div class="h-2/12">
                        <a href="{{ route('head.module',['module'=>$module->id]) }}"
                            class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
                            View Module
                        </a>
                    </div>
                </div>
                @empty
                <h1>No Modules Found</h1>
                @endforelse
            </div>
        </div>
        @include('includes.head.menu')
    </div>
</main>
@endsection