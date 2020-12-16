<div class="m-5" x-data="{uiEssay:@entangle('uiEssay')}">
    @dump($items)
    <div x-show.transition="uiEssay" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-50">
        @if ($rubric && $essay_item)
        <div @click.away="uiEssay=false" id="essay_gradesheet" class="p-4 mx-3 overflow-auto bg-white rounded-lg shadow md:mx-0 md:w-1/2 min-h-halfscreen">
            <div class="flex justify-between">
                <h1 class="italic">Question: {{ $task_content[$essay_item]['question'] }}</h1>
            <h1 class="text-sm font-semibold">{{ $task_content[$essay_item]['essay'] ? "(Student's answer word count: ".str_word_count($answers[$essay_item]['answer'])." word/s)" : '' }}</h1>
            </div>
            <hr class="my-1 border border-primary-600">
            {{-- <p class="text-sm">{{ $answers[$essay_item]['answer'] }}</p> --}}
            <div class="w-full overflow-auto">
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
                                <td class="text-center border-2 border-primary-600"><input wire:model="weights.{{ $id }}" {{ $loop->index == 0 ? 'checked' : '' }} type="radio" name="{{ $criterion['name']."-rating" }}" value="{{ $this->getRating($key) }}" class="mr-1 border border-gray-600 cursor-pointer form-radio" id="">{{ $this->getRating($key) }}%</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="my-2 text-sm">
                <h1>Max score: <span class="font-semibold">{{ $essay_maxscore }} pts</span></h1>
                {{-- <h1>Student score: <span class="font-semibold">{{ $items[$essay_item]['score'] }} pts</span></h1> --}}
                <div class="my-1">
                    <button @click="uiEssay=false" class="px-2 py-1 mb-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-800">CANCEL</button>
                    <button @click="uiEssay=false" wire:click="gradeEssay" class="px-2 py-1 mb-2 text-xs font-semibold text-white bg-primary-500 hover:bg-primary-600">GRADE</button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <h1 class="text-2xl font-semibold">Grade Task Submission</h1>
    <h1 class="font-semibold uppercase"><span>{{ $task->task_type->name }} |</span> {{ $task->name }}</h1>
    <h1 class="italic font-semibold uppercase">COURSE: <span class="text-orange-500">{{ $task->module->name }}</span></h1>
    <div class="flex flex-col my-2 text-sm md:flex-row md:justify-between">
        <div>
            <h1>Task max score: <span class="font-bold">{{ $task->max_score }} pts</span></h1>
            <h1>Student score: <span class="font-bold">{{ $this->getTotalScore() }} pts</span></h1>
        </div>
    </div>
    <div class="flex flex-col items-center justify-center md:flex-row">
        <h1 class="text-sm font-semibold uppercase"><i class="ml-4 mr-2 text-green-400 text-opacity-50 icofont-square"></i>Correct/Partial</h1>
        <h1 class="text-sm font-semibold uppercase"><i class="ml-4 mr-2 text-yellow-300 text-opacity-50 icofont-square"></i>UnGraded</h1>
        <h1 class="text-sm font-semibold uppercase"><i class="ml-4 mr-2 text-red-400 text-opacity-50 icofont-square"></i>Wrong</h1>
    </div>
    @foreach ($task_content as $key => $item)
    <div class="p-2 mx-5 mt-3 {{ $items[$key] ? ($items[$key]['isCorrect'] ? 'bg-green-400 bg-opacity-50' : 'bg-red-400 bg-opacity-50') : 'bg-yellow-300 bg-opacity-50'  }} border border-gray-700 rounded-lg shadow-lg">
        @if ($item['essay'])
        <button wire:click="showEssayGrader({{ $key }})" class="px-2 py-1 mb-2 text-xs font-semibold text-white bg-primary-500 hover:bg-primary-600">GRADE</button>
        @else
        <div>
            <button wire:click="markAsCorrect({{ $key }})" class="px-2 py-1 mb-2 text-xs font-semibold text-white bg-primary-500 hover:bg-primary-600">CORRECT</button>
            <button wire:click="markAsWrong({{ $key }})" class="px-2 py-1 mb-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-800">WRONG</button>
            @if($item['attachment'])
            <div>
                <input type="number" placeholder="Partial Score..." wire:model="partial.{{ $key }}" class="py-1 text-xs form-input">
                <button wire:click="partialPoints({{ $key }})" class="px-2 py-1 mt-2 mb-2 text-xs font-semibold text-white md:mt-0 bg-primary-500 hover:bg-primary-600">PARTIAL</button>
            </div>
            @endif
        </div>
        @endif
        @if (session()->has("partialError$key"))
        <div class="text-xs italic text-red-600">
            {{ session("partialError$key") }}
        </div>
        @endif
        <h1 class="flex justify-between font-semibold text-orange-500"><span>Question {{ $item['item_no'] }}. {{ $item['essay'] ? '(Essay)' : "" }}</span> <span>{{ $item['points'] }} pt/s.</span></h1>
        <h1 class="px-5">{{ $item['question'] }}</h1>
        @if ($item['files'])
        <div class="flex justify-center my-3">
            @foreach ($item['files'] as $file)
            <div class="flex flex-col items-center">
                <a target="blank" href="{{ asset('storage'.'/'.$file['url']) }}" class="text-sm italic underline text-primary-500">View Attachment: {{ $file['name'] }}</a>
            </div>
        @endforeach
        </div>
    @endif

    @isset($answers[$key]['files'])
        <div class="p-3 my-2 bg-white border shadow">
            <h1 class="text-sm font-semibold uppercase">Student Attachments:</h1>
            @foreach ($answers[$key]['files'] as $file)
                <a target="blank" href="{{ asset('storage'.'/'.$file['url']) }}" class="text-sm italic underline text-primary-500">{{ is_array($file) ? $file['name'] : $file->getClientOriginalName() }}</a>
            @endforeach
        </div>
    @endisset
    <hr class="my-2 border border-primary-600">
    @isset($answers[$key]['answer'])
    <div class="flex justify-around my-2">
        @isset($item['answer'])
        <div class="w-full">
            <h1 class="text-sm font-semibold">Correct answer:</h1>
            <p>{{ $item['answer'] }}</p>
        </div>
        @endisset
        <div class="w-full">
            <h1 class="text-sm font-semibold">Student answered: {{ $item['essay'] ? "(Word count: ".str_word_count($answers[$key]['answer']).")" : '' }}</h1>
            <p>{{ $answers[$key]['answer'] }}</p>
        </div>
    </div>
    @endisset
    <span class="p-1 text-xs font-bold text-white bg-primary-500">Score: {{ $items[$key]['score'] ?? 0 }} pts</span>
</div>
@endforeach
    @if($this->verifyItems())
    <button wire:click="finishGrading" class="float-right p-3 mt-5 mr-5 font-semibold text-white bg-primary-500 hover:bg-primary-600">FINISH GRADING</button>
    @endif
</div>

@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection