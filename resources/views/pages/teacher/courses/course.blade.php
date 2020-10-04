@extends('layouts.teacher')
@section('content')
@include('includes.teacher.header')
<main class="p-3">
    <div class="flex min-h-screen">
        @livewire('teacher-courses-page',['course'=>$course])
        @include('includes.teacher.menu')
    </div>
</main>
@endsection