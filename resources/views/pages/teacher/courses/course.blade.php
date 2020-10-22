@extends('layouts.master')
@section('content')
<div class="px-5">
    <div class="flex">
        @livewire('teacher-courses-page',['course'=>$course])
    </div>
    </div>
@endsection
@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection