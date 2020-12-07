<div x-data="{showrubric: @entangle('showrubric')}" class="p-2 m-4 text-sm shadow">
    <h1 class="text-xl font-semibold">TASK CREATOR</h1>
    <br>
    <h1>For Course: <span class="italic">{{ $module->course->name }}</span></h1>
    <h1>For Module: <span class="italic">{{ $module->name }}</span></h1>
    <h1>For Section: <span class="italic">{{ $module->section->code }}</span></h1>
    <h1>Task Type: {{ strtoupper($type) }}</h1>
    <br>
    <label for="task_name">Task Name:</label>
    <input type="text" wire:model.defer="task_name" placeholder="Enter task name..." class="w-full form-input">
    @error("task_name")
    <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
    @enderror
    <h1>Date Due:</h1>
    <i class="fas fa-spin fa-spinner" wire:loading></i>
    <input type="date" wire:model.defer="date_due" class="m-2 form-input" name="date_due" id="date_due">
    <input type="time" wire:model.defer="time_due" class="m-2 form-input" name="time_due" id="time_due">
    <hr class="border border-primary-600">
        @foreach ($items as $key => $item)
            <div wire:key="item_{{ $key }}" class="p-2 m-2 {{ $key%2 ? 'bg-primary-500 text-white' : '' }} relative shadow-lg">
                @if ($key != 0)
                    <div class="absolute right-0 pr-2"><i wire:click.prevent="removeItem({{ $key }})" class="text-red-600 cursor-pointer icofont-close"></i></div>
                @endif
                <input type="number" wire:model="items.{{ $key }}.points" class="w-28 mr-2 {{ $key%2 ? 'text-black' : '' }} form-input">
                <span class="mr-2">(points)</span>
                <label for="question_{{ $key+1 }}"><i class="mr-2 icofont-question-circle"></i>Question {{ $key + 1 }}</label>
                <div class="flex items-center my-2">
                    <input type="text" placeholder="Enter your question or instruction..." wire:model.defer="items.{{ $key }}.question" class="w-full {{ $key%2 ? 'text-black' : '' }} form-input">
                </div>
                @error("items.$key.question")
                    <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                @enderror
                @error("items.$key.points")
                    <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                @enderror

                <div>
                    <input type="file" id="item_{{ $key }}_files" class="w-full form-input {{ $key%2 ? 'text-black' : '' }}" wire:model="files.{{ $key }}.fileArray" multiple>
                        <div class="flex flex-col items-center mt-2 text-white md:flex-row">
                            <button class="w-full p-2 my-1 whitespace-no-wrap bg-gray-500 rounded-lg md:w-auto hover:bg-green-300 focus:outline-none hover:text-primary-600" wire:click.prevent="addOption({{ $key }})"><i class="mr-1 icofont-plus-circle"></i>Add Option</button>
                            <button wire:click="TorFtrigger({{ $key }})" class="p-2 w-full md:w-auto my-1 md:ml-3 hover:text-primary-600 bg-gray-500 {{ $item['torf'] ? 'bg-primary-600' : 'bg-gray-500' }} rounded-lg hover:bg-green-300"><i class="icofont-check"></i>True or False?</button>
                            <button wire:click="Essaytrigger({{ $key }})" class="p-2 w-full md:w-auto my-1 md:ml-3 hover:text-primary-600 bg-gray-500 {{ $item['essay'] ? 'bg-primary-600' : 'bg-gray-500' }} rounded-lg hover:bg-green-300"><i class="icofont-file-document"></i>Essay</button>
                            <button wire:click="ExpectAttachment({{ $key }})" class="p-2 w-full md:w-auto my-1 md:ml-3 hover:text-primary-600 bg-gray-500 {{ $item['attachment'] ? 'bg-primary-600' : 'bg-gray-500' }} rounded-lg hover:bg-green-300"><i class="icofont-attachment"></i>Require File Attachment?</button>
                        </div>
                   <div class="flex flex-col">
                    @if (count($item['options']))
                        <h1 class="text-sm italic">Double check that the correct option is selected.</h1>
                        @error("items.$key.answer")
                        <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                        @enderror
                    @endif
                    @foreach ($item['options'] as $id=>$option)
                    <div class="relative flex items-center w-full mt-2">
                        <input type="radio" wire:model="items.{{ $key }}.answer" name="item_{{ $key }}_answer" class="mr-2 form-radio" value="{{ $id }}">
                        <input placeholder="Enter an option..." wire:model.defer="items.{{ $key }}.options.{{ $id }}" type="text" class="form-input flex-1 {{ $key%2 ? 'text-black' : '' }}" name="option">
                        <i class="absolute ml-2 text-2xl text-red-600 cursor-pointer inset-y-2 right-1 icofont-trash" wire:click.prevent="removeOption({{ $key }},{{ $id }})"></i>
                    </div>
                    @error("items.$key.options.$id")
                    <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                    @enderror
                    @endforeach
                   </div>
                </div>
            </div>
        @endforeach
        <div class="flex flex-col items-center p-4 md:flex-row">
            <button class="w-full p-2 my-1 text-white whitespace-no-wrap bg-gray-500 rounded-lg md:w-auto focus:outline-none hover:bg-green-300 hover:text-primary-600" wire:click.prevent="addItem({{ count($items) }})"><i class="mr-2 icofont-plus-circle"></i>Add Item</button>
            <span class="w-full p-2 my-1 font-semibold text-center text-white bg-orange-500 rounded-lg md:ml-3 md:w-auto">Total points: {{ $total_points }}</span>
            <button wire:click.prevent="saveTask" class="w-full p-2 px-5 my-1 text-white rounded-lg md:ml-3 md:w-auto hover:text-primary-600 bg-primary-500 focus:outline-none">Submit Task</button>
        </div>
        <div x-cloak x-show.transition="showrubric" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500 bg-opacity-50">
            <div class="relative mx-5 overflow-hidden bg-white rounded-lg shadow-lg md:w-1/2 min-h-halfscreen">
                <div class="p-3">
                    <h1>This task contains an essay item and requires you to set a rubric for grading.</h1>
                    <hr class="border border-primary-600">
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
                                    <td class="px-2 py-4 text-center border-2 border-primary-600"><i wire:click="editCriterionWeight({{ $id }})" class="mx-2 cursor-pointer hover:text-primary-600 icofont-ui-edit text-primary-500"></i>{{ $criterion['weight'] }}%</td>
                                    <td class="text-center border-2 border-primary-600"><i wire:click="editCriterionName({{ $id }})" class="mx-2 cursor-pointer hover:text-primary-600 icofont-ui-edit text-primary-500"></i>{{ $criterion['name'] }}</td>
                                    @foreach ($rubric['performance_rating'] as $key => $rating)
                                        <td class="text-center border-2 border-primary-600">{{ $this->getRating($key) }}%</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button wire:click.prevent="equalWeights" class="p-2 my-1 text-orange-600 bg-yellow-300 hover:bg-yellow-400">Set Equal Weights</button>
                    <button wire:click.prevent="resetRubric" class="p-2 my-1 text-white bg-red-600 hover:bg-red-700">Reset to default</button>
                    <div class="mt-3 control-panel">
                        <div class="py-3 border-b-2 border-primary-600">
                            <h1 class="text-xs font-semibold"><i class="mr-1 icofont-info-circle text-yellow"></i>Note: Adding items resets their weights to equal percentages.</h1>
                            @if (session()->has('max_criteria'))
                            <div class="text-xs italic text-red-600">
                                {{ session('max_elements') }}
                            </div>
                            @endif
                            @error('new_criterion')
                            <h1 class="text-sm italic text-red-600">{{ $message }}</h1>
                            @enderror
                            @error('new_performance_rating')
                            <h1 class="text-sm italic text-red-600">{{ $message }}</h1>
                            @enderror
                            <div class="flex flex-col mt-2 md:flex-row">
                                <input wire:model.lazy="new_criterion" type="text" class="flex-1 mr-2 form-input" placeholder="Your new criterion...">
                                <button wire:click.prevent="addCriterion" class="self-end w-full p-2 px-10 mt-2 font-semibold text-white md:mt-0 md:w-auto bg-primary-500 hover:bg-primary-600">ADD CRITERION</button>
                            </div>
                            <div class="flex flex-col mt-2 md:flex-row">
                                <input wire:model.lazy="new_performance_rating" type="text" class="flex-1 mr-2 form-input" placeholder="Your new performance rating...">
                                <button wire:click.prevent="addPerformanceRating" class="self-end w-full p-2 px-10 mt-2 font-semibold text-white md:mt-0 md:w-auto bg-primary-500 hover:bg-primary-600">ADD PERFORMANCE RATING</button>
                            </div>
                        </div>
                        <div>
                            @if (session()->has('weights_error'))
                            <div class="mt-2 text-xs italic font-semibold text-red-600">
                                {{ session('weights_error') }}
                            </div>
                            @endif
                        </div>
                        <button wire:click.prevent="saveRubric" class="p-3 px-10 mt-2 font-semibold text-white bg-primary-500 hover:bg-primary-600">SAVE RUBRIC</button>
                        <button wire:click="hideRubricEdit" class="p-3 px-10 mt-2 font-semibold text-white bg-primary-500 hover:bg-primary-600">CANCEL</button>
                    </div>
                </div>
                <div x-data="{showEdit: @entangle('showEdit')}" x-cloak x-show.transition="showEdit" class="absolute inset-0 flex flex-col items-center justify-center px-3 bg-blue-400 bg-opacity-50">
                    <h1 class="p-3 my-4 bg-white rounded-lg">{{ $this->editDialogTitle }}</h1>
                    <input wire:model.lazy="editDialogInputValue" type="text" class="w-full p-2 form-input" value="{{ $editDialogInputValue }}">
                    @error('editDialogInputValue')
                        <h1 class="text-sm italic text-red-600">{{ $message }}</h1>
                    @enderror
                    <div>
                        <button wire:click.prevent="updateValues" class="p-3 px-10 mt-3 font-semibold text-white bg-primary-500 hover:bg-primary-600">SAVE</button>
                        <button @click="showEdit = false" class="p-3 px-10 mt-3 font-semibold text-white bg-primary-500 hover:bg-primary-600">CANCEL</button>
                    </div>
                </div>
            </div>
        </div>
</div>

@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection
@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded',function(){
            Livewire.on('item-added', () => {
                window.scrollTo(0,document.body.scrollHeight);
        })
        })
    </script>
@endpush