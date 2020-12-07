<div class="px-5">
    <h1 class="text-2xl font-semibold">FACULTY MANAGER</h1>
    <div class="w-full p-5">
        <table class="table w-full bg-white border-collapse table-auto">
            <thead>
                <th class="p-2 border-2">Faculty</th>
                <th class="p-2 border-2">Email</th>
                <th class="p-2 border-2">Actions</th>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                <tr>
                    <td class="p-1 border-2">{{ $teacher->user->name }}</td>
                    <td class="p-1 border-2">{{ $teacher->user->email }}</td>
                    <td class="p-1 py-3 text-xs text-center border-2"><a href="{{ route('head.workload_uploader',['teacher' => $teacher->id]) }}" class="p-2 font-semibold text-white hover:text-primary-600 bg-primary-500">MANAGE WORKLOAD</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $teachers->links() }}
        </div>
    </div>
</div>

@section('sidebar')
    @include('includes.head.sidebar')
@endsection