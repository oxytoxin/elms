<div class="px-5" x-data="{showQuery : @entangle('showQuery')}">
    <h1 class="text-2xl font-semibold">MANAGE PROGRAM HEADS</h1>
    <div class="mt-5">
        <div class="relative flex flex-col space-y-2">
            <input type="text" name="programhead_email" wire:model="email" placeholder="firstnamelastname@sksu.edu.ph" id="programhead_email" class="flex-grow min-w-80 form-input" autofocus>
            @error('email')
            <h1 class="text-xs italic font-semibold text-red-600">{{ $message }}</h1>
            @enderror
            <div x-show="showQuery" class="absolute w-full overflow-y-auto bg-white border divide-y-2 shadow top-12 max-h-48 mt-14">
                @foreach ($teachers as $teacher)
                <div wire:click="setEmail('{{ $teacher->email }}')" wire:key="teacher-{{ $teacher->id }}" class="flex flex-col justify-between px-4 py-2 cursor-pointer md:flex-row">
                    <h1>{{ $teacher->name }}</h1>
                    <h1>{{ $teacher->email }}</h1>
                </div>
                @endforeach
            </div>
            <div class="text-xs italic font-semibold text-red-600">
                @if(session('error'))
                {{ session('error') }}
                @endif
            </div>
            <select wire:model="department_id" name="department_select" class="form-select" id="department_select">
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
                @foreach ($programhead->departments as $department)
                <tr class="divide-x-2 divide-primary-600">
                    <td class="whitespace-nowrap">{{ $programhead->user->name }}</td>
                    <td>{{ $programhead->user->email }}</td>
                    <td>{{ $department->name }}</td>
                    <td><i onclick="confirm('Confirm removal of program head?') || event.stopImmediatePropagation()" wire:click.prevent="removeProgramHead({{ $department->id }},{{ $programhead->id }})" class="text-red-600 cursor-pointer icofont-trash"></i></td>
                </tr>
                @endforeach
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
