<div class="px-5">
    <h1 class="text-2xl font-semibold">UPLOAD WORKLOAD <i class="fas fa-spin fa-spinner" wire:loading></i></h1>
    <div class="mt-3">
        <h1>For faculty member: {{ $teacher->user->name }}</h1>
        <h1>College: {{ $teacher->college->name }}</h1>
        <h1>Department: {{ $teacher->department->name }}</h1>
        <form class="flex space-x-2" method="GET" wire:submit.prevent="uploadWorkload">
            <input type="file" name="workload" id="workload{{ $fileId }}" required wire:model="workload" class="form-input">
            <button class="p-3 font-semibold text-white uppercase rounded-lg bg-primary-500">UPLOAD CSV</button>
        </form>
        <div class="italic text-green-400">
            @if(session('message'))
            {{ session('message') }}
            @endif
        </div>
        <div class="italic text-red-600">
            @if(session('error'))
            {{ session('error') }}
            <h1>Click <a class="font-semibold underline text-primary-500" href="{{ route('head.add_section') }}">here</a> for manual encoding.</h1>
            @endif
        </div>
    </div>
    <div class="p-5 mt-5 bg-white shadow">
        <h1 class="text-xl font-semibold">Faculty Workload</h1>

        @if ($hasWorkload)
        <div class="mt-5">
            <table class="w-full text-center border-2 divide-y-2 table-auto border-primary-600 divide-primary-600">
                <thead>
                    <tr class="divide-x-2 divide-primary-600">
                        <th class="p-2">#</th>
                        <th class="p-2">Course Description</th>
                        <th class="p-2">Course Code</th>
                        <th class="p-2">Section</th>
                        <th class="p-2">Units</th>
                        <th class="p-2">Schedule</th>
                        <th class="p-2">Room</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-primary-600">
                    @foreach ($sections as $section)
                    <tr class="divide-x-2 divide-primary-600">
                        <td class="p-2">{{ $section->id }}</td>
                        <td class="p-2">{{ $section->course->name }}</td>
                        <td class="p-2">{{ $section->course->code }}</td>
                        <td class="p-2">{{ $section->code }}</td>
                        <td class="p-2">{{ $section->course->units }}</td>
                        <td class="p-2">{{ $section->schedule }}</td>
                        <td class="p-2">{{ $section->room }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h1>No workload found.</h1>
        @endif
    </div>
</div>

@section('sidebar')
@include('includes.head.sidebar')
@endsection
