<div>
    <x-flash-notification />
    <h1 class="text-2xl font-semibold uppercase">MY {{ $task_type->plural_name }}</h1>
    <div class="flex items-center mt-5 space-x-2 text-xl">
        <div wire:click="displayGrid" class="px-1 {{ $display_grid ? 'bg-gray-500' : '' }} bg-gray-300 rounded cursor-pointer hover:bg-gray-400">
            <i class="fas fa-th"></i>
        </div>
        <div wire:click="displayList" class="px-1 {{ $display_grid ?: 'bg-gray-500' }}  bg-gray-300 rounded cursor-pointer hover:bg-gray-400">
            <i class="icofont-listing-box"></i>
        </div>
        <div class="space-x-2 text-sm">
            <span class="font-semibold">FILTER:</span>
            <span wire:click="noFilter" class="px-2 font-semibold {{ $filter == 'all' ? 'bg-green-500' : 'bg-green-300' }} rounded-lg cursor-pointer hover:bg-green-600 hover:text-white">ALL</span>
            <span wire:click="filterWithSubmission" class="px-2 font-semibold {{ $filter == 'hasSubmission' ? 'bg-green-500' : 'bg-green-300' }} rounded-lg cursor-pointer hover:bg-green-600 hover:text-white">DONE</span>
            <span wire:click="filterWithNoSubmission" class="px-2 font-semibold {{ $filter == 'hasNoSubmission' ? 'bg-green-500' : 'bg-green-300' }} rounded-lg cursor-pointer hover:bg-green-600 hover:text-white">TODO</span>
            <span wire:click="filterPastDeadline" class="px-2 text-red-600 font-semibold {{ $filter == 'pastDeadline' ? 'bg-green-500' : 'bg-gray-300' }} rounded-lg cursor-pointer hover:bg-gray-400"><i class="mr-2 icofont-warning"></i>DUE</span>
        </div>
    </div>
    @if ($display_grid)
    <div class="grid gap-3 mt-3 auto-rows-[1fr] md:grid-cols-[repeat(auto-fill,minmax(300px,1fr))]">
        @forelse ($tasks as $task)
        <a class="flex flex-col flex-grow" href="{{ $task->student_submission ? route('preview-submission', ['submission' => $task->student_submission->pivot->id]) : route('student.task', ['task' => $task->id]) }}">
            <div class="flex flex-col h-full overflow-hidden bg-white border-4 rounded-lg hover:bg-green-300 border-primary-600">
                <div class="flex-grow flex justify-around p-3 {{ ($task->deadline && $task->deadline < now() && !auth()->user()->student->tasks->where('id', $task->id)->first()) ? 'bg-red-400' : 'bg-green-400' }}">
                    <div class="flex-shrink-0 w-16 h-16">
                        <img class="object-cover w-full h-full rounded-full" src="{{ $task->teacher->user->profile_photo_url }}" alt="teacher avatar">
                    </div>
                    <div class="space-y-1 text-sm font-semibold text-center">
                        <h1>{{ $task->name }}</h1>
                        <h1 class="text-gray-700 uppercase">{{ $task->module->course->name }} <span class="text-orange-600">[{{ $task->module->course->code }}]</span></h1>
                        <h1 class="text-xs">Module: {{ $task->module->name }}</h1>
                    </div>
                </div>
                <div class="flex justify-center p-3 text-xs font-semibold uppercase">
                    <div class="flex items-center space-x-2">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 60 60">
                            <title>calendar</title>
                            <path d="M18.75 22.5h7.5v7.5h-7.5zM30 22.5h7.5v7.5h-7.5zM41.25 22.5h7.5v7.5h-7.5zM7.5 45h7.5v7.5h-7.5zM18.75 45h7.5v7.5h-7.5zM30 45h7.5v7.5h-7.5zM18.75 33.75h7.5v7.5h-7.5zM30 33.75h7.5v7.5h-7.5zM41.25 33.75h7.5v7.5h-7.5zM7.5 33.75h7.5v7.5h-7.5zM48.75 0v3.75h-7.5v-3.75h-26.25v3.75h-7.5v-3.75h-7.5v60h56.25v-60h-7.5zM52.5 56.25h-48.75v-41.25h48.75v41.25z">
                            </path>
                        </svg>
                        <div>
                            @if ($task->students()->where('student_id', auth()->user()->student->id)->first())
                            <h1>Status: {{ $task->students()->where('student_id', auth()->user()->student->id)->first()->pivot->isGraded
                                                ? 'Graded - Score: ' .
                                                    $task->students()->where('student_id', auth()->user()->student->id)->first()->pivot->score .
                                                    '/' .
                                                    $task->max_score
                                                : 'Not Yet Graded' }}</h1>
                            @else
                            <h1>Status: Not Yet Submitted</h1>
                            @endif
                            <h1 class="text-red-600">{{ $task->deadline ? $task->deadline->format('h:i a, m/d/Y') : 'No deadline set' }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <h1>Hooray! Nothing to do here yet.</h1>
        @endforelse
    </div>
    @else
    <div class="flex flex-col mt-5 space-y-2">
        @forelse ($tasks as $task)
        <a href="{{ $task->student_submission ? route('preview-submission', ['submission' => $task->student_submission->pivot->id]) : route('student.task', ['task' => $task->id]) }}">
            <div class="flex flex-col md:flex-row justify-between p-3 hover:bg-green-400 rounded-md  {{ ($task->deadline && $task->deadline < now() && !auth()->user()->student->tasks->where('id', $task->id)->first()) ? 'bg-red-400' : 'bg-green-400' }}">
                <div class="flex items-center space-x-2">
                    <img class="w-12 h-12 rounded-full" src="{{ $task->teacher->user->profile_photo_url }}" alt="teacher avatar">
                    <div class="text-sm font-semibold">
                        <h1>{{ $task->name }}</h1>
                        <h1 class="text-gray-700 uppercase">{{ $task->module->course->name }} <span class="text-orange-600">[{{ $task->module->course->code }}]</span></h1>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 60 60">
                        <title>calendar</title>
                        <path d="M18.75 22.5h7.5v7.5h-7.5zM30 22.5h7.5v7.5h-7.5zM41.25 22.5h7.5v7.5h-7.5zM7.5 45h7.5v7.5h-7.5zM18.75 45h7.5v7.5h-7.5zM30 45h7.5v7.5h-7.5zM18.75 33.75h7.5v7.5h-7.5zM30 33.75h7.5v7.5h-7.5zM41.25 33.75h7.5v7.5h-7.5zM7.5 33.75h7.5v7.5h-7.5zM48.75 0v3.75h-7.5v-3.75h-26.25v3.75h-7.5v-3.75h-7.5v60h56.25v-60h-7.5zM52.5 56.25h-48.75v-41.25h48.75v41.25z">
                        </path>
                    </svg>
                    <div class="text-xs font-semibold uppercase">
                        @if ($task
                        ->students()
                        ->where('student_id', auth()->user()->student->id)
                        ->first())
                        <h1>Status: {{ $task->students()->where('student_id', auth()->user()->student->id)->first()->pivot->isGraded
                                    ? 'Graded - Score: ' .
                                        $task->students()->where('student_id', auth()->user()->student->id)->first()->pivot->score .
                                        '/' .
                                        $task->max_score
                                    : 'Not Yet Graded' }}</h1>
                        @else
                        <h1>Status: Not Yet Submitted</h1>
                        @endif
                        <h1 class="text-red-600">{{ $task->deadline ? $task->deadline->format('h:i a, m/d/Y') : 'No deadline set' }}</h1>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <h1>Hooray! Nothing to do here yet.</h1>
        @endforelse
    </div>
    @endif
    <div class="my-3">
        {{ $tasks->links() }}
    </div>
</div>

@section('sidebar')
@include('includes.student.sidebar')
@endsection
