<div>
    <x-loading wire:loading.grid message="Processing request..." />
    <h1 class="text-2xl font-semibold">TASK CREATOR</h1>
    <div x-data="{showrubric: @entangle('showrubric'), showMatchingTypeOptions: @entangle('showMatchingTypeOptions'), showAddMatchingTypeOption: @entangle('showAddMatchingTypeOption')}" class="p-2 m-4 text-sm shadow">
        <h1>For Course: <span class="italic">{{ $module->course->name }}</span></h1>
        <h1>For Module: <span class="italic">{{ $module->name }}</span></h1>
        <span class="inline-flex items-center p-2 space-x-2 border border-primary-600">
            <input wire:model="allSection" type="checkbox" name="allsections" id="allsections">
            <label for="allsections">Assign to all sections of this course</label>
        </span>
        <h1>For Section: <span class="italic">{{ $allSection ? 'All sections of this course' : $module->section->code }}</span></h1>
        <h1>Task Type: {{ strtoupper($type) }}</h1>
        <label for="task_name">Task Name:</label>
        <input type="text" wire:model.defer="task_name" placeholder="Enter task name..." class="w-full form-input">
        <br>
        <label for="task_instructions">Task Instructions:</label>
        <input type="text" wire:model.defer="task_instructions" placeholder="Enter task instructions..." class="w-full form-input">
        <div>
            @error("task_name")
            <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror
        </div>
        <div class="flex flex-col justify-center my-3">
            <span class="inline-flex items-center">
                <input type="checkbox" wire:model="noDeadline" class="mr-1 form-checkbox" name="noDeadline" id="noDeadline">
                <label for="noDeadline" class="font-bold uppercase text-md">Do not set deadline</label>
            </span>
            <span class="inline-flex items-center">
                <input type="checkbox" wire:model="openImmediately" class="mr-1 form-checkbox" name="openImmediately" id="openImmediately">
                <label for="openImmediately" class="font-bold uppercase text-md">Task Opens Immediately</label>
            </span>
        </div>
        @if (!$noDeadline)
        <div>
            <h1>Date Due: <i class="fas fa-spin fa-spinner" wire:loading></i></h1>
            <div class="flex flex-col md:flex-row">
                <input type="date" wire:model.defer="date_due" class="m-2 form-input" name="date_due" id="date_due">
                <input type="time" wire:model.defer="time_due" class="m-2 form-input" name="time_due" id="time_due">
            </div>
            @error("date_due")
            <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror
            @error("time_due")
            <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror
        </div>
        @endif
        @if (!$openImmediately)
        <h1>Task Opens on:</h1>
        <div class="flex flex-col md:flex-row">
            <input type="date" wire:model.defer="date_open" class="m-2 form-input" name="date_open" id="date_open">
            <input type="time" wire:model.defer="time_open" class="m-2 form-input" name="time_open" id="time_open">
        </div>
        @error("date_open")
        <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
        @enderror
        @error("time_open")
        <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
        @enderror
        @endif
        <button @click="showMatchingTypeOptions = !showMatchingTypeOptions" class="w-full p-2 my-1 text-white rounded-lg bg-primary-500 md:w-auto hover:text-primary-600 hover:bg-green-300">MATCHING TYPE OPTIONS ({{ count($matchingTypeOptions) }} option/s)</button>
        <div class="relative py-3 my-3 bg-green-300" x-show.transition="showMatchingTypeOptions">
            <div>
                <form class="flex items-center p-2 my-2 space-x-2" wire:submit.prevent="addMatchingTypeOption">
                    <input wire:model.lazy="newMatchingTypeOption" placeholder="Enter new option..." type="text" name="newMatchingTypeOption" id="newMatchingTypeOption" class="flex-grow text-sm form-input">
                    <button type="submit" class="w-full p-2 my-1 text-white rounded-lg bg-primary-500 md:w-auto hover:text-primary-600 hover:bg-green-300">ADD</button>
                </form>
            </div>
            <hr class="border-t-2 border-primary-600">
            <div>
                @error("newMatchingTypeOption")
                <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                @enderror
            </div>
            <div class="relative flex flex-wrap p-2 my-2 justify-evenly">
                @forelse ($matchingTypeOptions as $g => $option)
                <h1 class="mx-5 my-2">{{ $option }}<i class="text-red-600 cursor-pointer icofont-close" wire:click="removeMatchingTypeOption({{ $g }})"></i></h1>
                @empty
                <h1>No matching type options added.</h1>
                @endforelse
            </div>
            <i @click="showMatchingTypeOptions = false" class="absolute text-red-600 cursor-pointer hover:text-primary-500 icofont-ui-close top-1 right-1"></i>
        </div>
        <hr class="my-5 border border-primary-600">
        @foreach ($items as $key => $item)
        <div wire:key="item_{{ $key }}" class="p-2 m-2 {{ $errors->has("items.$key.question") ? 'border-red-600 border-2' : '' }} {{ $key%2 ? 'bg-green-400 text-white' : 'bg-white' }} relative shadow-lg">
            @if ($key != 0)
            <div class="absolute right-0 pr-2"><i wire:click.prevent="removeItem({{ $key }})" class="text-red-600 cursor-pointer icofont-close"></i></div>
            @endif

            <div class="flex items-center my-2 space-x-2">
                <div class="flex-grow">
                    <label for="question_{{ $key+1 }}"><i class="mr-2 icofont-question-circle"></i>Question {{ $key + 1 }}</label>
                    <input type="text" placeholder="Enter your question or instruction..." wire:model.defer="items.{{ $key }}.question" class="w-full {{ $key%2 ? 'text-black' : '' }} form-input">
                </div>
                <div>
                    <h1 class="font-semibold">{{ $item['enumeration'] ? "POINTS/ITEM" : "POINTS" }}</h1>
                    <input type="number" wire:model="items.{{ $key }}.points" class="w-28 {{ $key%2 ? 'text-black' : '' }} form-input">
                </div>
            </div>
            <div>
                @error("items.$key.question")
                <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                @enderror
            </div>
            <div>
                @error("items.$key.points")
                <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                @enderror
            </div>

            <div class="my-2">
                <div class="flex space-x-2">
                    @if (!count($item['options']) && !$item['essay'] && !$item['torf'] && !$item['enumeration'])
                    <input type="text" name="items.{{ $key }}.answer" id="items.{{ $key }}.answer" wire:model.defer="items.{{ $key }}.answer" class="flex-grow text-black form-input" placeholder="Correct Answer (Optional)">
                    @endif
                </div>
                {{-- <input type="file" id="item_{{ $key }}_files" class="w-full form-input {{ $key%2 ? 'text-black' : '' }}" wire:model="files.{{ $key }}.fileArray" multiple> --}}
                <div wire:key="filepond-{{ $key }}">
                    <x-filepond inputname="fileinput{{ $key }}" type="file" id="item_{{ $key }}_files" class="w-full form-input {{ $key%2 ? 'text-black' : '' }}" wire:model="files.{{ $key }}.fileArray" multiple />
                </div>
                <div class="flex flex-col items-center mt-2 text-white md:space-x-3 md:flex-row">
                    <span>
                        @if (!$item['essay'] && !$item['torf'] && !$item['enumeration'])
                        <button class="w-full p-2 my-1 bg-gray-500 rounded-lg whitespace-nowrap md:w-auto hover:bg-green-300 focus:outline-none hover:text-primary-600" wire:click.prevent="addOption({{ $key }})"><i class="mr-1 icofont-plus-circle"></i>Add Option</button>
                        @endif
                    </span>
                    <button wire:click="TorFtrigger({{ $key }})" class="p-2 w-full md:w-auto my-1 hover:text-primary-600 {{ $item['torf'] ? 'bg-primary-600' : 'bg-gray-500' }} rounded-lg hover:bg-green-300"><i class="icofont-check"></i>True or False?</button>
                    <button wire:click="Essaytrigger({{ $key }})" class="p-2 w-full md:w-auto my-1 hover:text-primary-600 {{ $item['essay'] ? 'bg-primary-600' : 'bg-gray-500' }} rounded-lg hover:bg-green-300"><i class="icofont-file-document"></i>Essay</button>
                    <button wire:click="ExpectAttachment({{ $key }})" class="p-2 w-full md:w-auto my-1 hover:text-primary-600 {{ $item['attachment'] ? 'bg-primary-600' : 'bg-gray-500' }} rounded-lg hover:bg-green-300"><i class="icofont-attachment"></i>Require File Attachment?</button>
                    <button wire:click="enumerationTrigger({{ $key }})" class="p-2 w-full md:w-auto my-1 hover:text-primary-600 {{ $item['enumeration'] ? 'bg-primary-600' : 'bg-gray-500' }} rounded-lg hover:bg-green-300"><i class="mr-1 icofont-listing-number"></i>Enumeration</button>
                </div>
                @if ($item['enumeration'])
                <div class="my-2 space-y-2">
                    <h1 class="text-sm font-semibold">Enumeration Items <span wire:click="addEnumerationItem({{ $key }})" class="p-1 text-white rounded-full cursor-pointer hover:bg-primary-600 bg-primary-500"><i class="icofont-plus"></i></span></h1>

                    <div class="flex flex-col space-y-2">
                        @foreach ($item['enumerationItems'] as $enum => $enumItem)
                        <div class="relative">
                            <input wire:key="item_{{ $key }}_enum_{{ $enum }}" wire:model.defer="items.{{ $key }}.enumerationItems.{{ $enum }}" type="text" name="items.{{ $key }}.enumerationItems.{{ $enum }}" class="w-full text-xs text-black form-input" placeholder="Enumeration item..." id="items.{{ $key }}.enumerationItems.{{ $enum }}">
                            @if ($enum != 0 && $enum != 1)
                            <i class="absolute ml-2 text-2xl text-red-600 cursor-pointer inset-y-2 right-1 icofont-trash" wire:click.prevent="removeEnumItem({{ $key}},{{ $enum }})"></i>
                            @endif
                        </div>
                        @error("items.$key.enumerationItems.$enum")
                        <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                        @enderror
                        @endforeach
                    </div>
                </div>
                @endif
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
                        <input {{ $option == "True" || $option == "False" ? 'disabled' : '' }} placeholder="Enter an option..." wire:model.defer="items.{{ $key }}.options.{{ $id }}" type="text" class="form-input flex-1 {{ $key%2 ? 'text-black' : '' }}" name="option">
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
            <button class="w-full p-2 my-1 text-white bg-gray-500 rounded-lg whitespace-nowrap md:w-auto focus:outline-none hover:bg-green-300 hover:text-primary-600" wire:click.prevent="addItem({{ count($items) }})"><i class="mr-2 icofont-plus-circle"></i>Add Item</button>
            <span class="w-full p-2 my-1 font-semibold text-center text-white bg-orange-500 rounded-lg md:ml-3 md:w-auto">Total points: {{ $total_points }}</span>
            <button wire:loading.attr="disabled" wire:click.prevent="saveTask" onclick="confirm('Do you want to finalize this task?') || event.stopImmediatePropagation()" class="w-full p-2 px-5 my-1 text-white rounded-lg md:ml-3 md:w-auto hover:text-primary-600 bg-primary-500 focus:outline-none">Submit Task</button>
        </div>
        @if (session('error'))
        <h1 class="mx-4 text-sm italic font-bold text-red-600">{{ session('error') }}</h1>
        @endif
        <div>
            @if ($errors->any())
            <h1 class="mx-4 text-sm italic font-bold text-red-600">Please review each field for errors.</h1>
            @endif
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
                    <div class="my-2">
                        <h1 class="text-xs font-semibold">Total: {{ $rubrics_weight_total }}%</h1>
                        <h1 class="text-xs font-semibold">(Weights should add up to 100.)</h1>
                    </div>
                    <button wire:click.prevent="equalWeights" class="p-2 my-1 text-orange-600 bg-yellow-300 hover:bg-yellow-400">Set Equal Weights</button>
                    <button wire:click.prevent="resetRubric" class="p-2 my-1 text-white bg-red-600 hover:bg-red-700">Reset to default</button>
                    <div class="mt-3 control-panel">
                        <div class="py-3 border-b-2 border-primary-600">
                            <h1 class="text-xs font-semibold"><i class="mr-1 icofont-info-circle text-yellow"></i>Note: Adding items resets their weights to equal percentages.</h1>
                            @if (session()->has('max_elements'))
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
                            <div class="flex flex-col items-center mt-2 md:flex-row">
                                <input wire:model.lazy="new_criterion" type="text" class="flex-1 mr-2 form-input" placeholder="Your new criterion...">
                                <button wire:click.prevent="addCriterion" class="w-full p-2 px-10 mt-2 font-semibold text-white md:mt-0 md:w-auto bg-primary-500 hover:bg-primary-600">ADD CRITERION</button>
                            </div>
                            <div class="flex flex-col items-center mt-2 md:flex-row">
                                <input wire:model.lazy="new_performance_rating" type="text" class="flex-1 mr-2 md:mt-0 form-input" placeholder="Your new performance rating...">
                                <button wire:click.prevent="addPerformanceRating" class="w-full p-2 px-10 mt-2 font-semibold text-white md:mt-0 md:w-auto bg-primary-500 hover:bg-primary-600">ADD PERFORMANCE RATING</button>
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
</div>

@section('sidebar')
@include('includes.teacher.sidebar')
@endsection
@push('scripts')
<script>
    window.addEventListener('DOMContentLoaded', function() {
        Livewire.on('item-added', () => {
            window.scrollTo(0, document.body.scrollHeight);
        })
    })

</script>
@endpush
