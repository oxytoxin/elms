@extends('layouts.master')
@section('content')
<div class="px-5">
    <div class="flex">
        <div class="w-full mx-4">
            <iframe src="https://docs.google.com/file/d/{{ $google_id }}/preview" frameborder="2" class="w-full min-h-halfscreen md:min-h-screen"></iframe>
        </div>
    </div>
</div>
@endsection
@push('metas')
<meta name="turbolinks-cache-control" content="no-cache">
@endpush

@section('sidebar')
@switch(session('whereami'))
@case('student')
@include('includes.student.sidebar')
@break
@case('teacher')
@include('includes.teacher.sidebar')
@break
@case('programhead')
@include('includes.head.sidebar')
@break
@case('dean')
@include('includes.dean.sidebar')
@break
@default
@endswitch
@endsection
