@extends('layouts.master')
@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold uppercase">Enrolled Courses</h1>
        <div>
            <a href="{{ route('student.enrol_via_code') }}" class="p-3 font-semibold text-white bg-primary-500 hover:text-primary-600">ENROLL CODE</a>
        </div>
    </div>
    <div class="gap-2 md:grid-cols-3 xxl:grid-cols-5 xl:grid-cols-4 md:grid">
        @forelse($sections as $section)
        <div class="w-full overflow-hidden transition duration-500 transform border-4 hover:scale-105 border-primary-600 h-96">
            <div class="h-1/2"><img src="{{ $section->course->image->url }}" class="object-cover w-full h-full"
                    alt="course"></div>
            <div class="p-2 text-white h-4/12 bg-secondary-500">
                <h1 class="text-sm text-center">{{ $section->course->name }}</h1>
                <h1 class="font-semibold text-center text-orange-500">{{ $section->course->code }}</h1>
                <h1 class="text-center">{{ $section->code }}</h1>
            </div>
            <div class="h-2/12">
                <a href="{{ route('student.course_modules',['section'=>$section->id]) }}"
                    class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
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