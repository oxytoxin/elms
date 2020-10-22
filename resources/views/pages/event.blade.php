@extends('layouts.master')
@section('content')
    <div class="w-3/4 p-3 mx-auto my-5 shadow-lg">
        <h1 class="font-semibold">Event Details</h1>
        <hr class="border-2 border-primary-600">
        <br>
        <h1>{{ $event->title }}</h1>
        <h1>Event Description: {{ $event->title }}</h1>
        <h1>Created by: {{ $event->user->name }}</h1>
        <h1>Created at: {{ $event->created_at->format('M d, Y') }}</h1>
        <h1>Event Starts at: {{ Carbon\Carbon::parse($event->start)->format('M d, Y - g:i A') }}</h1>
        @if ($event->end)
        <h1>Event Ends at: {{ Carbon\Carbon::parse($event->start)->format('M d, Y - g:i A') }}</h1>
        @endif
    </div>
@endsection