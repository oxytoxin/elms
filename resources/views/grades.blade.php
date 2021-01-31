<div id="table-container" class="overflow-auto text-gray-700" style="max-height:75vh;">
    <table id="table_id" class="inline-block w-0 m-2 text-sm text-center border-collapse table-fixed">
        <thead class="text-black border">
            <tr class="h-8">
                <th class="sticky top-0 left-0 z-30 border bg-gradient-to-b from-green-400 to-green-400" rowspan="2">Student</th>
                @foreach ($task_types as $type)
                <th wire:key="type-header-{{ $type->name }}" class="sticky top-0 z-20 uppercase border bg-gradient-to-b from-green-400 to-green-400 min-w-40" colspan="{{ $type->task_count+2 }}">{{ $type->name }}</th>
                @endforeach
                <th class="sticky top-0 z-20 uppercase border bg-gradient-to-b from-green-400 to-green-400 min-w-40" colspan="2">ATTENDANCE</th>
                <th class="sticky top-0 z-20 uppercase border bg-gradient-to-b from-green-400 to-green-400 min-w-20" rowspan="2">% TOTAL</th>
                <th class="sticky top-0 z-20 uppercase border bg-gradient-to-b from-green-400 to-green-400 min-w-20" rowspan="2">GRADE</th>
            </tr>
            <tr>
                @foreach ($tasks as $task)
                @foreach ($task as $k => $t)
                <td wire:key="item-header-{{ $t->id }}" class="sticky z-20 border cursor-pointer bg-gradient-to-b from-green-400 to-green-400 top-8 score">
                    <h1>{{ $k + 1 }}</h1>
                    <h1 class="whitespace-no-wrap">({{ $t->max_score }}) pts.</h1>
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
                    <h1>({{ $section->total_days }})
                </td>
                <td class="sticky z-20 border cursor-pointer bg-gradient-to-b from-green-400 to-green-400 top-8 score hover:text-white">
                    <h1 class="text-sm">% score</h1>
                </td>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
            <tr wire:key="student-row-{{ $student->id }}" class="z-20 bg-white bg-gradient-to-b hover:from-green-400 to-green-400">
                <th scope="row" class="z-10 sticky bg-white name-header max-w-32 md:max-w-96 md:break-normal truncate {{ "row$student->id" }} left-0 px-3 whitespace-no-wrap border cursor-pointer bg-gradient-to-b hover:from-green-400 to-green-500">
                    {{ $student->name }}
                </th>
                @php
                $totalScore = 0;
                @endphp
                @foreach ($student->allTasks($section, $tasks) as $index=>$student_task_type)
                @foreach ($student_task_type as $student_task)
                <td class="p-2 border {{ "row$student->id" }}">
                    @if (is_subclass_of($student_task, 'Illuminate\Database\Eloquent\Model'))
                    @if ($student_task->pivot->isGraded)
                    {{ $student_task->pivot->score }}
                    @else
                    0
                    @endif
                    @else
                    0
                    @endif
                </td>
                @endforeach
                <td class="p-2 border {{ "row$student->id" }}">
                    {{ $student_task_type->sum('pivot.score') }}
                </td>
                <td class="p-2 border {{ "row$student->id" }}">
                    {{ round($student_task_type->sum('pivot.score')/$tasks[$index]->sum('max_score')  * $grading_system->getWeightValue($index) , 2) }}
                </td>
                @php
                $totalScore += round($student_task_type->sum('pivot.score')/$tasks[$index]->sum('max_score') * $grading_system->getWeightValue($index) , 2);
                @endphp
                @endforeach
                <td class="p-2 border flex items-center justify-center space-x-2 {{ "row$student->id" }}">
                    <span>{{ $student->pivot->days_present }}</span>
                </td>
                <td class="p-2 border {{ "row$student->id" }}">
                    {{ round($student->pivot->days_present / $section->total_days *  $grading_system->attendance_weight,2) }}
                </td>
                <td class="p-2 border {{ "row$student->id" }}">
                    {{ round($totalScore + $student->pivot->days_present / $section->total_days *  $grading_system->attendance_weight,2) }}
                </td>
                <td class="p-2 border {{ "row$student->id" }}">
                    {{ $grading_system->getGradeValue($totalScore + $student->pivot->days_present / $section->total_days *  $grading_system->attendance_weight )}}
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
