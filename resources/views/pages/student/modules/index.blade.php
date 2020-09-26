@extends('layouts.student')
@section('content')
@include('includes.student.header')
<main class="p-3">
    @include('includes.student.nav')
    <div class="flex min-h-screen">
        <div class="w-5/6 m-4">
            <h1 class="p-2 font-semibold">Modules</h1>
            <div class="grid grid-cols-4 gap-2 p-2">
                <div class="w-full overflow-hidden h-72">
                    <div class="h-1/2"><img src="{{ asset('img/course.jpg') }}" class="object-cover w-full h-full" alt="course"></div>
                    <div class="p-2 text-white h-4/12 bg-secondary-500">
                        <h1 class="font-semibold text-center">Module Title</h1>
                    </div>
                    <div class="h-2/12"><a href="{{route('student.module',['id'=>'1'])}}" class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">View Module</a></div>
                </div>
            </div>
        </div>
        @include('includes.student.menu')
    </div>
</main>
@endsection