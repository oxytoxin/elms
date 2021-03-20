<div class="w-full">
    <h1 class="text-2xl font-semibold uppercase">My Workload</h1>
    <div class="w-full mt-5 bg-white shadow">
        @if ($sections->count())
        <div class="p-5">
            <table class="w-full text-sm text-center border-2 divide-y-2 table-auto border-primary-600 divide-primary-600">
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
        <h1 class="p-5">No workload found.</h1>
        @endif
    </div>
</div>

@section('sidebar')
@include('includes.teacher.sidebar')
@endsection
