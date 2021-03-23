<div class="w-full p-3 shadow-lg">
    <h1 class="mt-3 text-lg font-semibold">CREATE COURSE <i wire:loading class="fa fa-spin fa-spinner"></i></h1>
    <div class="italic text-green-400">
        @if(session('message'))
        {{ session('message') }}
        @endif
    </div>
    <div class="mt-3">
        <form wire:submit.prevent="addCourse" class="px-2">
            <div class="flex flex-wrap w-full">
                <div class="flex-1 px-2">
                    <label for="course_title">Course Title</label>
                    <input wire:model.defer="course_title" name="course_title" type="text" placeholder="Enter Course Title" autocomplete="off" class="w-full form-input">
                    @error('course_title')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
                <div class="flex-1 px-2">
                    <label for="course_code">Course code</label>
                    <input wire:model.defer="course_code" name="course_code" type="text" placeholder="ABC123" autocomplete="off" class="w-full form-input">
                    @error('course_code')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
                <div class="flex-1 px-2">
                    <label for="course_code">Course units</label>
                    <input wire:model.defer="course_units" name="course_code" type="text" placeholder="3.00" autocomplete="off" class="w-full form-input">
                    @error('course_units')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
            </div>
            <div class="px-2">
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
            <div class="px-2">
                <button type="submit" class="p-3 mt-2 font-semibold text-white rounded-lg hover:text-primary-600 focus:outline-none bg-primary-500">ADD
                    COURSE</button>
            </div>
        </form>
    </div>
</div>
