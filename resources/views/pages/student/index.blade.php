@extends('layouts.master')
@section('content')
<div class="space-y-5">
    <div class="flex flex-col items-center justify-between space-y-2 md:flex-row">
        <h1 class="text-2xl font-semibold uppercase">Enrolled Courses</h1>
        <div>
            <a href="{{ route('student.enrol_via_code') }}" class="inline-block p-3 font-semibold text-white bg-primary-500 hover:text-primary-600">ENROLL CODE</a>
        </div>
    </div>
    <div class="gap-2 grid-cols-[repeat(auto-fill,minmax(220px,1fr))] md:grid">
        @forelse($sections as $section)
        <div class="w-full overflow-hidden border-4 border-primary-600 h-96">
            <div class="h-1/2"><img src="{{ $section->course->image->url }}" class="object-cover w-full h-full" alt="course"></div>
            <div class="p-2 text-white h-2/6 bg-secondary-500">
                <h1 class="text-xs text-center">{{ $section->course->name }}</h1>
                <h1 class="text-xs font-semibold text-center text-orange-500">{{ $section->course->code }}</h1>
                <h1 class="text-xs text-center">{{ $section->code }}</h1>
                <h1 class="text-xs text-center">Instructor:<br>{{ $section->teacher->user->name }}</h1>
            </div>
            <div class="h-1/6">
                <a href="{{ route('student.course_modules',['section'=>$section->id]) }}" class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
                    View Modules
                </a>
            </div>
        </div>
        @empty
        <h1>No Course Found</h1>
        @endforelse
    </div>
    <div class="mt-3">
        {{ $sections->links() }}
    </div>
</div>
@endsection
@section('sidebar')
@include('includes.student.sidebar')
@endsection
