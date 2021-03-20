<div>
    <h1 class="text-2xl font-semibold">TASK PREVIEW</h1>
    <div class="p-2 m-4 shadow">
        <h1>For Course: <span class="italic">{{ $task->course->name }}</span></h1>
        <h1>For Module: <span class="italic">{{ $task->module->name }}</span></h1>
        <h1>Task Type: {{ strtoupper($task->task_type->name) }}</h1>
        <label for="task_name">Task Name:</label>
        <h1>{{ $task->name }}</h1>
        <label for="task_instructions">Instructions:</label>
        <p>{{ $task->instructions }}</p>
        <h1>Date Due: {{ $task->deadline ? $task->deadline->format('M d, Y - h:i a') : 'No deadline set.' }}</h1>
        @if (!$task->open && $task->open_on)
        <h1>Task Opens On: {{ $task->open_on->format('M d, Y - h:i a') }}</h1>
        @endif
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
        <hr class="border border-primary-600">
        <div class="py-5 bg-white">
            @foreach ($task_content as $key => $item)
            <div class="p-2 mt-3 border border-gray-700 rounded-lg shadow-lg">
                <h1 class="flex justify-between font-semibold text-orange-500"><span>Question {{ $key+1 }}. {{ $item['essay'] ? '(Essay)' : ($item['enumeration'] ? '(Enumeration)' : '') }}</span><span>({{ $item['points'] }} pt/s. {{ $item['enumeration'] ? 'each' : '' }})</span></h1>
                <hr class="my-2 border-t-2 border-primary-600">
                <h1>{{ $item['question'] }}</h1>
                @if ($item['files'])
                <div class="flex justify-center my-3">
                    <div class="flex flex-col items-center">
                        @foreach ($item['files'] as $file)
                        <a href="{{ asset('storage'.'/'.$file['url']) }}" target="_blank" class="inline-flex items-center justify-center bg-white border divide-x-2 rounded-lg">
                            <span class="p-3" target="_blank">
                                <i class="icofont-ui-file"></i>
                                {{ $file['name'] }}
                            </span>
                            <span class="p-3 text-white rounded-r-lg hover:text-primary-600 bg-primary-500">
                                <i class="icofont-download-alt"></i>
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                @forelse ($item['options'] as $id=>$option)
                <div>
                    <input disabled type="radio" wire:model="answers.{{ $key }}.answer" id="answer_{{ $item['item_no'] }}_{{ $option }}" name="answer_{{ $item['item_no'] }}" value="{{ $option }}" class="form-radio">
                    <label for="answer_{{ $item['item_no'] }}_{{ $option }}">{{ $option }}</label>
                </div>
                @empty

                @endforelse
                @if ($item['attachment'])
                <label class="text-xs font-semibold uppercase" for="answer_{{ $key }}_files">Add Attachment</label>
                <div wire:key="filepond-{{ $key }}">
                    <x-filepond disabled wire:key="filebrowser_{{ $key }}" inputname="answer_{{ $key }}_files" type="file" required wire:model="answers.{{ $key }}.files" class="w-full form-input" multiple id="answer_{{ $key }}_files" name="answer_{{ $key }}_files" />
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
                    <input disabled type="text" class="w-full border-2 border-gray-700 form-input" placeholder="Your answer..." wire:model.lazy="enumeration.{{ $key }}.items.{{ $enum }}">
                    @endforeach
                </div>
                @else
                @if (!$item['options'])
                <input disabled type="text" class="w-full border-2 border-gray-700 form-input" placeholder="Your answer..." wire:model="answers.{{ $key }}.answer">
                @endif
                @endif
            </div>
            @endforeach
        </div>
        <div class="flex flex-col items-center p-4 md:flex-row">
            <span class="w-full p-2 my-1 font-semibold text-center text-white bg-orange-500 rounded-lg md:w-auto">Total points: {{ $task->max_score }}</span>
        </div>
    </div>

</div>
@section('sidebar')
@include('includes.teacher.sidebar')
@endsection
