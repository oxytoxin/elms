<div class="z-20 px-4">
    <div class="m-2">
        <h1 class="text-2xl font-semibold">Gradebook</h1>
        <div>
            <h1 class="text-xl font-semibold">For Course:</h1>
            <i class="mr-4 text-xl fas fa-spin fa-spinner text-primary-600" wire:loading></i><select wire:change="updateCourse" wire:model="course_id" class="truncate form-select" name="course_select" id="course_select">
                @forelse ($courses as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
                @empty
                <option value="0" selected disabled hidden>No Courses Found.</option>
                @endforelse
            </select>
            <button onclick="clearSelections()" class="p-3 text-xs font-bold text-white uppercase rounded-lg hover:bg-primary-600 bg-primary-500">Clear highlighted</button>
        </div>
        <div class="flex flex-col items-center justify-center mt-3 md:flex-row">
            <div class="mx-5">
                <h1 class="flex items-center text-sm font-semibold"><i class="mr-2 text-lg text-yellow-300 icofont-question-circle"></i>Submitted but not yet graded</h1>
            </div>
            <div class="mx-5">
                <h1 class="flex items-center text-sm font-semibold"><i class="mr-2 text-lg text-red-600 icofont-exclamation-circle"></i>Not submitted</h1>
            </div>
        </div>
    </div>
    <div class="max-h-screen overflow-auto text-gray-700">
        <table id="table_id" class="inline-block m-2 text-center bg-gray-800 border-collapse table-fixed">
            <thead class="border">
                    <tr class="h-8">
                        <th class="sticky top-0 left-0 z-30 border bg-gradient-to-b from-green-400 to-green-500" rowspan="2">Student</th>
                        @foreach ($tasks as $type => $task)
                        <th class="sticky top-0 z-20 uppercase border bg-gradient-to-b from-green-400 to-green-500 min-w-40" colspan="{{ $task->count() }}">{{ App\Models\TaskType::find($type)->name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($tasks as $task)
                            @foreach ($task as $k => $t)
                            <td data-column="{{ $k}}" class="sticky z-20 border cursor-pointer bg-gradient-to-b from-green-400 to-green-500 top-8 score hover:text-white"><a title="{{ $t->name }}" class="w-full" href="{{ route('teacher.task',['task' => $t->id]) }}"><h1>{{ $k+1 }}</h1></a></td>
                            @endforeach

                        @endforeach
                    </tr>
            </thead>
                <tbody>

                    @forelse ($students->sortBy('user.name') as $student)
                    <tr class="z-20 bg-white bg-gradient-to-b hover:from-green-400 to-green-500">
                        <th scope="row" class="z-10 sticky bg-white name-header max-w-32 md:max-w-96 md:break-normal truncate {{ "row$student->id" }} left-0 px-3 whitespace-no-wrap border cursor-pointer bg-gradient-to-b hover:from-green-400 to-green-500">{{ $student->user->name }}</th>
                        @foreach ($tasks as $task)
                        @foreach ($task as $k => $t)
                        <td class="px-8 py-4 border {{ "row$student->id" }}">
                            @if ($student->task_status($t->id) == 'ungraded')
                            <i class="text-xl text-yellow-300 icofont-question-circle"></i>
                            @else
                                @if ($student->task_status($t->id))
                                {{ $student->task_status($t->id) }}
                                @else
                                <i class="text-xl text-red-600 icofont-exclamation-circle"></i>
                                @endif
                            @endif
                        </td>
                        @endforeach
                    @endforeach
                    </tr>
                    @empty

                    @endforelse
                </tbody>
        </table>
</div>
</div>

@push('scripts')
    <script>
            function clearSelections() {
                document.querySelectorAll('.selected-row').forEach(e=>{
                    e.classList.remove('selected-row');
                })
            }
            document.querySelectorAll(".name-header").forEach(e=>{
                 e.addEventListener('click',l=>{
                     clearSelections();
                    l.target.parentElement.classList.add('selected-row')
                    e.classList.add('selected-row')
                 })

            })
    </script>
@endpush

@push('metas')
    <meta name="turbolinks-cache-control" content="no-cache">
@endpush

@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection