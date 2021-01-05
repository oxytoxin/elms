@extends('layouts.master')
@section('content')
    <div class="w-3/4 p-3 mx-auto my-5 shadow-lg">
        <h1 class="font-semibold">Event Details</h1>
        <hr class="border-2 border-primary-600">
        <br>
        <h1>{{ $event->title }}</h1>
        <h1>Event Description: {{ $event->description }}</h1>
        <h1>Created by: {{ $event->user->name }}</h1>
        <h1>Created at: {{ $event->created_at->format('M d, Y') }}</h1>
        <h1>Event Starts at: {{ $event->start->format('M d, Y - g:i A') }} ({{ $event->start->diffForHumans() }})</h1>
        @if ($event->end)
        <h1>Event Ends at: {{ $event->allDay ?  $event->end->subDay()->format('M d, Y') : $event->end->format('M d, Y - g:i A')}}</h1>
        @endif
        <br>
        <a href="/" class="p-2 font-semibold text-white bg-primary-500">Back to Home</a>
    </div>
@endsection


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
        @default
    @endswitch
@endsection