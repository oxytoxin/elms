<div class="z-20 w-full" x-data="{ showGradingSystem : false, readWeights : @entangle('readWeights'), showEditDays : @entangle('showEditDays') }">
    <div x-show.transition="showEditDays" x-cloak class="fixed inset-0 z-50 grid bg-gray-500 bg-opacity-50 place-items-center">
        <div @click.away="showEditDays = false" class="p-5 bg-white rounded-lg shadow-lg ">
            <h1 class="mb-2 text-center">{{ $editing }}</h1>
            <div class="flex items-center space-x-2">
                <input wire:model.lazy="editValue" class="form-input" type="number">
                <button wire:click="saveDays" class="p-2 font-semibold text-white hover:text-primary-600 bg-primary-500">SAVE</button>
            </div>
            <div>
                @error('editValue')
                <h1 class="text-xs font-semibold text-red-600">{{ $message }}</h1>
                @enderror
            </div>
        </div>
    </div>
    <div>
        <h1 class="text-2xl font-semibold">GRADEBOOK <i class="mr-4 text-xl fas fa-spin fa-spinner text-primary-600" wire:loading></i></h1>
        <div class="mt-5">
            <div class="grid gap-2 mb-3 md:grid-cols-5">
                <div class="md:col-span-3">
                    <h1 class="text-xl font-semibold">For Course:</h1>
                    <select wire:change="updateCourse" wire:model="course_id" class="w-full truncate form-select" name="course_select" id="course_select">
                        @forelse ($courses as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @empty
                        <option value="0" selected disabled hidden>No Courses Found.</option>
                        @endforelse
                    </select>
                </div>
                <div class="md:col-span-1">
                    <h1 class="text-xl font-semibold">For Section:</h1>
                    <select wire:change="updateSection" wire:model="section_id" class="w-full truncate form-select" name="course_select" id="course_select">
                        @forelse ($course->sections as $course_section)
                        <option value="{{ $course_section->id }}">{{ $course_section->code }}</option>
                        @empty
                        <option value="0" selected disabled hidden>No Courses Found.</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <button onclick="clearSelections()" class="p-3 text-xs font-bold text-white uppercase rounded-lg md:col-span-1 hover:bg-primary-600 bg-primary-500">Clear
                highlighted</button>
        </div>
        <div class="flex flex-col items-center justify-center my-3 md:flex-row">
            <div class="mx-5">
                <h1 class="flex items-center text-sm font-semibold"><i class="mr-2 text-lg text-yellow-300 icofont-question-circle"></i>Submitted but not yet
                    graded</h1>
            </div>
            <div class="mx-5">
                <h1 class="flex items-center text-sm font-semibold"><i class="mr-2 text-lg text-red-600 icofont-exclamation-circle"></i>Not submitted</h1>
            </div>
            <div class="mx-5">
                <button wire:click="export" class="p-2 text-sm font-semibold text-white bg-primary-500 hover:text-primary-600">Export to Excel</button>
            </div>
        </div>
        <div class="text-center">
            <button @click="showGradingSystem = true" x-show="!showGradingSystem" class="underline">Show Grading System</button>
            <button x-cloak @click="showGradingSystem = false" x-show="showGradingSystem" class="underline">Hide Grading System</button>
        </div>
        <div x-cloak x-show.transition="showGradingSystem" class="p-5 mx-auto my-5 border shadow-lg md:w-3/4">
            <h1 class="font-semibold text-center uppercase">Grading System</h1>
            <form wire:submit.prevent="saveWeights">
                <div class="grid gap-2 my-3 text-xs md:grid-cols-2 gap-x-10">
                    @foreach ($task_types as $t_type)
                    <div class="relative flex items-center justify-center space-x-3">
                        <label for="{{ $t_type->plural_name }}" class="w-1/2 uppercase">{{ $t_type->plural_name }}</label>
                        <input :readonly="readWeights" wire:model.defer="grading_system.{{ $t_type->name }}_weight" name="{{ $t_type->plural_name }}" type="number" id="{{ $t_type->plural_name }}" class="w-1/2 text-xs form-input">
                        <i class="absolute fas fa-percent top-3 right-2 "></i>
                    </div>
                    @endforeach
                    <div class="relative flex items-center justify-center space-x-3">
                        <label for="attendance" class="w-1/2 uppercase">attendance</label>
                        <input :readonly="readWeights" wire:model.defer="grading_system.attendance_weight" name="attendance" type="number" id="attendance" class="w-1/2 text-xs form-input">
                        <i class="absolute top-3 right-2 fas fa-percent"></i>
                    </div>
                    @if ($readWeights)
                    <button wire:click="$set('readWeights',false)" type="button" class="p-2 px-10 text-sm font-semibold text-white hover:text-primary-600 bg-primary-500">EDIT VALUES</button>
                    @else
                    <div class="flex">
                        <button type="submit" class="flex-1 p-2 text-sm font-semibold text-white hover:text-primary-600 bg-primary-500">SAVE</button>
                        <button type="button" wire:click="cancelEdit" class="flex-1 p-2 text-sm font-semibold text-white bg-red-600 hover:text-red-800">CANCEL</button>
                    </div>
                    @endif
                    <div>
                        @error('grading_system.*')
                        <h1 class="text-red-600">{{ $message }}</h1>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if ($tasks->count())
    <div x-ref="tablecontainer" id="table-container" class="overflow-auto lg:w-[60vw] mx-auto text-gray-700 max-h-[75vh]">
        <table id="table_id" class="inline-block text-sm text-center border-collapse table-fixed">
            <thead class="text-black border">
                <tr class="h-8">
                    <th class="sticky top-0 left-0 z-30 border bg-gradient-to-b from-green-400 to-green-400" rowspan="2">Student</th>
                    @foreach ($task_types as $type)
                    @if (in_array($type->id, $tasks->keys()->all()))
                    <th wire:key="type-header-{{ $type->name }}" class="sticky top-0 z-20 uppercase border bg-gradient-to-b from-green-400 to-green-400 min-w-40" colspan="{{ $tasks[$type->id]->count() +2 }}">{{ $type->name }} ({{ $weights[$type->name] }} %)</th>
                    @endif
                    @endforeach
                    <th class="sticky top-0 z-20 uppercase border bg-gradient-to-b from-green-400 to-green-400 min-w-40" colspan="2">ATTENDANCE ({{ $weights['attendance'] }} %)</th>
                    <th class="sticky top-0 z-20 uppercase border bg-gradient-to-b from-green-400 to-green-400 min-w-20" rowspan="2">% TOTAL</th>
                    <th class="sticky top-0 z-20 uppercase border bg-gradient-to-b from-green-400 to-green-400 min-w-20" rowspan="2">GRADE</th>
                </tr>
                <tr>
                    @foreach ($tasks as $task)
                    @foreach ($task as $k => $t)
                    <td wire:key="item-header-{{ $t->id }}" class="sticky z-20 px-2 text-xs border cursor-pointer bg-gradient-to-b from-green-400 to-green-400 top-8 score">
                        <a title="{{ $t->name }}" class="w-full hover:text-white" href="{{ route('teacher.task', ['task' => $t->id]) }}">
                            <h1>{{ $k + 1 }}</h1>
                        </a>
                        <h1 class="whitespace-nowrap">({{ $t->max_score }}) pts.</h1>
                    </td>
                    @endforeach
                    <td class="sticky z-20 border cursor-pointer bg-gradient-to-b from-green-400 to-green-400 top-8 score hover:text-white">
                        <h1 class="text-sm">sub total</h1>
                    </td>
                    <td class="sticky z-20 border cursor-pointer bg-gradient-to-b from-green-400 to-green-400 top-8 score hover:text-white">
                        <h1 class="text-sm">% score</h1>
                    </td>
                    @endforeach
                    <td class="sticky z-20 p-2 border cursor-pointer bg-gradient-to-b from-green-400 to-green-400 top-8 score">
                        <h1 class="text-xs">DAYS PRESENT</h1>
                        <h1>({{ $section->total_days }}) <button wire:click="editDays('Total Days', {{ $section->total_days }})" class="underline hover:text-white">Edit</button></h1>
                    </td>
                    <td class="sticky z-20 border cursor-pointer bg-gradient-to-b from-green-400 to-green-400 top-8 score hover:text-white">
                        <h1 class="text-sm">% score</h1>
                    </td>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                <tr wire:key="student-row-{{ $student->id }}" class="z-20 bg-white bg-gradient-to-b hover:from-green-400 to-green-400">
                    <th scope="row" class="z-10 sticky bg-white name-header max-w-32 md:max-w-96 md:break-normal truncate {{ "row$student->id" }} left-0 px-3 whitespace-nowrap border cursor-pointer bg-gradient-to-b hover:from-green-400 to-green-500">
                        {{ $student->name }}
                    </th>
                    @php
                    $totalScore = 0;
                    @endphp
                    @foreach ($student->allTasks($section, $tasks) as $index=>$student_task_type)
                    @foreach ($student_task_type as $student_task)
                    <input type="hidden" class="bg-red-200 bg-orange-200 bg-yellow-200 bg-indigo-200 bg-pink-200" />
                    <td class="p-2 border {{ $colors[$index] }} {{ "row$student->id" }}">
                        @if (is_subclass_of($student_task, 'Illuminate\Database\Eloquent\Model'))
                        @if ($student_task->pivot->isGraded)
                        {{ $student_task->pivot->score }}
                        @else
                        <i class="text-yellow-300 icofont-question-circle"></i>
                        @endif
                        @else
                        <i class="text-red-600 icofont-exclamation-circle"></i>
                        @endif
                    </td>
                    @endforeach
                    <td class="p-2 border {{ "row$student->id" }}">
                        {{ $student_task_type->sum('pivot.score') }}
                    </td>
                    <td class="p-2 border {{ "row$student->id" }}">
                        {{ $grading_system->getWeightValue($index) ? round($student_task_type->sum('pivot.score')/$tasks[$index]->sum('max_score')  * $grading_system->getWeightValue($index) , 2) : 'N/A'}}
                    </td>
                    @php
                    if($grading_system->getWeightValue($index))
                    $totalScore += round($student_task_type->sum('pivot.score')/$tasks[$index]->sum('max_score') * $grading_system->getWeightValue($index) , 2);
                    @endphp
                    @endforeach
                    <td class="p-2 border flex items-center justify-center space-x-2 {{ "row$student->id" }}">
                        <span>{{ $student->pivot->days_present }}</span> <button wire:click="editDays('Days Present for {{ $student->name }}', {{ $student->id }})" class="text-xs underline hover:text-white">Edit</button>
                    </td>
                    <td class="p-2 border {{ "row$student->id" }}">
                        {{ $grading_system->attendance_weight ? round($student->pivot->days_present / $section->total_days *  $grading_system->attendance_weight,2) : 'N/A'}}
                    </td>
                    <td class="p-2 border {{ "row$student->id" }}">
                        {{ $grading_system->attendance_weight ? round($totalScore + $student->pivot->days_present / $section->total_days *  $grading_system->attendance_weight,2) : 'N/A'}}
                    </td>
                    <td class="p-2 border {{ "row$student->id" }}">
                        {{ $grading_system->attendance_weight ? $grading_system->getGradeValue($totalScore + $student->pivot->days_present / $section->total_days *  $grading_system->attendance_weight ) : 'N/A'}}
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    @else
    <h1 class="text-xl font-semibold text-center">No tasks assigned in this section.</h1>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', () => {
        const ele = document.getElementById('table-container');
        let pos = {
            top: 0
            , left: 0
            , x: 0
            , y: 0
        };
        const mouseDownHandler = function(e) {
            ele.style.cursor = 'grabbing';
            ele.style.userSelect = 'none';
            document.addEventListener('mousemove', mouseMoveHandler);
            document.addEventListener('mouseup', mouseUpHandler);
            pos = {
                // The current scroll
                left: ele.scrollLeft
                , top: ele.scrollTop,
                // Get the current mouse position
                x: e.clientX
                , y: e.clientY
            , };
        }
        const mouseUpHandler = function() {
            ele.style.cursor = 'grab';
            ele.style.removeProperty('user-select');
            document.removeEventListener('mousemove', mouseMoveHandler);
            document.removeEventListener('mouseup', mouseUpHandler);
        };
        const mouseMoveHandler = function(e) {
            // How far the mouse has been moved
            const dx = e.clientX - pos.x;
            const dy = e.clientY - pos.y;

            // Scroll the element
            ele.scrollTop = pos.top - dy;
            ele.scrollLeft = pos.left - dx;
        };

        ele.addEventListener('mousedown', mouseDownHandler);

    });

    function clearSelections() {
        document.querySelectorAll('.selected-row').forEach(e => {
            e.classList.remove('selected-row');
        })
    }
    document.querySelectorAll(".name-header").forEach(e => {
        e.addEventListener('click', l => {
            clearSelections();
            l.target.parentElement.classList.add('selected-row')
            e.classList.add('selected-row')
        })
    });

</script>
@endpush

@push('styles')
<style>
    #table-container {
        cursor: grab;
        overflow: auto;
    }

</style>
@endpush

@section('sidebar')
@include('includes.teacher.sidebar')
@endsection
