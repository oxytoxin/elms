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
                    {{ session('max_criteria') }}
                </div>
                @endif
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