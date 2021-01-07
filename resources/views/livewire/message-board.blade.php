<div class="flex flex-col h-full">
    <h1 wire:click="$refresh" class="text-2xl font-semibold">MESSAGES</h1>
    <div class="grid flex-grow h-0 grid-cols-3 grid-rows-1 mt-5 bg-gray-600 border border-primary-600">
        <div class="flex flex-col col-span-2 row-span-1 bg-white">
            @if ($contact)
            <div class="flex items-center h-16 p-2 mb-3 space-x-2 text-xl text-white bg-primary-500">
                <img src="{{ $contact->profile_photo_url }}" class="w-12 h-12 rounded-full">
                <h1>{{ $contact->name }}</h1>
            </div>
            <div class="flex flex-col-reverse flex-grow p-2 space-y-2 overflow-y-auto">
                @forelse ($messages as $message)
                    @if ($message->user_role == "receiver")
                    <div class="flex items-start w-3/5 my-2 space-x-2">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="profile_photo" class="w-8 h-8 border border-gray-500 rounded-full">
                        <span class="flex p-2 break-words bg-gray-200 rounded-lg max-w-max-content">
                            <p class="overflow-x-hidden">{{ $message->message }}</p>
                        </span>
                    </div>
                    @else
                    <span class="flex flex-row-reverse items-start self-end justify-start w-3/5 my-2">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="profile_photo" class="w-8 h-8 ml-2 border border-gray-500 rounded-full">
                        <span class="flex p-2 text-white break-words bg-blue-600 rounded-lg max-w-max-content">
                            <p class="overflow-x-hidden">{{ $message->message }}</p>
                        </span>
                    </span>
                    @endif

                @empty
                    <div class="flex items-center justify-center flex-grow">
                        <h1>No messages. Send a message now...</h1>
                    </div>
                @endforelse
            </div>
            <div class="grid grid-cols-6 gap-2 p-3 bg-primary-500">
                <textarea wire:keydown.enter.prevent="sendMessage" wire:model.lazy="message" style="caret-color: green;" name="messagebox" id="messagebox" cols="30" rows="1" class="col-span-5 resize-none form-textarea"></textarea>
                <button wire:click="sendMessage" class="text-white bg-blue-600 rounded-lg hover:bg-blue-500">SEND <i class="fas fa-paper-plane"></i></button>
            </div>
            @else
            <div class="flex items-center justify-center flex-grow">
                <h1>Select a contact to view conversation</h1>
            </div>
            @endif
        </div>
        @livewire('message-contacts')
    </div>
</div>

@section('sidebar')
    @switch(session('whereami'))
        @case('student')
            @include('includes.student.sidebar')
            @break
        @case('teacher')
            @include('includes.teacher.sidebar')
            @break
        @case('programhead')
            @include('includes.head.sidebar')
            @break
        @default
    @endswitch
@endsection