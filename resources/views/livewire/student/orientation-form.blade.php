<div class="w-full px-5">
    <div class="p-5 bg-gray-300 min-h-72">
        <div class="my-4">
            <h3><span class="font-semibold">Course Code/Description: </span><span>{{ $section->course->code }} / {{ $section->course->name }}</span></h3>
            <h3><span class="font-semibold">Section: </span><span>{{ $section->code }}</span></h3>
            <h3><span class="font-semibold">Instructor: </span><span>{{ $section->teacher->user->name }}</span></h3>
        </div>
        <p class="px-5 mx-auto text-xl text-justify">I hereby acknowledge and certify that the instructor referred to in the course mentioned above had oriented me on College Vision, Mission, Goals and Objectives, the policies and guidelines, instructional standards (course content, grading system, list of references and consultation time).</p>
        <div class="my-4 text-center">
            <button wire:click="acceptOrientation" class="p-3 text-white bg-primary-500">Agree and Continue</button>
        </div>
    </div>
</div>

@section('sidebar')
@include('includes.student.sidebar')
@endsection
