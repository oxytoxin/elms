<div class="p-3 m-5 shadow-lg">
    <h1 class="mt-3 text-lg font-semibold">ADD SECTION <i wire:loading class="fa fa-spin fa-spinner"></i></h1>
    <div class="italic text-green-400">
        @if(session('message'))
        {{ session('message') }}
        @endif
    </div>
    <div class="mt-3">
        <form wire:submit.prevent="addSection" class="px-2">
            <div class="flex flex-col flex-wrap w-full md:flex-row">
                <div class="flex-1 px-2">
                    <label for="section_code">Section Code</label>
                    <input wire:model.defer="section_code" name="section_code" type="text" placeholder="AA-1A"
                        autocomplete="off" class="w-full form-input">
                    @error('section_code')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
                <div class="flex-1 px-2">
                    <label for="course_select">Course</label>
                    <select wire:model="course_select" name="course_select" class="w-full truncate form-select" id="course_select">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                            <option value="null" selected disabled hidden>Select a course</option>
                    </select>
                    @error('course_select')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
            </div>
            <div class="flex flex-col flex-wrap w-full mt-2 md:flex-row">
                <div class="flex-1 px-2">
                    <label class="block" for="faculty_select">Faculty Member</label>
                    <select wire:model="faculty_select" name="faculty_select" class="w-full truncate form-select" id="faculty_select">
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                            @endforeach
                            <option value="null" selected disabled hidden>Select a faculty member</option>
                    </select>
                    @error('faculty_select')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
                <div class="flex-1 px-2">
                    <label for="schedule">Schedule</label>
                    <input wire:model.defer="schedule" name="schedule" type="text" placeholder="MWF 09 AM - 12 PM"
                        autocomplete="off" class="w-full form-input">
                    @error('schedule')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
            </div>
            <div class="flex flex-col flex-wrap w-full mt-2 md:flex-row">
                <div class="w-1/2 px-2">
                    <label for="room">Room</label>
                    <input wire:model.defer="room" name="room" type="text" placeholder="ABC Bldg. Rm. 1B"
                        autocomplete="off" class="w-full form-input">
                    @error('room')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
            </div>

            <div class="px-2">
                <button type="submit"
                    class="p-3 mt-2 font-semibold text-white rounded-lg hover:text-primary-600 focus:outline-none bg-primary-500">ADD
                    SECTION</button>
            </div>
        </form>
    </div>
</div>

@section('sidebar')
    @include('includes.head.sidebar')
@endsection