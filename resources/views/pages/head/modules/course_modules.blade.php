@extends('layouts.master')
@section('content')
<div class="px-5">
    <div>
        <h1 class="text-2xl font-semibold">MODULES MANAGER</h1>
        <h1 class="flex justify-between p-2 my-2 italic font-semibold text-white bg-primary-500"><span>{{ $section->course->name }}</span><span class="not-italic">{{ $section->code }}</span></h1>
        <div class="grid gap-2 grid-cols-[repeat(auto-fill,minmax(220px,1fr))]">
            @forelse($modules as $module)
            <div class="w-full overflow-hidden border-4 border-primary-600 h-96">
                <div class="h-1/2"><img src="{{ $module->image->url ?? asset('img/bg/bg(2).jpg') }}" class="object-cover w-full h-full" alt="course"></div>
                <div class="p-2 text-white h-2/6 bg-secondary-500">
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
    </div>
</div>
@endsection
@section('sidebar')
@include('includes.head.sidebar')
@endsection
