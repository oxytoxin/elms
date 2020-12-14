<div class="p-5">
    <h1 class="text-2xl font-semibold">Extend Task Deadline</h1>
    <div>
        <h1>For Task: <span>{{ $task->name }}</span></h1>
        <h1>For Module: <span>{{ $task->module->name }}</span></h1>
        <h1>For Course: <span>{{ $task->course->name }}</span></h1>
        <h1>For Section: <span>{{ $task->section->code }}</span></h1>
        <h1>Task Deadline: <span>{{ $task->deadline ? $task->deadline->format('M d, Y - h:i a') :'No deadline set.' }}</span></h1>
    </div>
    <div class="mt-5">
        <label for="days" class="block text-xs font-semibold uppercase">Days to extend:</label>
        <input name="days" id="days" wire:model.lazy="days" type="number" class="text-black form-input">
        <button wire:click.prevent="extendDeadline" class="p-3 text-xs font-semibold text-white uppercase rounded-lg hover:bg-primary-600 bg-primary-500">EXTEND DEADLINE</button>
    </div>
    <div class="my-3">
        <h1 class="font-semibold">SCOPE</h1>
        <div class="flex items-center space-x-2">
            <input wire:model="scope" value="all" type="radio" name="scope" class="cursor-pointer form-radio" id="scope1"><label class="cursor-pointer" for="scope1">All students in this section</label>
        </div>
        <div class="flex items-center space-x-2">
            <input wire:model="scope" value="selected" type="radio" name="scope" class="cursor-pointer form-radio" id="scope2"><label class="cursor-pointer" for="scope2">Selected students</label>
        </div>
    </div>

    @if ($scope == 'selected')
    <div>
        <div class="flex space-x-2">
            <input wire:keydown.enter="addStudent" wire:model="email" autofocus autocomplete="off" type="text" name="student_email" id="student_email" class="flex-grow form-input" placeholder="firstname.lastname@sksu.edu.ph">
            <button wire:click.prevent="addStudent" class="p-3 text-xs font-bold text-white rounded-lg bg-primary-500 hover:bg-primary-600">ADD STUDENT</button>
        </div>
        @if(session('error'))
            <h1 class="text-sm italic font-semibold text-red-600">{{ session('error') }}</h1>
        @endif
        @if(session('message'))
            <h1 class="text-sm italic font-semibold text-green-400">{{ session('message') }}</h1>
        @endif
        <table class="table w-full mt-5 text-center border-2 divide-y-2 table-auto divide-primary-600 border-primary-600">
            <thead>
                <tr class="uppercase divide-x-2 divide-primary-600">
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-primary-600">
                @forelse ($selected_students as $selected_student)
                <tr class="divide-x-2 divide-primary-600">
                    <td class="p-2">{{ $selected_student->user->name }}</td>
                    <td>{{ $selected_student->user->email }}</td>
                </tr>
                @empty
                <tr class="divide-x-2 divide-primary-600">
                    <td colspan="2" class="p-2">No students added to selection</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif
</div>

@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection