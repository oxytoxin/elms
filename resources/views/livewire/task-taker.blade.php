<div>
    <x-loading wire:loading.grid wire:target="submitAnswers" message="Submitting Answers..." />
    <h1 class="text-2xl font-semibold uppercase">{{ $task->task_type->name }}</h1>
    <div class="mt-5 uppercase">
        <h1><span class="font-semibold">Task: </span>{{ $task->name }}</h1>
        <h1><span class="font-semibold">Course: </span>{{ $task->course->name }}</span></h1>
        <h1><span class="font-semibold">Module: </span><span class="text-orange-500">{{ $task->module->name }}</span></h1>
        <h1><span class="font-semibold">Deadline: </span><span class="text-red-600">{{ $task->deadline ? $task->deadline->format('M d, Y - h:i a') : "No deadline set." }}</span></h1>
        @if ($hasExtension)
        <h1><span class="font-semibold">Extended until: </span><span class="text-red-600">{{ $hasExtension->deadline->format('M d, Y - h:i a') }}</span></h1>
        @endif
        <h1 class="font-semibold">Instructions:</h1>
        <p class="not-italic font-normal normal-case">{{ $task->instructions }}</p>
    </div>
    @if ($matchingTypeOptions)
    <div class="p-2 bg-green-300">
        <h1 class="font-semibold">OPTIONS</h1>
        <div class="flex flex-wrap p-2 my-2 justify-evenly">
            @forelse ($matchingTypeOptions as $g => $option)
            <h1 class="mx-5 my-2">{{ $option }}</h1>
            @empty
            <h1>No matching type options added.</h1>
            @endforelse
        </div>
    </div>
    @endif
    <div>
        @if (!$hasSubmission)
        @foreach ($task_content as $key => $item)
        <div class="p-2
        @if ($hasAttempted && in_array($item['item_no'],$unanswered))
        {{ 'bg-red-300' }}
        @endif
         mt-3 border border-gray-700 rounded-lg shadow-lg">
            <h1 class="flex justify-between font-semibold text-orange-500"><span>Question {{ $key+1 }}. {{ $this->getIdentifier($item) }}</span><span>({{ $item['points'] }} pt/s. {{ $item['enumeration'] ? 'each' : '' }})</span></h1>
            <hr class="my-2 border-t-2 border-primary-600">
            <h1>{{ $item['question'] }}</h1>
            @if ($item['files'])
            <div class="flex justify-center my-3">
                <div class="flex flex-col items-center">
                    @foreach ($item['files'] as $file)
                    <a href="{{ route("file.preview",['id' => $file['google_id']]) }}" target="_blank" class="inline-flex items-center justify-center bg-white border divide-x-2 rounded-lg border-primary-600">
                        <span class="p-3" target="_blank">
                            <i class="icofont-ui-file"></i>
                            {{ $file['name'] }}
                        </span>
                    </a>
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
            @if ($item['attachment'])
            <label class="text-xs font-semibold uppercase" for="answer_{{ $key }}_files">Add Attachment</label>
            <div wire:key="filepond-{{ $key }}">
                <x-filepond wire:key="filebrowser_{{ $key }}" inputname="answer_{{ $key }}_files" type="file" required wire:model="answers.{{ $key }}.files" class="w-full form-input" multiple id="answer_{{ $key }}_files" name="answer_{{ $key }}_files" />
            </div>
            @endif
            @if ($item['essay'])
            <textarea wire:key="item_{{ $key }}_textarea" placeholder="Your answer..." wire:model="answers.{{ $key }}.answer" cols="30" rows="5" class="w-full border-2 border-gray-700 form-textarea"></textarea>
            @elseif($item['enumeration'])
            @if (session("enumError.$key"))
            <h1 class="my-2 text-sm italic text-red-600">{{ session("enumError.$key") }}</h1>
            @endif
            <div class="flex flex-col space-y-2">
                @foreach ($item['enumerationItems'] as $enum => $enumItem)
                <input type="text" class="w-full border-2 border-gray-700 form-input" placeholder="Your answer..." wire:model.lazy="enumeration.{{ $key }}.items.{{ $enum }}">
                @endforeach
            </div>
            @else
            @if (!$item['options'])
            <input type="text" class="w-full border-2 border-gray-700 form-input" placeholder="Your answer..." wire:model="answers.{{ $key }}.answer">
            @endif
            @endif
        </div>
        @endforeach

        <h1 class="mx-5 mt-2 text-sm italic text-right text-red-600">
            @if(session('deadline'))
            {{ session('deadline') }}
            @endif
        </h1>
        @can('submit', $task)
        <button onclick="confirm('Submit your answers?') || event.stopImmediatePropagation() " wire:click.prevent="submitAnswers" class="float-right p-2 mt-3 font-semibold text-white hover:text-primary-600 bg-primary-500">Submit Answers</button>
        @endcan
        @else
        <div class="mx-5 mt-5">
            <h1>You have already submitted.</h1>
            <div class="mt-5"><a href="{{ route('preview-submission', ['submission'=>$hasSubmission->pivot->id]) }}" class="p-2 text-sm font-semibold text-white bg-primary-500 hover:bg-primary-600">View Submission</a></div>
        </div>
        @endif
    </div>
</div>
@section('sidebar')
@include('includes.student.sidebar')
@endsection
