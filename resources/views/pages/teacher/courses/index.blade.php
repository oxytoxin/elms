@extends('layouts.teacher')
@section('content')
<div class="px-5">
    <div class="flex">
        <div class="mx-4">
            <h1 class="p-2 font-semibold">COURSE MANAGER</h1>
            <div class="grid gap-2 p-2 md:grid-cols-4 xxl:grid-cols-5">
                @forelse ($courses as $course)
                <div class="w-full overflow-hidden h-80">
                    <div class="h-1/2"><img src={{ $course->image->url }}" class="object-cover w-full h-full"
                            alt="course"></div>
                    <div class="p-2 text-white h-4/12 bg-secondary-500">
                        <h1 class="font-semibold text-center">Course Title</h1>
                    </div>
                    <div class="h-2/12"><a href="#"
                            class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">View
                            Course</a></div>
                </div>
                @empty
                <h1>No Assigned Courses Yet.</h1>
                @endforelse
            </div>
        </div>
    </div>
    </div>
@endsection
@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection