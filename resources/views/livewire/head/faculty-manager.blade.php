<div class="px-5">
    <h1 class="text-2xl font-semibold">FACULTY MANAGER</h1>
    <div>
        <div class="flex space-x-2 space-y-2 md:space-y-0">
            <input type="text" name="faculty_email" wire:model.lazy="email" placeholder="firstname.lastname@sksu.edu.ph" id="faculty_email" class="flex-grow form-input" autofocus>
            <button wire:click="addFaculty" class="p-3 text-sm font-semibold text-white rounded-lg bg-primary-500 hover:text-primary-600">ADD FACULTY MEMBER</button>
        </div>
            @error('email')
                <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror
            <div class="italic text-green-400">
                @if(session('message'))
                {{ session('message') }}
                @endif
            </div>
            <div class="text-xs italic text-red-600">
                @if(session('error'))
                {{ session('error') }}
                @endif
            </div>
    </div>
    <div class="w-full p-5">
        <table class="table w-full text-center bg-white border-2 border-collapse divide-y-2 table-auto divide-primary-600 border-primary-600">
            <thead>
                <tr class="divide-x-2 divide-primary-600">
                    <th class="p-2">Faculty</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-primary-600">
                @forelse ($teachers as $teacher)
                <tr class="divide-x-2 divide-primary-600">
                    <td class="p-1">{{ $teacher->user->name }}</td>
                    <td class="p-1">{{ $teacher->user->email }}</td>
                    <td class="p-1 py-3 text-xs text-center"><a href="{{ route('head.workload_uploader',['teacher' => $teacher->id]) }}" class="p-2 font-semibold text-white hover:text-primary-600 bg-primary-500">MANAGE WORKLOAD</a><i
                        onclick="confirm('Confirm removal of faculty member?') || event.stopImmediatePropagation()"
                        wire:click.prevent="removeFaculty({{ $teacher->id }})"
                        class="ml-4 text-lg text-red-600 cursor-pointer icofont-trash"></i></td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <h1 class="p-2 text-center">No teachers found.</h1>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-2">
            {{ $teachers->count() ? $teachers->links() : '' }}
        </div>
    </div>
</div>

@section('sidebar')
    @include('includes.head.sidebar')
@endsection