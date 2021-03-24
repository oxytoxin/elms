@extends('layouts.master')
@section('content')
<div>
    <h1 class="text-2xl font-semibold">COURSE MANAGER</h1>
    <div class="flex mt-5 space-x-3">
        <a href="{{ route('head.create_course') }}" class="p-2 font-semibold text-white rounded-lg hover:text-primary-600 bg-primary-500"><i class="mr-2 icofont-plus"></i>ADD
            COURSE
        </a>
        <a href="{{ route('head.add_section') }}" class="p-2 font-semibold text-white rounded-lg hover:text-primary-600 bg-primary-500"><i class="mr-2 icofont-plus"></i>ADD
            SECTION
        </a>
    </div>
    <div class="grid gap-2 mt-5 grid-cols-[repeat(auto-fill,minmax(220px,1fr))]">
        @forelse($courses as $course)
        <div class="w-full overflow-hidden border-4 border-primary-600 h-96">
            <div class="h-1/2"><img src="{{ $course->image->url }}" class="object-cover w-full h-full" alt="course"></div>
            <div class="p-2 text-white h-2/6 bg-secondary-500">
                <h1 class="text-sm text-center">{{ $course->name }}</h1>
                <h1 class="font-semibold text-center text-orange-500">{{ $course->code }}</h1>
                <h1 class="font-semibold text-center">sections: {{ $course->sections->count() }}</h1>
            </div>
            <div class="h-1/6">
                <a href="{{ route('head.course',['course'=>$course->id]) }}" class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
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
@include('includes.head.sidebar')
@endsection
