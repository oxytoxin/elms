<div class="p-2 m-4 shadow">
    <h1 class="text-xl font-semibold">TASK CREATOR</h1>
    <h1>For Module: <span class="italic">{{ $module->name }}</span></h1>
    <h1>Task Type: {{ strtoupper($type) }}</h1>
    <h1>Date Due:</h1>
    @dump($items)
    <i class="fas fa-spin fa-spinner" wire:loading></i>
    <input type="date" wire:model.defer="date_due" class="m-2 form-input" name="date_due" id="date_due">
    <input type="time" wire:model.defer="time_due" class="m-2 form-input" name="time_due" id="time_due">
    @foreach ($items as $key => $item)
        <div class="p-2 m-2 {{ $key%2 ? 'bg-primary-500 text-white' : '' }} relative shadow-lg">
            <div class="absolute right-0 pr-2"><i wire:click.prevent="removeItem({{ $key }})" class="text-red-600 cursor-pointer icofont-close"></i></div>
            <label for="question_{{ $key+1 }}">Question {{ $key + 1 }}</label>
            <div class="flex">
                <input type="number" wire:model.defer="items.{{ $key }}.points" class="w-28 mr-2 {{ $key%2 ? 'text-black' : '' }} form-input">
                <input type="text" placeholder="Enter your question or instruction..." wire:model.defer="items.{{ $key }}.question" class="w-full {{ $key%2 ? 'text-black' : '' }} form-input">
            </div>
            @error("items.$key.question")
                <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror
            @error("items.$key.points")
                <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror

            @forelse ($item['files'] as $file)
            @if (!is_string($file))
            <img src="{{ $file->temporaryUrl() }}" class="inline-block w-20 mt-2">
            @endif
            @empty

            @endforelse
            <div>
                <div class="flex my-2">
                    <button class="focus:outline-none" wire:click.prevent="addOption({{ $key }})"><i class="mr-2 icofont-plus-circle"></i>Add Option</button>
                    <input type="file" id="item_{{ $key }}_files" class="ml-3 form-input {{ $key%2 ? 'text-black' : '' }}" wire:model="items.{{ $key }}.files" multiple>
                </div>
               <div class="flex flex-col">
                @foreach ($item['options'] as $id=>$option)
                <div class="flex items-center w-full mt-2">
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