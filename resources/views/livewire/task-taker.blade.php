<div class="p-5">
    <h1 class="px-5 text-2xl font-semibold uppercase">{{ $task->task_type->name }}</h1>
    <h1 class="px-5 text-xl italic font-semibold uppercase"><span class="text-orange-500">{{ $task->module->name }}</span> | {{ $task->name }}</h1>
@foreach ($task_content as $key => $item)
    <div class="p-2 mx-5 mt-3 border border-gray-700 rounded-lg shadow-lg">
        <h1 class="text-orange-500 underline">({{ $item['points'] }} pt/s.) Question {{ $item['item_no'] }}.</h1>
        <h1>{{ $item['question'] }}</h1>
        @if ($item['files'])
        <div class="flex justify-center my-3">
            @foreach ($item['files'] as $file)
        <div class="flex flex-col items-center">
            <a target="blank" href="{{ asset('storage'.'/'.$file['url']) }}" class="text-sm italic underline text-primary-500">View Attachment: {{ $file['name'] }}</a>
        </div>
        @endforeach
        </div>
    @endif
    @forelse ($item['options'] as $id=>$option)
        <div>
            <input type="radio" wire:model="answers.item_{{ $key }}" id="answer_{{ $item['item_no'] }}_{{ $option }}" name="answer_{{ $item['item_no'] }}" value="{{ $option }}" class="form-radio">
            <label for="answer_{{ $item['item_no'] }}_{{ $option }}">{{ $option }}</label>
        </div>
    @empty
        <br>
        <label class="text-xs font-semibold uppercase" for="answer_{{ $key }}_files">Add Attachment</label>
        <input type="file" name="answer_{{ $key }}_files" id="answer_{{ $key }}_files" multiple class="w-full my-2 form-input">
        <textarea wire:key="item_{{ $key }}_textarea" placeholder="Your answer..." wire:model="answers.item_{{ $key }}" cols="30" rows="5" class="w-full border-2 border-gray-700 form-textarea"></textarea>
    @endforelse
</div>
@endforeach
<button wire:click.prevent="submitAnswers" class="float-right p-2 mx-5 mt-3 font-semibold text-white hover:text-primary-600 bg-primary-500">Submit Answers</button>
</div>
@section('sidebar')
    @include('includes.student.sidebar')
@endsection