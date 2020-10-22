@extends('layouts.master')
@section('content')
<div class="px-5">
    <div class="flex">
        <div>
            <h1 class="text-2xl font-semibold">COURSE MANAGER</h1>
            <div class="py-2">
                <a href="{{ route('head.create_course') }}"
                    class="p-2 font-semibold text-white rounded-lg hover:text-primary-600 bg-primary-500">ADD
                    COURSE</a>
            </div>
            <div class="grid gap-2 mt-2 md:grid-cols-4">
                @forelse($courses as $course)
                <div class="w-full overflow-hidden max-w-64 h-80">
                    <div class="h-1/2"><img src="{{ asset('img/course.jpg') }}" class="object-cover w-full h-full"
                            alt="course"></div>
                    <div class="p-2 text-white h-4/12 bg-secondary-500">
                        <h1 class="text-sm text-center">{{ $course->name }}</h1>
                        <h1 class="font-semibold text-center text-orange-500">{{ $course->code }}</h1>
                    </div>
                    <div class="h-2/12">
                        <a href="{{ route('head.course',['course'=>$course->id]) }}"
                            class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
                            View Course
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
    @include('includes.head.sidebar')
@endsection