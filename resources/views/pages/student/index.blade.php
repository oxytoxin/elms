@extends('layouts.master')
@section('content')
<div class="px-5">
    <div class="flex">
        <div class="mx-4">
            <h1 class="p-2 text-2xl font-semibold">Enrolled Courses</h1>
            <div class="gap-2 p-2 md:grid-cols-3 lg:grid-cols-4 md:grid">
                @forelse($courses as $course)
                <div class="w-full overflow-hidden max-w-64 h-80">
                    <div class="h-1/2"><img src="{{ asset('img/course.jpg') }}" class="object-cover w-full h-full"
                            alt="course"></div>
                    <div class="p-2 text-white h-4/12 bg-secondary-500">
                        <h1 class="text-sm text-center">{{ $course->name }}</h1>
                        <h1 class="font-semibold text-center text-orange-500">{{ $course->code }}</h1>
                    </div>
                    <div class="h-2/12">
                        <a href="{{ route('student.course_modules',['course'=>$course->id]) }}"
                            class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
                            View Modules
                        </a>
                    </div>
                </div>
                @empty
                <h1>No Course Found</h1>
                @endforelse
            </div>
        </div>
    </div>
    </div>
@endsection
@section('sidebar')
    @include('includes.student.sidebar')
@endsection