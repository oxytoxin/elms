<div class="p-5">
    <h1 class="mb-3 text-2xl font-semibold">Submission Preview</h1>
    <h1>Course: {{ $task->course->name }}</h1>
    <h1>Module: {{ $task->module->name }}</h1>
    <h1>Task type: <span class="uppercase">{{ $task->task_type->name }}</span></h1>
    <h1>Task Title: {{ $task->name }}</h1>
    @if (auth()->user()->isStudent())
    <h1>Teacher: {{ $task->teacher->user->name }}</h1>
    @elseif(auth()->user()->isTeacher())
    <h1>Student: {{ $submission->student->user->name }}</h1>
    @endif
    @if ($submission->isGraded)
    <h1 class="font-bold uppercase">Score: {{ $submission->score }}</h1>
    <div class="flex flex-col items-center justify-center md:flex-row">
        <h1 class="text-sm font-semibold uppercase"><i class="ml-4 mr-2 text-green-400 text-opacity-50 icofont-square"></i>Correct/Partial</h1>
        <h1 class="text-sm font-semibold uppercase"><i class="ml-4 mr-2 text-yellow-300 text-opacity-50 icofont-square"></i>UnGraded</h1>
        <h1 class="text-sm font-semibold uppercase"><i class="ml-4 mr-2 text-red-400 text-opacity-50 icofont-square"></i>Wrong</h1>
    </div>
    @endif
    {{-- @dd($answers) --}}
    @foreach ($questions as $key => $question)
    <div class="p-4 mt-2 bg-opacity-50 {{ $submission->isGraded ? ($assessment[$key]['isCorrect'] ? 'bg-green-400' : 'bg-red-400') : 'bg-white' }} rounded-lg shadow">
        <h1 class="flex justify-between"><span class="font-semibold">Question {{ $question['item_no'] }} {{ $question['essay'] ? '(Essay)' : ($question['enumeration'] ? '(Enumeration)' : '') }}</span><span class="font-semibold text-orange-500">{{ $question['points'] }} pt/s</span></h1>
        <h1 class="px-3">{{ $question['question'] }}</h1>
        <hr class="border-t-2 border-primary-600">
        @if(!empty($question['files']))
            <h1 class="mt-2 text-sm italic border-b-2 border-primary-600">Question Attachments</h1>
            <div class="px-4 py-2">
            @foreach ($question['files'] as $file)
            <a target="blank" href="{{ asset('storage'.'/'.$file['url']) }}" class="text-xs italic font-semibold underline text-primary-500">{{ $file['name'] }}</a>
            @endforeach
            </div>
        @endif
        @if ($question['enumeration'])
        <ul class="mx-3 my-5 space-y-2 list-disc list-inside">
            @foreach (json_decode($answers[$key]['answer']) as $answer)
            <li>{{ $answer }}</li>
            @endforeach

        </ul>

        @else
        @isset($answers[$key]['answer'])
        <p class="mt-3 text-sm"><span class="font-semibold">Answer:</span> {{ $answers[$key]['answer'] }}</p>
        @endisset
        @endif

        @if(!empty($answers[$key]['files']))
        <h1 class="mt-2 text-sm italic border-b-2 border-primary-600">Answer Attachments</h1>
            <div class="px-4 py-2">
            @foreach ($answers[$key]['files'] as $file)
            <a target="blank" href="{{ asset('storage'.'/'.$file['url']) }}" class="text-xs italic font-semibold underline text-primary-500">{{ $file['name'] }}</a>
            @endforeach
        </div>
        @endif
        <h1 class="text-sm font-bold">SCORE: {{ $assessment[$key]['score'] }} pt(s)</h1>
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