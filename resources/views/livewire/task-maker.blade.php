<div class="p-2 m-4 shadow">
    <h1 class="text-xl font-semibold">TASK CREATOR</h1>
    <br>
    <h1>For Module: <span class="italic">{{ $module->name }}</span></h1>
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
        <div class="p-2 m-2 {{ $key%2 ? 'bg-primary-500 text-white' : '' }} relative shadow-lg">
            @if ($key != 0)
                <div class="absolute right-0 pr-2"><i wire:click.prevent="removeItem({{ $key }})" class="text-red-600 cursor-pointer icofont-close"></i></div>
            @endif
            <label for="question_{{ $key+1 }}"><i class="mr-2 icofont-question-circle"></i>Question {{ $key + 1 }}</label>
            <div class="flex items-center my-2">
                <input type="number" wire:model.defer="items.{{ $key }}.points" class="w-28 mr-2 {{ $key%2 ? 'text-black' : '' }} form-input">
                <span class="mr-2">(points)</span>
                <input type="text" placeholder="Enter your question or instruction..." wire:model.defer="items.{{ $key }}.question" class="w-full {{ $key%2 ? 'text-black' : '' }} form-input">
            </div>
            @error("items.$key.question")
                <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror
            @error("items.$key.points")
                <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror

            <div>
                <input type="file" id="item_{{ $key }}_files" class="w-full form-input {{ $key%2 ? 'text-black' : '' }}" wire:model="items.{{ $key }}.files" multiple>
                <div class="flex my-2">
                    <div class="flex items-center mx-3">
                        <button wire:click="TorFtrigger({{ $key }})" class="p-2 bg-gray-500 {{ $item['torf'] ? 'bg-primary-600' : 'bg-gray-500' }} rounded-lg hover:bg-green-300"><i class="icofont-check"></i>True or False?</button>
                    </div>
                    <button class="whitespace-no-wrap focus:outline-none hover:text-primary-600" wire:click.prevent="addOption({{ $key }})"><i class="mr-2 icofont-plus-circle"></i>Add Option</button>

                </div>
               <div class="flex flex-col">
                @if (count($item['options']))
                    <h1 class="text-sm italic">Double check that the correct option is selected.</h1>
                    @error("items.$key.answer")
                    <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                    @enderror
                @endif
                @foreach ($item['options'] as $id=>$option)
                <div class="flex items-center w-full mt-2">
                    <input type="radio" wire:model="items.{{ $key }}.answer" name="item_{{ $key }}_answer" class="mr-2 form-radio" value="{{ $id }}">
                    <input placeholder="Enter an option..." wire:model.defer="items.{{ $key }}.options.{{ $id }}" type="text" class="form-input flex-1 {{ $key%2 ? 'text-black' : '' }}" name="option">
                    <i class="ml-2 text-2xl text-red-600 cursor-pointer icofont-trash" wire:click.prevent="removeOption({{ $key }},{{ $id }})"></i>
                </div>
                @error("items.$key.options.$id")
                <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
                @enderror
                @endforeach
               </div>
            </div>
        </div>
    @endforeach
    <div class="flex items-center p-4">
        <button class="focus:outline-none" wire:click.prevent="addItem({{ count($items) }})"><i class="mr-2 icofont-plus-circle"></i>Add Item</button>
        <span class="p-2 mx-3 font-semibold text-white bg-orange-500">Total points: {{ $total_points }}</span>
        <button wire:click.prevent="$refresh" class="p-2 px-5 ml-3 text-white rounded-lg bg-primary-500 focus:outline-none">Refresh Total Points</button>
        <button wire:click.prevent="saveTask" class="p-2 px-5 ml-3 text-white rounded-lg bg-primary-500 focus:outline-none">Submit Task</button>
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