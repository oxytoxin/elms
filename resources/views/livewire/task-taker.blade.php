<div class="p-5">
    <h1 class="px-5 font-semibold uppercase"><span class="text-xl">{{ $task->task_type->name }}</h1>
    <h1 class="px-5 italic font-semibold uppercase">Task: {{ $task->name }}</h1>
    <h1 class="px-5 italic font-semibold uppercase">Course: {{ $task->course->name }}</span></h1>
    <h1 class="px-5 italic font-semibold uppercase">Module: <span class="text-orange-500">{{ $task->module->name }}</span></h1>
    @if (!$hasSubmission)
        @foreach ($task_content as $key => $item)
        <div class="p-2 mx-5 @error('answers') @if(!isset($answers[$key]['answer']) && !isset($answers[$key]['files'])) {{ 'bg-red-300' }} @endif @enderror mt-3 border border-gray-700 rounded-lg shadow-lg">
            <h1 class="font-semibold text-orange-500">({{ $item['points'] }} pt/s.) Question {{ $item['item_no'] }}. {{ $item['essay'] ? '(Essay)' : '' }}</h1>
            <h1>{{ $item['question'] }}</h1>
            @if ($item['files'])
            <div class="flex justify-center my-3">
                <div class="flex flex-col items-center">
                @foreach ($item['files'] as $file)
                <a target="blank" href="{{ asset('storage'.'/'.$file['url']) }}" class="text-sm italic underline text-primary-500">View Attachment: {{ $file['name'] }}</a>
                @endforeach
                </div>
            </div>
        @endif
        @forelse ($item['options'] as $id=>$option)
            <div>
                <input type="radio" wire:model="answers.{{ $key }}.answer" id="answer_{{ $item['item_no'] }}_{{ $option }}" name="answer_{{ $item['item_no'] }}" value="{{ $option }}" class="form-radio">
                <label for="answer_{{ $item['item_no'] }}_{{ $option }}">{{ $option }}</label>
            </div>
        @empty

        @endforelse

        <br>
        <h1 wire:loading wire:target="answers.{{ $key }}.files" class="text-center"><i class="fas fa-spin fa-spinner"></i>Uploading...</h1>
        <br>
        @isset($answers[$key]['files'])
            <div class="p-3 mb-1 bg-white border shadow">
                <h1 class="text-sm font-semibold uppercase">Your Attachments:</h1>
                @foreach ($answers[$key]['files'] as $file)
                    <h1 class="text-sm italic">{{ is_array($file) ? $file['name'] : $file->getClientOriginalName() }}</h1>
                @endforeach
            </div>
        @endisset
        @if ($item['attachment'])
        <label class="text-xs font-semibold uppercase" for="answer_{{ $key }}_files">Add Attachment</label>
        <input type="file" wire:model="answers.{{ $key }}.files" name="answer_{{ $key }}_files" id="answer_{{ $key }}_files" multiple class="w-full my-2 form-input">
        @endif
        @if ($item['essay'])
        <textarea wire:key="item_{{ $key }}_textarea" placeholder="Your answer..." wire:model="answers.{{ $key }}.answer" cols="30" rows="5" class="w-full border-2 border-gray-700 form-textarea"></textarea>
        @else
        @if (!$item['options'])
        <input type="text" class="w-full border-2 border-gray-700 form-input" placeholder="Your answer..." wire:model="answers.{{ $key }}.answer" >
        @endif
        @endif
        </div>
        @endforeach
        @error('answers')
            <h1 class="mx-5 mt-2 text-sm italic text-right text-red-600">{{ $message }}</h1>
        @enderror
        @if (!$task->deadline || $task->deadline > now())
        <button wire:click.prevent="submitAnswers" class="float-right p-2 mx-5 mt-3 font-semibold text-white hover:text-primary-600 bg-primary-500">Submit Answers</button>
        @endif
    @else
        <div class="mx-5 mt-5">
            <h1>You have already submitted.</h1>
        <div class="mt-5"><a href="{{ route('preview-submission', ['submission'=>$hasSubmission->pivot->id]) }}" class="p-2 text-sm font-semibold text-white bg-primary-500 hover:bg-primary-600">View Submission</a></div>
        </div>
    @endif

</div>
@section('sidebar')
    @include('includes.student.sidebar')
@endsection