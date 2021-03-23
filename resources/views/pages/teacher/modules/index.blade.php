@extends('layouts.master')
@section('content')
<div>
    <h1 class="text-2xl font-semibold">MODULES MANAGER</h1>
    <div class="grid gap-2 mt-5 grid-cols-[repeat(auto-fill,minmax(220px,1fr))]">
        @forelse($sections as $section)
        <div class="w-full overflow-hidden border-4 border-primary-600 h-96">
            <div class="h-1/2"><img src="{{ $section->course->image->url }}" class="object-cover w-full h-full" alt="course"></div>
            <div class="p-2 text-white h-2/6 bg-secondary-500">
                <h1 class="text-xs text-center">{{ $section->course->name }}</h1>
                <h1 class="text-xs font-semibold text-center text-orange-500">{{ $section-> course->code }}</h1>
                <h1 class="text-xs text-center">{{ $section->code }}</h1>
            </div>
            <div class="h-1/6">
                <a href="{{ route('teacher.course_modules',['section'=>$section->id]) }}" class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
                    View Modules
                </a>
            </div>
        </div>
        @empty
        <h1>No Course Modules Found</h1>
        @endforelse
    </div>
</div>
@endsection
@section('sidebar')
@include('includes.teacher.sidebar')
@endsection
