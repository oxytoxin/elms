<div class="px-5">
    <h1 class="text-2xl font-semibold">UPLOAD WORKLOAD <i class="fas fa-spin fa-spinner" wire:loading></i></h1>
    <div class="mt-3">
        <h1>For faculty member: {{ $teacher->user->name }}</h1>
        <h1>College: {{ $teacher->college->name }}</h1>
        <h1>Department: {{ $teacher->department->name }}</h1>
        <form action="#" method="GET" wire:submit.prevent="uploadWorkload">
            <input type="file" name="workload" id="workload" required wire:model="workload" class="form-input">
            <button class="p-3 font-semibold text-white uppercase rounded-lg bg-primary-500">UPLOAD CSV</button>
        </form>
    </div>
    <div class="p-5 mt-5 bg-white shadow">
        @if ($hasWorkload)

        @else
        <h1>No workload found.</h1>
        @endif
    </div>
</div>

@section('sidebar')
    @include('includes.head.sidebar')
@endsection