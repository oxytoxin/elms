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
    </div>
    <div class="max-h-screen overflow-auto">
        <table id="table_id" class="inline-block m-2 text-center bg-gray-700 border-collapse table-fixed">
            <thead class="border">
                    <tr class="h-8">
                        <th class="sticky top-0 left-0 z-30 bg-green-400 border" rowspan="2">Student</th>
                        @foreach ($tasks as $type => $task)
                        <th class="sticky top-0 z-20 uppercase bg-green-400 border min-w-40" colspan="{{ $task->count() }}">{{ App\Models\TaskType::find($type)->name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($tasks as $task)
                            @foreach ($task as $k => $t)
                            <td data-column="{{ $k}}" class="sticky z-20 bg-green-400 border cursor-pointer top-8 score hover:bg-green-400"><a title="{{ $t->name }}" class="w-full" href="{{ route('teacher.task',['task' => $t->id]) }}"><h1>{{ $k+1 }}</h1></a></td>
                            @endforeach

                        @endforeach
                    </tr>
            </thead>
                <tbody>

                    @forelse ($students->sortBy('user.name') as $student)
                    <tr class="z-20 bg-white hover:bg-primary-500">
                        <th scope="row" class="z-10 sticky bg-white name-header max-w-32 md:max-w-96 md:break-normal truncate {{ "row$student->id" }} left-0 px-3 whitespace-no-wrap border cursor-pointer hover:bg-primary-500">{{ $student->user->name }}</th>
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

@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection