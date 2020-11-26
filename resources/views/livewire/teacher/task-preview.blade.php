<div class="p-2 m-4 shadow">
    <h1 class="text-xl font-semibold">TASK PREVIEW</h1>
    <br>
    <h1>For Course: <span class="italic">{{ $task->course->name }}</span></h1>
    <h1>For Module: <span class="italic">{{ $task->module->name }}</span></h1>
    <h1>Task Type: {{ strtoupper($task->task_type->name) }}</h1>
    <br>
    <label for="task_name">Task Name:</label>
    <span>{{ $task->name }}</span>
    <h1>Date Due: {{ $task->deadline->format('M d, Y') }}</h1>
        @if ($rubric)
        <hr class="border border-primary-600">
        <div class="w-full my-2 overflow-auto">
            <h1 class="font-semibold text-center">Rubrics for Grading Essay</h1>
            <table class="table w-full mt-3 border-2 border-collapse table-auto border-primary-600">
                <thead>
                    <tr>
                        <th rowspan="2" class="px-3 border-2 border-primary-600">Weight</th>
                        <th rowspan="2" class="px-3 border-2 border-primary-600">Criteria</th>
                        <th colspan="{{ count($rubric['performance_rating']) }}" class="border-2 border-primary-600">Performance Rating</th>
                    </tr>
                    <tr>
                        @foreach ($rubric['performance_rating'] as $rating)
                        <th class="px-3 border-2 border-primary-600">{{ $rating }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rubric['criteria'] as $id => $criterion)
                    <tr>
                        <td class="px-2 py-4 text-center border-2 border-primary-600">{{ $criterion['weight'] }}%</td>
                        <td class="text-center border-2 border-primary-600">{{ $criterion['name'] }}</td>
                        @foreach ($rubric['performance_rating'] as $key => $rating)
                            <td class="text-center border-2 border-primary-600">{{ $this->getRating($key) }}%</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    <hr class="border border-primary-600">
    <div class="py-5 bg-white">
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
            <div class="flex items-center">
                <input type="radio" readonly id="answer_{{ $item['item_no'] }}_{{ $option }}" name="answer_{{ $item['item_no'] }}" value="{{ $option }}" class="mr-1 form-radio">
                <label for="answer_{{ $item['item_no'] }}_{{ $option }}">{{ $option }}</label>
            </div>
        @empty

        @endforelse

        @if ($item['options'])
        <br>
        <h1>Correct Answer: <span class="font-semibold">{{ $item['answer'] }}</span></h1>
        @endif
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
        <input type="file" disabled name="answer_{{ $key }}_files" id="answer_{{ $key }}_files" multiple class="w-full my-2 form-input">
        @endif
        @if ($item['essay'])
        <textarea wire:key="item_{{ $key }}_textarea" placeholder="Your answer..." cols="30" rows="5" class="w-full border-2 border-gray-700 form-textarea"></textarea>
        @else
        @if (!$item['options'])
        <input type="text" class="w-full border-2 border-gray-700 form-input" placeholder="Your answer...">
        @endif
        @endif
        </div>
@endforeach
    </div>
    <div class="flex flex-col items-center p-4 md:flex-row">
        <span class="w-full p-2 my-1 font-semibold text-center text-white bg-orange-500 rounded-lg md:w-auto">Total points: {{ $task->max_score }}</span>
    </div>
</div>

@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection