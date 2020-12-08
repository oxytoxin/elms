<div class="w-full" x-data="{ showEditCourse:@entangle('showEditCourse')}">
    <h1 class="mt-5 mb-2 text-xl font-semibold">{{ $course->name }} <i class="ml-5 cursor-pointer icofont-edit"
            wire:click="$set('showEditCourse',true)"></i><i
            onclick="confirm('Confirm delete?') || event.stopImmediatePropagation()" wire:click.prevent="deleteCourse"
            class="ml-5 text-red-600 cursor-pointer icofont-trash"></i><i wire:loading wire:target="enrolFaculty"
            class="fa fa-spinner fa-spin"></i></h1>
    <h1 class="mb-1 text-sm font-semibold">{{ $course->code }}</h1>
    <h1 class="mb-3 text-sm font-semibold">Units: {{ number_format($course->units,2) }}</h1>

    <form x-cloak x-show.transition.opacity="showEditCourse" id="course_edit" action="#" class="flex flex-col prounded-lg">
        <label for="course_name" class="mt-2">Course Name</label>
        <input wire:model.defer="newCourseName" name="course_name" type="text" class="form-input">
        @error('newCourseName')
        <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
        @enderror
        <label for="course_code" class="mt-2">Course Code</label>
        <input wire:model.defer="newCourseCode" name="course_code" placeholder="ABC123" type="text" class="form-input">
        @error('newCourseCode')
        <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
        @enderror
        <button type="submit" onclick="confirm('Confirm changes?') || event.stopImmediatePropagation()"
            wire:click.prevent="editCourse" class="px-10 py-2 mt-2 rounded-lg bg-primary-500">Save</button>
        <button wire:click.prevent="" @click="showEditCourse = !showEditCourse"
            class="px-10 py-2 mt-2 rounded-lg bg-primary-500">Cancel</button>
    </form>
    <h1 class="mb-3 text-xl font-bold text-center">FACULTY MANAGER</h1>
    <hr class="border-t-2 border-primary-600">
    <div class="italic text-green-400">
        @if (session()->has('course_updates'))
        {{ session('course_updates') }}
        @endif
    </div>

    <h1 class="my-2 font-bold">Course Sections List</h1>
    <table class="table min-w-full border-2 border-collapse border-gray-200 divide-y shadow">
        <thead>
            <th>Faculty Name</th>
            <th>Email</th>
            <th>Section</th>
        </thead>
        <tbody class="text-center">
            @forelse ($sections as $section)
            <tr class="divide-x">
                <td>{{ $section->teacher->user->name }}</td>
                <td>{{ $section->teacher->user->email }}</td>
                <td>{{ $section->code }}<i
                    onclick="confirm('Confirm removal of faculty member?') || event.stopImmediatePropagation()"
                    wire:click.prevent="removeSection({{ $section->id }},{{ $section->teacher_id }})"
                    class="ml-5 text-red-600 cursor-pointer icofont-trash"></i></td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No sections found on this course.</td>
            </tr>
            @endforelse

        </tbody>
    </table>

</div>