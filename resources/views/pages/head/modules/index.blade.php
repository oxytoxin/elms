@extends('layouts.master')
@section('content')
<div>
    <h1 class="text-2xl font-semibold">MODULES MANAGER</h1>
    <div class="grid gap-2 mt-5 grid-cols-[repeat(auto-fill,minmax(220px,1fr))]">
        @forelse ($modules as $module)
        <div class="w-full overflow-hidden border-4 border-primary-600 h-96">
            <div class="h-1/2"><img src="{{ $module->image->url }}" class="object-cover w-full h-full" alt="course"></div>
            <div class="p-2 text-white h-2/6 bg-secondary-500">
                <h1 class="text-xs italic text-center">{{ $module->course->name }}</h1>
                <h1 class="text-xs italic font-bold text-center text-orange-500">{{ $module->course->code }}</h1>
                <h1 class="text-sm text-center">{{ $module->name }}</h1>
            </div>
            <div class="h-1/6">
                <a href="{{ route('head.module',['module'=>$module->id]) }}" class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
                    View Module
                </a>
            </div>
        </div>
        @empty
        <h1>No Modules Found</h1>
        @endforelse

    </div>
    @if ($modules->count())
    <div class="mx-auto mt-3">
        {{ $modules->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>
@endsection
@section('sidebar')
@include('includes.head.sidebar')
@endsection
