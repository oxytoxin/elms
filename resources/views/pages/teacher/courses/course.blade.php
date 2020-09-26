@extends('layouts.teacher')
@section('content')
@include('includes.teacher.header')
<main class="p-3">
    @include('includes.teacher.nav')
    <div class="flex min-h-screen">
        @livewire('teacher-courses-page')
        @include('includes.teacher.menu')
    </div>
</main>
@endsection