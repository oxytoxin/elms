<div class="px-5">
    <div class="mt-2">
        <h1 class="flex items-center justify-between text-xl font-semibold"><span>ADD MODULE</span><span class="text-sm font-normal"><input type="checkbox" wire:model="allSections" class="form-checkbox" name="addforall" id="addforall"><label for="addforall" class="ml-1 font-bold uppercase">Add for all your sections</label></span></h1>
        <form wire:submit.prevent="addModule" enctype="multipart/form-data">
            @csrf
            <div class="text-sm">
                <h1>Course: {{ $section->course->name }}</h1>
                <h1>Section: {{ $section->code }}</h1>
            </div>
            <div class="flex-grow">
                <label class="font-semibold" for="title">Module Title<i wire:loading wire:target="addModule"
                    class="fa fa-spinner fa-spin"></i></label>
                <input wire:model="moduleName" type="text" class="block w-full form-input" autocomplete="off"
                    placeholder="Module Title" autofocus name="moduleName">
                @error('moduleName')
                <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                @enderror
            </div>
            <div class="flex flex-col items-center mt-2 md:flex-row">
                <input type="file" required wire:model="moduleFiles" class="w-full form-input" autocomplete="off" multiple
                    id="file{{ $fileId }}" name="module">
                @error('moduleFiles.*')
                <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                @enderror
                <button  wire:target="moduleFiles" wire:loading.remove
                    class="p-2 mt-2 ml-2 text-white whitespace-no-wrap rounded-lg md:mt-0 hover:text-black focus:outline-none bg-primary-500">Upload
                    Module</button>
            </div>
        </form>
    </div>

    <div wire:target="moduleFiles" wire:loading>
        <h1 class="italic font-semibold text-green-400">Uploading Module. Please
            wait...<i class="fa fa-spinner fa-spin"></i></h1>
    </div>
    <div class="italic text-green-400">
        @if (session()->has('message'))
        {{ session('message') }}
        @endif
    </div>
    <div class="p-3 mt-5 bg-white">
        <h1 class="font-bold">Course Module List for this section</h1>
        <div class="italic text-green-400">
            @if (session()->has('module_deleted'))
            {{ session('module_deleted') }}
            @endif
        </div>
        <table class="table min-w-full mt-5 border-2 border-collapse divide-y-2 shadow border-primary-600 divide-primary-600">
            <thead class="">
                <th>Title</th>
                <th>File/s</th>
                <th>Date Added</th>
            </thead>
            <tbody class="text-center divide-y-2 divide-primary-600">
                @forelse ($section->modules as $course_module)
                <tr class="divide-x-2 divide-primary-600">
                    <td class="p-2"><a href="{{ route('teacher.module',['module' => $course_module->id]) }}" class="hover:text-primary-500">{{ $course_module->name }}<i class="ml-3 icofont-external-link text-primary-500"></i></a></td>
                    <td class="p-2">{{ $course_module->files->count() }}</td>
                    <td class="p-2">{{ $course_module->created_at->diffForHumans() }}<i
                            onclick="confirm('Are you sure you want to delete this module?')|| event.stopImmediatePropagation()"
                            wire:click.prevent="deleteModule({{ $course_module->id }})"
                            class="ml-4 text-red-600 cursor-pointer icofont-trash"></i>
                    </td>
                </tr>
                @empty
                <tr class="divide-x-2 divide-primary-600">
                    <td colspan="2">No modules found on this course.</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
@push('metas')
    <meta name="turbolinks-cache-control" content="no-cache">
@endpush

@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection