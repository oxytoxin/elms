@extends('layouts.student')
@section('content')
   @include('includes.student.header')
    <main class="p-3">
     @include('includes.student.nav')
        <div class="flex min-h-screen">
            <div class="w-5/6 m-4">
                <h1 class="p-2 font-semibold">Enrolled Courses</h1>
                <div class="grid grid-cols-4 gap-2 p-2">
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                    <div class="w-full bg-orange-200 h-72"></div>
                </div>
            </div>
            @include('includes.student.menu')
        </div>
    </main>
@endsection