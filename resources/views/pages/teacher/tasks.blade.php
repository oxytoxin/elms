@extends('layouts.master')
@section('content')
<div class="m-4 px-7">
    <h1 class="text-2xl font-semibold uppercase">TASKS - {{ $task_type->name }}</h1>
    <div class="grid gap-3 mt-4 md:grid-cols-3" style="grid-auto-rows: 1fr">
    @forelse ($tasks as $task)
            <a href="{{ route('teacher.task',['task'=> $task->id]) }}">
                <div class="relative flex flex-col h-full p-3 bg-white rounded-lg shadow-lg hover:bg-green-300 focus:outline-none min-h-24">
                    <div class="flex-grow">
                        <h1>{{ $task->name }}</h1>
                        <h1 class="text-sm font-semibold text-gray-700">{{ $task->module->course->name }} <span class="text-orange-600">[{{ $task->module->course->code }}]</span></h1>
                        <h1 class="text-sm italic font-semibold">~{{ $task->module->name }}</h1>
                        <h1 class="text-sm font-semibold">Submissions: {{ $task->submissions }}</h1>
                        <h1 class="text-sm font-semibold">Graded: {{ $task->graded }}</h1>
                        <h1 class="text-sm font-semibold">Ungraded: {{ $task->ungraded }}</h1>
                        <h1 class="mb-6 text-sm font-semibold">Section: {{ $task->section->code }}</h1>
                    </div>
                    <h1 class="text-sm font-semibold text-red-600">Date due: {{ $task->deadline->format('h:i a, m/d/Y') }}</h1>
                </div>
            </a>
            @empty
            <h1>Hooray! Nothing to do here yet.</h1>
            @endforelse
    </div>
    <div class="my-3">
        {{ $tasks->links() }}
    </div>
</div>

@endsection
@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection