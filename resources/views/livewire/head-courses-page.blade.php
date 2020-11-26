<div class="w-full" x-data="{ showEditCourse:@entangle('showEditCourse')}">
    <h1 class="my-5 text-xl font-semibold">{{ $course->name }} <i class="ml-5 cursor-pointer icofont-edit"
            wire:click="$set('showEditCourse',true)"></i><i
            onclick="confirm('Confirm delete?') || event.stopImmediatePropagation()" wire:click.prevent="deleteCourse"
            class="ml-5 text-red-600 cursor-pointer icofont-trash"></i><i wire:loading wire:target="enrolFaculty"
            class="fa fa-spinner fa-spin"></i></h1>
    <div class="box-border flex text-lg text-gray-300 border-2 border-black">
        <a href="#" data-turbolinks="false" wire:click="$set('tab','faculty')"
            class="flex items-center justify-center w-1/2 {{ $tab == 'faculty' ?  'bg-primary-500 text-gray-700' : '' }}">
            <div class="font-bold text-center uppercase hover:text-gray-700">ENROL FACULTY</div>
        </a>
        <a href="#" data-turbolinks="false" wire:click="$set('tab','modules')"
            class="flex items-center justify-center w-1/2 {{ $tab == 'modules' ?  'bg-primary-500 text-gray-700' : '' }}">
            <div class="font-bold text-center uppercase hover:text-gray-700">UPLOAD MODULE RESOURCES</div>
        </a>
    </div>
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
    <div class="italic text-green-400">
        @if (session()->has('course_updates'))
        {{ session('course_updates') }}
        @endif
    </div>
    @if ($tab == 'faculty')
    <div class="mt-2">
        <form wire:submit.prevent="enrolFaculty">
            @csrf
            <label for="email">Faculty Email</label>
            <div class="italic text-green-400">
                @if (session()->has('message'))
                {{ session('message') }}
                @endif
            </div>
            <div class="flex flex-col items-center mt-2 md:flex-row">
                <input type="email" class="w-full form-input" placeholder="user@email.com" autocomplete="off" autofocus
                    name="email" wire:model.defer="email">
                <button
                    class="p-2 mt-2 ml-2 text-white whitespace-no-wrap rounded-lg md:mt-0 hover:text-black focus:outline-none bg-primary-500">Enroll
                    Faculty</button>
            </div>
        </form>
    </div>
    <h1 class="my-2 font-bold">Course Faculty List</h1>
    <table class="table min-w-full border-2 border-collapse border-gray-200 divide-y shadow">
        <thead class="">
            <th>Name</th>
            <th>Email</th>
        </thead>
        <tbody class="text-center">
            @forelse ($teachers as $teacher)
            <tr class="divide-x">
                <td>{{ $teacher->user->name }}</td>
                <td>{{ $teacher->user->email }}<i
                        onclick="confirm('Confirm removal of faculty member?') || event.stopImmediatePropagation()"
                        wire:click.prevent="removeFaculty({{ $teacher->id }})"
                        class="ml-5 text-red-600 cursor-pointer icofont-trash"></i></td>
            </tr>
            @empty
            <tr>
                <td colspan="2">No faculty member found on this course.</td>
            </tr>
            @endforelse

        </tbody>
    </table>
    @endif
    @if ($tab == 'modules')
    <div class="mt-2">
        <form wire:submit.prevent="addModule" enctype="multipart/form-data">
            @csrf
            <label class="font-semibold" for="title">Module Title<i wire:loading wire:target="addModule"
                    class="fa fa-spinner fa-spin"></i></label>
            <input wire:model="moduleName" type="text" class="block w-full form-input" autocomplete="off"
                placeholder="Module Title" autofocus name="moduleName">
            @error('moduleName')
            <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
            @enderror
            <div class="flex flex-col items-center mt-2 md:flex-row">
                <input type="file" required wire:model="module" class="w-full form-input" autocomplete="off" autofocus
                    id="file{{ $fileId }}" name="module">
                @error('module')
                <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                @enderror
                <button  wire:target="module" wire:loading.remove
                    class="p-2 mt-2 ml-2 text-white whitespace-no-wrap rounded-lg md:mt-0 hover:text-black focus:outline-none bg-primary-500">Upload
                    Module</button>
            </div>
        </form>
    </div>

    <div wire:target="module" wire:loading>
        <h1 class="italic font-semibold text-green-400">Uploading Module. Please
            wait...<i class="fa fa-spinner fa-spin"></i></h1>
    </div>
    <div class="italic text-green-400">
        @if (session()->has('message'))
        {{ session('message') }}
        @endif
    </div>
    <h1 class="mt-2 font-bold">Course Module List</h1>
    <div class="italic text-green-400">
        @if (session()->has('module_deleted'))
        {{ session('module_deleted') }}
        @endif
    </div>
    <table class="table min-w-full border-2 border-collapse border-gray-200 divide-y shadow">
        <thead class="">
            <th>Title</th>
            <th>Date Added</th>
        </thead>
        <tbody class="text-center">
            @forelse ($course->modules as $course_module)
            <tr class="divide-x">
                <td>{{ $course_module->name }}</td>

                <td>{{ $course_module->created_at->diffForHumans() }}<i
                        onclick="confirm('Are you sure you want to delete this module?')|| event.stopImmediatePropagation()"
                        wire:click.prevent="deleteModule({{ $course_module->id }})"
                        class="ml-4 text-red-600 cursor-pointer icofont-trash"></i>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2">No modules found on this course.</td>
            </tr>
            @endforelse

        </tbody>
    </table>
    @endif
</div>