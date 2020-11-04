<div class="w-full p-3 shadow-lg">
    <h1 class="mt-3 text-lg font-semibold">CREATE COURSE <i wire:loading class="fa fa-spin fa-spinner"></i></h1>
    <div class="italic text-green-400">
        @if(session('message'))
        {{ session('message') }}
        @endif
    </div>
    <div class="mt-3">
        <form wire:submit.prevent="addCourse" class="px-2">
            <div class="flex w-full">
                <div class="flex-1 px-2">
                    <label for="course_title">Course Title</label>
                    <input wire:model.defer="course_title" name="course_title" type="text" placeholder="Enter Course Title"
                        autocomplete="off" class="w-full form-input">
                    @error('course_title')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
                <div class="flex-1 px-2">
                    <label for="course_code">Course code</label>
                    <input wire:model.defer="course_code" name="course_code" type="text" placeholder="ABC123"
                        autocomplete="off" class="w-full form-input">
                    @error('course_code')
                    <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                    @enderror
                </div>
            </div>
            <div class="px-2">
                <button type="submit"
                    class="p-3 mt-2 font-semibold text-white rounded-lg hover:text-primary-600 focus:outline-none bg-primary-500">ADD
                    COURSE</button>
            </div>
        </form>
    </div>
</div>