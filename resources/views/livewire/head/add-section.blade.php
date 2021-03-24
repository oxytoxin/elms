<div class="p-3 m-5 shadow-lg" x-data="{showQuery : @entangle('showQuery')}">
    <h1 class="mt-3 text-lg font-semibold">ADD SECTION <i wire:loading class="fa fa-spin fa-spinner"></i></h1>
    <div class="italic text-green-400">
        @if(session('message'))
        {{ session('message') }}
        @endif
    </div>
    <div class="mt-3">
        <form wire:submit.prevent="addSection">
            <div class="flex flex-col flex-wrap w-full space-x-2 md:flex-row">
                <div class="flex-1">
                    <label for="section_code">Section Code</label>
                    <input wire:model.defer="section_code" name="section_code" type="text" placeholder="AA-1A" autocomplete="off" class="w-full form-input">
                    @error('section_code')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
                <div class="relative flex-1">
                    <div class="flex flex-col">
                        <label for="course_query">Course</label>
                        <input type="text" placeholder="CC112" name="course_query" wire:model="course_query" id="course_query" class="flex-grow min-w-80 form-input">
                    </div>
                    <div x-cloak x-show="showQuery" class="absolute w-full overflow-y-auto bg-white border divide-y-2 shadow top-[20] max-h-48">
                        @foreach ($courses as $course)
                        <div wire:click="setCourse({{ $course->id }},'{{ $course->name }}')" wire:key="course-item-{{ $course->id }}" class="flex flex-col justify-between px-4 py-2 cursor-pointer md:flex-row">
                            <h1>{{ $course->code }}</h1>
                            <h1>{{ $course->name }}</h1>
                        </div>
                        @endforeach
                    </div>
                    @error('course_select')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
            </div>
            <div class="flex flex-col flex-wrap w-full mt-2 space-x-2 md:flex-row">
                <div class="flex-1">
                    <label class="block" for="department_id">Department</label>
                    <select wire:model="department_id" name="department_id" class="w-full truncate form-select" id="department_id">
                        <option value="" selected disabled>Select a Department</option>
                        @foreach (auth()->user()->program_head->departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
                <div class="flex-1">
                    <label class="block" for="faculty_select">Faculty Member</label>
                    <select wire:model="faculty_select" name="faculty_select" class="w-full truncate form-select" id="faculty_select">
                        <option value="" selected disabled>Select a faculty member</option>
                        @forelse ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                        @empty
                        <option value="" selected disabled>Please select a department.</option>
                        @endforelse
                    </select>
                    @error('faculty_select')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
            </div>
            <div class="flex flex-col flex-wrap w-full mt-2 space-x-2 md:flex-row">
                <div class="flex-1">
                    <label for="room">Room</label>
                    <input wire:model.defer="room" name="room" type="text" placeholder="ABC Bldg. Rm. 1B" autocomplete="off" class="w-full form-input">
                    @error('room')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
                <div class="flex-1">
                    <label for="schedule">Schedule</label>
                    <input wire:model.defer="schedule" name="schedule" type="text" placeholder="MWF 09 AM - 12 PM" autocomplete="off" class="w-full form-input">
                    @error('schedule')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" class="p-3 mt-2 font-semibold text-white rounded-lg hover:text-primary-600 focus:outline-none bg-primary-500">ADD
                    SECTION</button>
            </div>
        </form>
    </div>
</div>

@section('sidebar')
@include('includes.head.sidebar')
@endsection
