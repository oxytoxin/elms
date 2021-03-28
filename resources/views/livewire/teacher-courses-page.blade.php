<div x-data="{showInviteCode : @entangle('showInviteCode'), showQuery : @entangle('showQuery')}">
    <x-loading wire:loading.grid wire:target="addResources,resources" message="Uploading files..." />
    <div class="w-full">
        <div class="flex flex-col items-center justify-between my-3 md:my-0 md:flex-row">
            <div>
                <h1 class="mt-3 text-xl font-semibold">{{ $section->course->name }}<i wire:loading class="fa fa-spinner fa-spin"></i></h1>
                <h1 class="mb-3 font-semibold">Section: {{ $section->code }}</h1>
            </div>
            <div class="flex flex-col space-y-2 md:space-y-0 md:space-x-2 md:flex-row">
                <button wire:click="$set('showInviteCode',true)" class="p-3 font-semibold text-white hover:text-primary-600 bg-primary-500">GET INVITE LINK</button>
                @if ($section->videoroom)
                <button wire:click="joinMeeting" class="p-3 font-semibold text-white hover:text-primary-600 bg-primary-500">JOIN MEETING</button>
                @else
                <button wire:click="createMeeting" class="p-3 font-semibold text-white hover:text-primary-600 bg-primary-500">CREATE MEETING</button>
                @endif
            </div>
        </div>
        <div class="box-border flex mt-5 text-lg text-gray-300 border-2 border-black">
            <a href="#" data-turbolinks="false" wire:click="$set('tab','student')" class="flex items-center justify-center w-1/2 {{ $tab == 'student' ?  'bg-primary-500 text-gray-700' : '' }}">
                <div class="font-bold text-center uppercase hover:text-gray-700">ENROL STUDENT</div>
            </a>
            <a href="#" data-turbolinks="false" wire:click="$set('tab','resources')" class="flex items-center justify-center w-1/2 {{ $tab == 'resources' ?  'bg-primary-500 text-gray-700' : '' }}">
                <div class="font-bold text-center uppercase hover:text-gray-700">UPLOAD MODULE RESOURCES</div>
            </a>
        </div>
        <div>
            <div>
                @if ($tab == 'student')
                <div class="mt-2">
                    <form action="#" wire:submit.prevent="enrolStudent">
                        <label for="email">Student Email</label>
                        <div class="italic text-green-400">
                            @if (session()->has('message'))
                            {{ session('message') }}
                            @endif
                        </div>
                        <div class="relative flex flex-col items-center mt-2 md:flex-row">
                            <input wire:model="email" type="email" class="w-full form-input" placeholder="student@email.com" autocomplete="off" autofocus name="email">
                            <button class="w-full p-2 mt-2 text-white rounded-lg whitespace-nowrap md:ml-3 md:w-auto md:mt-0 hover:text-black focus:outline-none bg-primary-500">Enrol
                                Student</button>
                            <div x-show="showQuery" class="absolute top-0 w-full overflow-y-auto bg-white divide-y-2 max-h-48 mt-14">
                                @foreach ($students as $stud)
                                <div wire:click="setEmail('{{ $stud->email }}')" wire:key="student-{{ $stud->id }}" class="flex flex-col justify-between px-4 py-2 cursor-pointer md:flex-row">
                                    <h1>{{ $stud->name }}</h1>
                                    <h1>{{ $stud->email }}</h1>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @error('email')
                        <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                        @enderror
                        <div class="text-xs italic text-red-600">
                            @if (session()->has('error'))
                            {{ session('error') }}
                            @endif
                        </div>
                    </form>
                </div>
                <h1 class="my-2 font-bold">Course Student List</h1>
                <table class="table min-w-full border-2 border-collapse border-gray-200 divide-y shadow">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                    </thead>
                    <tbody class="text-center divide-y">
                        @forelse ($section->students()->wherePivot('teacher_id',auth()->user()->teacher->id)->get()->sortBy('user.name') as
                        $student)
                        <tr class="divide-x">
                            <td>{{ $student->user->name }}</td>
                            <td class="flex items-center space-x-2"><span class="flex-1">{{ $student->user->email }}</span><i onclick="confirm('Confirm removal of student member?') || event.stopImmediatePropagation()" wire:click.prevent="removeStudent({{ $student->id }})" class="p-3 text-red-600 cursor-pointer icofont-trash"></i></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">No students enrolled.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @endif
            </div>
            <div>
                @if ($tab == 'resources')
                <div class="mt-2">
                    <form wire:submit.prevent="addResources">
                        <label class="font-semibold" for="module">Select Module</label>
                        <select wire:change="updateModule" wire:model="module_id" required class="flex-1 block w-full form-select">
                            <option value="0">Select Module</option>
                            @forelse ($section->modules as $i=>$module)
                            <option wire:key="moduleOption_{{ $i }}" value="{{ $module->id }}">{{ $module->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('module_id')
                        <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                        @enderror
                        <label class="font-semibold" for="title">Resource Title</label>
                        <input wire:model.lazy="title" type="text" class="flex-1 block w-full form-input" autocomplete="off" placeholder="Resource Title" autofocus name="title">
                        @error('title')
                        <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                        @enderror
                        <label class="font-semibold" for="description">Resource Description</label>
                        <textarea wire:model.lazy="description" class="flex-1 w-full resize-none form-textarea" rows="4" autocomplete="off" placeholder="Resource Description" autofocus name="description"></textarea>
                        @error('description')
                        <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                        @enderror

                        <div wire:key="filepond">
                            <div>
                                <x-filepond inputname="module_resources" type="file" wire:model="resources" id="file{{ $fileId }}" class="w-full form-input" autocomplete="off" required multiple name="resources" />
                            </div>
                            <div>
                                @error('resources')
                                <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
                                @enderror
                            </div>
                        </div>

                        <div wire:key="submitButton">
                            <button wire:loading.remove wire:target="resources" class="w-full p-2 mt-2 text-white rounded-lg whitespace-nowrap md:w-auto md:mt-0 hover:text-black focus:outline-none bg-primary-500">Upload
                                Resource</button>
                        </div>



                    </form>
                </div>
                <div class="italic text-green-400">
                    @if (session()->has('message'))
                    {{ session('message') }}
                    @endif
                </div>
                <h1 class="my-2 font-bold">Module Resources List</h1>
                <table class="table min-w-full border-2 border-collapse border-gray-200 divide-y shadow">
                    <thead>
                        <th>Title</th>
                        <th># of Files</th>
                        <th>Date Added</th>
                    </thead>
                    <tbody class="text-center">
                        @if ($moduleSelected)
                        @forelse ($moduleSelected->resources()->where('teacher_id',auth()->user()->teacher->id)->get() as $resource)
                        <tr class="divide-x">
                            <td><a href="{{ route('teacher.module',['module'=>$module_id]) }}">{{$resource->title}} <i class="icofont-external-link text-primary-500"></i></a></td>
                            <td>{{$resource->files->count()}}</td>
                            <td>{{ $resource->created_at->diffForHumans()}}<i onclick="confirm('Confirm deletion of module resource?') || event.stopImmediatePropagation()" wire:click.prevent="removeResource({{ $resource->id }})" class="ml-5 text-red-600 cursor-pointer icofont-trash"></i></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">No module resources found</td>
                        </tr>
                        @endforelse
                        @else
                        <tr>
                            <td colspan="3">No module selected.</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div x-cloak x-show.transition="showInviteCode" class="absolute inset-0 z-50 flex items-center justify-center bg-gray-400 bg-opacity-50">
        <div @click.away="showInviteCode = false" class="p-5 bg-white md:w-1/2 min-h-halfscreen">
            <h1>Share this invite code to your students for them to enrol in this course.</h1>
            <hr class="border-t-2 border-primary-600">
            <h1 class="mt-5 text-lg font-semibold">INVITE CODE:</h1>
            <div class="p-5 m-5 border-2 border-primary-600">
                <p id="invite_code" class="break-all">{{ $inviteCode }}</p>
            </div>
            <button onclick="copyText()" class="float-right p-3 mx-5 text-sm font-bold text-white bg-primary-500 hover:text-primary-600">COPY CODE</button>
        </div>
    </div>

</div>

@section('sidebar')
@include('includes.teacher.sidebar')
@endsection

@push('scripts')
<script>
    function copyText() {
        var text = document.getElementById('invite_code').innerText;
        var elem = document.createElement("textarea");
        document.body.appendChild(elem);
        elem.value = text;
        elem.select();
        document.execCommand("copy");
        document.body.removeChild(elem);
        Livewire.emit('copyAlert');
    }

</script>
@endpush

@once
@push('scripts')
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
@endpush
@endonce
