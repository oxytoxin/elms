<div class="p-5">
    <h1 class="mb-3 text-2xl font-semibold">Submission Preview</h1>
    <h1>Course: {{ $task->course->name }}</h1>
    <h1>Module: {{ $task->module->name }}</h1>
    <h1>Task type: <span class="uppercase">{{ $task->task_type->name }}</span></h1>
    <h1>{{ $task->name }}</h1>
    @if (auth()->user()->isStudent())
    <h1>Teacher: {{ $task->teacher->user->name }}</h1>
    @elseif(auth()->user()->isTeacher())
    <h1>Student: {{ $submission->student->user->name }}</h1>
    @endif
    {{-- @dd($answers) --}}
    @foreach ($questions as $key => $question)
    <div class="p-4 mt-2 bg-white rounded-lg shadow">
        <h1><span class="font-semibold">Question {{ $question['item_no'] }}:</span> {{ $question['question'] }}</h1>
        @if(!empty($question['files']))
            <h1 class="mt-2 text-sm italic border-b-2 border-primary-600">Question Attachments</h1>
            <div class="px-4 py-2">
            @foreach ($question['files'] as $file)
            <a target="blank" href="{{ asset('storage'.'/'.$file['url']) }}" class="text-xs italic font-semibold underline text-primary-500">{{ $file['name'] }}</a>
            @endforeach
            </div>
        @endif
        @isset($answers[$key]['answer'])
        <p class="mt-3 text-sm"><span class="font-semibold">Answer:</span> {{ $answers[$key]['answer'] }}</p>
        @endisset
        @if(!empty($answers[$key]['files']))
        <h1 class="mt-2 text-sm italic border-b-2 border-primary-600">Answer Attachments</h1>
            <div class="px-4 py-2">
            @foreach ($answers[$key]['files'] as $file)
            <a target="blank" href="{{ asset('storage'.'/'.$file['url']) }}" class="text-xs italic font-semibold underline text-primary-500">{{ $file['name'] }}</a>
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
</div>

@section('sidebar')
    @if (auth()->user()->isStudent())
    @include('includes.student.sidebar')
    @elseif(auth()->user()->isTeacher())
    @include('includes.teacher.sidebar')
    @endif
@endsection