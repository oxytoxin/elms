@extends('layouts.master')
@section('content')
<div class="m-4 px-7">
    <h1 class="text-2xl font-semibold uppercase">TASKS - {{ $task_type->name }}</h1>
    <div class="grid gap-3 mt-4 md:grid-cols-3">
    @forelse ($tasks as $task)
            <a href="{{ route('teacher.task',['task'=> $task->id]) }}">
                <div class="p-3 rounded-lg shadow-lg hover:bg-green-300 focus:outline-none bg-primary-500 min-h-24">
                    <h1>{{ $task->name }}</h1>
                    <h1 class="text-sm font-semibold text-white">{{ $task->module->course->name }} <span class="text-black">[{{ $task->module->course->code }}]</span></h1>
                    <h1 class="text-sm italic font-semibold">~{{ $task->module->name }}</h1>
                    <h1 class="text-sm font-semibold">Submissions: {{ $task->submissions }}</h1>
                    <h1 class="text-sm font-semibold">Graded: {{ $task->graded }}</h1>
                    <h1 class="text-sm font-semibold">Ungraded: {{ $task->ungraded }}</h1>
                    <h1 class="text-sm font-semibold text-red-600">Date due: {{ Carbon\Carbon::parse($task->deadline)->format('h:i a, m/d/Y') }}</h1>
                </div>
            </a>
            @empty
            <h1>Hooray! Nothing to do here yet.</h1>
            @endforelse
    </div>
</div>

@endsection
@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection