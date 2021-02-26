@extends('layouts.master')
@section('content')
<div>
    <h1 class="text-2xl font-semibold uppercase">Modules</h1>
    <div class="grid gap-2 mt-5 md:grid-cols-3 xxl:grid-cols-5 xl:grid-cols-4">
        @forelse($sections as $section)
        @forelse ($section->modules as $module)
        <div class="w-full overflow-hidden transition duration-500 transform border-4 hover:scale-105 border-primary-600 h-96">
            <div class="h-1/2"><img src="{{ $module->image->url }}" class="object-cover w-full h-full" alt="course"></div>
            <div class="p-2 text-white h-4/12 bg-secondary-500">
                <h1 class="text-xs italic text-center">{{ $course->name }}</h1>
                <h1 class="text-xs italic font-bold text-center text-orange-500">{{ $course->code }}</h1>
                <h1 class="text-xs text-center">{{ $module->section->code }}</h1>
                <h1 class="text-sm text-center">{{ $module->name }}</h1>
            </div>
            <div class="h-2/12">
                <a href="{{ route('student.module',['module'=>$module->id]) }}" class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
                    View Module
                </a>
            </div>
        </div>
        @empty

        @endforelse
        @empty
        <h1>No Courses Found</h1>
        @endforelse
    </div>
    <div class="mt-3">
        {{ $courses->links() }}
    </div>
</div>
@endsection
@section('sidebar')
@include('includes.student.sidebar')
@endsection
