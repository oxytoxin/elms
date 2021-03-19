<div class="w-full">
    <h1 class="text-2xl font-semibold uppercase">My Workload</h1>
    <div class="w-full mt-5 bg-white shadow">
        @if (!$sections->count())
        {{-- <div>
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
    </div> --}}
    {{-- <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Role
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                Jane Cooper
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                Regional Paradigm Technician
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                jane.cooper@example.com
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                Admin
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>

                        <!-- More items... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

    @else
    <h1>No workload found.</h1>
    @endif
</div>
</div>

@section('sidebar')
@include('includes.teacher.sidebar')
@endsection
