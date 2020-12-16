@extends('layouts.master')
@section('content')
<div class="px-5 m-4">
    <h1 class="text-2xl font-semibold uppercase">TASKS - {{ $task_type->name }}</h1>
    <div class="grid gap-3 mt-4 md:grid-cols-3" style="grid-auto-rows: 1fr">
        @forelse ($tasks as $task)
            <a href="{{ $task->students()->where('student_id',auth()->user()->student->id)->first() ? route('preview-submission',['submission' => $task->students()->where('student_id',auth()->user()->student->id)->first()->pivot->id]) : route('student.task',['task'=> $task->id])  }}">
                <div class="relative flex flex-col h-full p-3 text-center {{ $task->deadline && now() > $task->deadline ? 'bg-red-400 bg-opacity-50' : 'bg-white' }} rounded-lg shadow-lg hover:bg-green-300 focus:outline-none min-h-24">
                    <div class="flex-grow">
                        <h1>{{ $task->name }}</h1>
                        <h1 class="text-sm font-semibold text-gray-700">{{ $task->module->course->name }} <span class="text-orange-600">[{{ $task->module->course->code }}]</span></h1>
                        <h1 class="text-sm italic font-semibold">Module: {{ $task->module->name }}</h1>
                        <hr class="border-t-2 border-primary-600">
                        <h1 class="mb-6 text-sm font-semibold">Teacher: {{ $task->teacher->user->name }}</h1>
                    </div>
                    @if ($task->students()->where('student_id',auth()->user()->student->id)->first())
                    <h1 class="text-sm font-semibold">Status: {{ $task->students()->where('student_id',auth()->user()->student->id)->first()->pivot->isGraded ? "Graded - Score: ". $task->students()->where('student_id',auth()->user()->student->id)->first()->pivot->score ."/".$task->max_score : "Not Yet Graded" }}</h1>
                    @else
                    <h1 class="text-sm font-semibold">Status: Not Yet Submitted</h1>
                    @endif
                    <h1 class="text-sm font-semibold text-red-600">Date due: {{ $task->deadline ? $task->deadline->format('h:i a, m/d/Y') : 'No deadline set' }}</h1>
                </div>
            </a>
            @empty
            <h1>Hooray! Nothing to do here yet.</h1>
            @endforelse
    </div>
</div>

@endsection
@section('sidebar')
    @include('includes.student.sidebar')
@endsection