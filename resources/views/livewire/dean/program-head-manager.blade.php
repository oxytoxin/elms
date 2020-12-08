<div class="px-5">
    <h1 class="text-2xl font-semibold">MANAGE PROGRAM HEADS</h1>
    <div class="mt-5">
        <div class="flex flex-col space-y-2">
        <input type="text" name="programhead_email" wire:model.lazy="email" placeholder="firstname.lastname@sksu.edu.ph" id="programhead_email" class="flex-grow min-w-80 form-input" autofocus>
        @error('email')
            <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
        @enderror
        <select wire:model.lazy="department_id" name="department_select" class="form-select" id="department_select">
            <option value="0" selected hidden disabled>Select department</option>
            @foreach ($departments as $department)
            <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
        @error('department_id')
            <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
        @enderror
        <button wire:click="assignProgramHead" class="p-3 text-sm font-semibold text-white rounded-lg bg-primary-500 hover:text-primary-600">ASSIGN PROGRAM HEAD</button>
        <div class="italic text-green-400">
            @if(session('message'))
            {{ session('message') }}
            @endif
        </div>
    </div>
    </div>
    <div class="mt-5">
        <h1 class="my-3 font-semibold">Program Heads List</h1>
        <table class="w-full text-center bg-white border-2 divide-y-2 table-auto divide-primary-600 border-primary-600">
            <thead class="">
                <tr class="divide-x-2 divide-primary-600">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-primary-600">
                @forelse ($programheads as $programhead)
                    <tr class="divide-x-2 divide-primary-600">
                        <td class="whitespace-no-wrap">{{ $programhead->user->name }}</td>
                        <td>{{ $programhead->user->email }}</td>
                        <td>{{ $programhead->department->name }}</td>
                        <td><i
                            onclick="confirm('Confirm removal of program head?') || event.stopImmediatePropagation()"
                            wire:click.prevent="removeProgramHead({{ $programhead->id }})"
                            class="text-red-600 cursor-pointer icofont-trash"></i></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <h1 class="p-2 text-center">No program heads assigned.</h1>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

@section('sidebar')
    @include('includes.dean.sidebar')
@endsection