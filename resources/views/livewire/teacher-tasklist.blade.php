<div>
    <div>
        <h2 class="text-2xl font-semibold leading-tight uppercase">Task Submissions</h2>
        <div class="flex flex-col my-5 md:flex-row md:justify-between">
            <div class="space-y-2">
                <h1><span class="font-semibold">COURSE: </span>{{ $task->course->name }}</h1>
                <h1><span class="font-semibold">DEADLINE: </span>{{ $task->deadline ? $task->deadline->format('M d, Y - h:i a') : 'No Deadline' }}</h1>
                @if (!$task->open)
                <h1><span class="font-semibold">TASK OPENS ON: </span>{{ $task->open_on ? $task->open_on->format('M d, Y - h:i a') : '' }}</h1>
                @endif
                <h1><span class="font-semibold">Perfect Score: </span>{{ $task->max_score }}</h1>
                <a href="{{ route('teacher.task_preview',['task' => $task->id]) }}" class="inline-block p-2 text-xs font-semibold text-white bg-primary-500 hover:bg-primary-600">PREVIEW TASK</a>
            </div>
            <div x-data="{showDeadlineExtension:@entangle('showDeadlineExtension')}" class="mt-4 space-y-2 md:text-right md:mt-0">
                <h1><span class="font-semibold">MODULE: </span>{{ $task->module->name }}</h1>
                <h1><span class="font-semibold">TASK: </span>{{ $task->name }}</h1>
                <h1 class="uppercase"><span class="font-semibold">TASK TYPE: </span>{{ $task->task_type->name }}</h1>
                <a href="{{ route('teacher.extend_deadline',['task' => $task]) }}" class="inline-block p-2 text-xs font-semibold text-white uppercase hover:bg-primary-600 bg-primary-500">EXTEND DEADLINE</a>
            </div>
        </div>
    </div>
    <div class="flex flex-col my-2 md:flex-row">
        <div class="flex flex-row mb-1 sm:mb-0">
            <div class="relative">
                <select wire:model="submissionFilter" class="block w-full h-full px-4 py-2 pr-8 leading-tight text-gray-700 bg-white border border-gray-400 rounded-r appearance-none sm:rounded-r-none sm:border-r-0 focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                    <option value="all">All</option>
                    <option value="graded">Graded</option>
                    <option value="ungraded">Ungraded</option>
                </select>
            </div>
        </div>
        <div class="relative block">
            <span class="absolute inset-y-0 left-0 flex items-center h-full pl-2">
                <svg viewBox="0 0 24 24" class="w-4 h-4 text-gray-500 fill-current">
                    <path d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                    </path>
                </svg>
            </span>
            <input wire:model="search" placeholder="Search" class="block w-full py-2 pl-8 pr-6 text-sm text-gray-700 placeholder-gray-400 bg-white border border-b border-gray-400 rounded-l rounded-r appearance-none sm:rounded-l-none focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
        </div>
    </div>
    <div class="px-4 py-4 -mx-4 overflow-x-auto sm:-mx-8 sm:px-8">
        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            Student
                        </th>
                        <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            Department
                        </th>
                        <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            Date Submitted
                        </th>
                        <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            Status
                        </th>
                        <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students->sortBy('name') as $key => $student)
                    <tr>
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10">
                                    <img class="w-full h-full rounded-full" src="{{ $student->user->profile_photo_url }}" alt="student_img" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 whitespace-nowrap">
                                        {{ $student->name }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                            <p class="text-gray-900">{{ $student->department ? $student->department->name : 'N/A' }}</p>
                        </td>
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                            <p class="text-gray-900 whitespace-nowrap">
                                {{ $student->pivot->date_submitted->format('M d, Y-h:i a') }}
                            </p>
                        </td>
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900">
                                <span aria-hidden class="absolute inset-0 {{ $student->pivot->isGraded ?  'bg-green-200' : 'bg-yellow-300'}} rounded-full opacity-50"></span>
                                <span class="relative">{{ $student->pivot->isGraded ? 'Graded' : 'Ungraded' }}</span>
                            </span>
                        </td>
                        <td class="px-5 py-5 space-y-2 text-sm bg-white border-b border-gray-200">
                            @if (!$student->pivot->isGraded)
                            <button class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900 hover:bg-primary-500">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50"></span>
                                <a href="{{ route('teacher.grade_task',['task' => $student->pivot->task_id, 'student' => $student->id]) }}"><span class="relative"><i class="mr-2 icofont-check-circled"></i>Grade</span></a>
                            </button>
                            @else
                            <h1 class="flex items-center"><span class="mr-2">Score:</span><span class="text-xl font-semibold">{{ $student->pivot->score }}</span></h1>
                            <button class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900 hover:bg-primary-500">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50"></span>
                                <a href="{{ route('preview-submission',['submission' => $student->pivot->id]) }}"><span class="relative text-xs">Preview Submission</a>
                            </button>
                            <button class="relative inline-block px-3 py-1 font-semibold leading-tight text-green-900 hover:bg-primary-500">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50"></span>
                                <a href="{{ route('teacher.grade_task',['task' => $student->pivot->task_id, 'student' => $student->id]) }}"><span class="relative"><i class="mr-2 icofont-check-circled"></i>Grade</span></a>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <td colspan="5" class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                        <div class="ml-3">
                            <p class="text-gray-900 whitespace-nowrap">
                                No submissions yet.
                            </p>
                        </div>
                    </td>
                    @endforelse
                </tbody>
            </table>
            <div class="p-2">{{ $students->links() }}</div>

        </div>
    </div>
</div>

@section('sidebar')
@include('includes.teacher.sidebar')
@endsection
