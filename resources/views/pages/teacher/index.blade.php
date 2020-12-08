@extends('layouts.master')
@section('content')
    <div class="px-5">
        <h1 class="text-2xl font-semibold">Assigned Courses</h1>
        <div class="grid gap-2 p-2 md:grid-cols-3 xxl:grid-cols-5 lg:grid-cols-4">
            @forelse($sections as $section)
            <div class="w-full overflow-hidden h-80">
                <div class="h-1/2"><img src="{{ $section->course->image->url }}" class="object-cover w-full h-full"
                        alt="course"></div>
                <div class="p-2 text-white h-4/12 bg-secondary-500">
                    <h1 class="text-sm text-center">{{ $section->course->name }}</h1>
                    <h1 class="font-semibold text-center text-orange-500">{{ $section->course->code }}</h1>
                    <h1 class="text-sm text-center">{{ $section->code }}</h1>
                </div>
                <div class="h-2/12">
                    <a href="{{ route('teacher.course',['section'=>$section->id]) }}"
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
@endsection

@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection