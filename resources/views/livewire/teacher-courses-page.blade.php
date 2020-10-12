<div class="w-full md:w-5/6">
    <h1 class="font-semibold">{{ $course->name }}<i wire:loading class="fa fa-spinner fa-spin"></i></h1>
    <div class="box-border flex text-lg text-gray-300 border-2 border-black">
        <a href="#" wire:click="$set('tab','student')"
            class="flex items-center justify-center w-1/2 {{ $tab == 'student' ?  'bg-primary-500 text-gray-700' : '' }}">
            <div class="font-bold text-center uppercase hover:text-gray-700">ENROL STUDENT</div>
        </a>
        <a href="#" wire:click="$set('tab','resources')"
            class="flex items-center justify-center w-1/2 {{ $tab == 'resources' ?  'bg-primary-500 text-gray-700' : '' }}">
            <div class="font-bold text-center uppercase hover:text-gray-700">UPLOAD MODULE RESOURCES</div>
        </a>
    </div>
    @if ($tab == 'student')
    <div class="mt-2">
        <form action="#" wire:submit.prevent="enrolStudent">
            <label for="email">Student Email</label>
            <div class="italic text-green-400">
                @if (session()->has('message'))
                {{ session('message') }}
                @endif
            </div>
            <div class="flex flex-col items-center mt-2 md:flex-row">
                <input wire:model="email" type="email" class="w-full form-input" placeholder="student@email.com"
                    autocomplete="off" autofocus name="email">
                <button
                    class="w-full p-2 mt-2 text-white whitespace-no-wrap rounded-lg md:ml-3 md:w-auto md:mt-0 hover:text-black focus:outline-none bg-primary-500">Enrol
                    Student</button>
            </div>
            @error('email')
            <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror
        </form>
    </div>
    <h1 class="my-2 font-bold">Course Student List</h1>
    <table class="table w-full border-2 border-collapse border-gray-600">
        <thead class="">
            <th class="border-2 border-gray-600">Name</th>
            <th class="border-2 border-gray-600">Email</th>
        </thead>
        <tbody class="text-center">
            @forelse ($course->students()->wherePivot('teacher_id',auth()->user()->teacher->id)->get()->reverse() as
            $student)
            <tr>
                <td class="border-2 border-gray-600">{{ $student->user->name }}</td>
                <td class="border-2 border-gray-600">{{ $student->user->email }}<i
                        onclick="confirm('Confirm removal of student member?') || event.stopImmediatePropagation()"
                        wire:click.prevent="removeStudent({{ $student->id }})"
                        class="ml-5 text-red-600 cursor-pointer icofont-trash"></i></td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="border-2 border-gray-600">No students enrolled.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endif
    @if ($tab == 'resources')
    <div class="mt-2">
        <form action="#" wire:submit.prevent="addResources">
            <label class="font-semibold" for="module">Select Module</label>
            <select wire:model="module_id" required class="flex-1 block w-full form-select" name="module_id">
                <option value="0">Select Module</option>
                @forelse ($course->modules as $i=>$module)
                <option value="{{ $module->id }}">{{ $module->name }}</option>
                @empty
                @endforelse
            </select>
            @error('module_id')
            <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
            @enderror
            <label class="font-semibold" for="title">Resource Title</label>
            <input wire:model="title" type="text" class="flex-1 block w-full form-input" autocomplete="off"
                placeholder="Resource Title" autofocus name="title">
            @error('title')
            <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
            @enderror
            <label class="font-semibold" for="description">Resource Description</label>
            <textarea wire:model="description" class="flex-1 w-full resize form-textarea" rows="4" autocomplete="off"
                placeholder="Resource Description" autofocus name="description"></textarea>
            @error('description')
            <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
            @enderror
            <div class="flex flex-col items-center mt-2 md:flex-row">
                <input type="file" wire:model="resources" id="file{{ $fileId }}" class="w-full form-input"
                    autocomplete="off" required multiple name="resources">
                <button
                    class="w-full p-2 mt-2 text-white whitespace-no-wrap rounded-lg md:w-auto md:ml-2 md:mt-0 hover:text-black focus:outline-none bg-primary-500">Upload
                    Resource</button>
            </div>
            @error('resources.*')
            <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
            @enderror
            <div wire:loading wire:target="addResources">
                <h1 class="italic text-green-400">Uploading resources. Please wait...<i
                        class="fa fa-spinner fa-spin"></i></h1>
            </div>
        </form>
    </div>
    <div class="italic text-green-400">
        @if (session()->has('message'))
        {{ session('message') }}
        @endif
    </div>
    <h1 class="my-2 font-bold">Course Resources List</h1>
    <table class="table w-full border-2 border-collapse border-gray-600 table-fixed">
        <thead class="">
            <th class="border-2 border-gray-600">Title</th>
            <th class="border-2 border-gray-600">Date Added</th>
        </thead>
        <tbody class="text-center">
            @foreach ($course->modules as $module)
            @forelse ($module->resources()->where('teacher_id',auth()->user()->teacher->id)->get() as $resource)
            <tr>
                <td class="border-2 border-gray-600">{{$resource->title}}</td>
                <td class="border-2 border-gray-600">{{ $resource->created_at->diffForHumans()}}<i
                        onclick="confirm('Confirm deletion of module resource?') || event.stopImmediatePropagation()"
                        wire:click.prevent="removeResource({{ $resource->id }})"
                        class="ml-5 text-red-600 cursor-pointer icofont-trash"></i></td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="border-2 border-gray-600">No resources found on this module.</td>
            </tr>
            @endforelse
            @endforeach
        </tbody>
    </table>
    @endif
</div>