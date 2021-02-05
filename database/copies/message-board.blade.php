<div class="flex flex-col h-full">
    <h1 class="text-2xl font-semibold">MESSAGES</h1>
    <div class="grid flex-grow h-0 grid-cols-3 grid-rows-2 mt-5 bg-gray-600 border md:grid-rows-1 border-primary-600">
        @livewire('message-contacts')
        <div class="flex flex-col col-span-3 row-span-1 bg-white md:order-1 md:col-span-2">
            @if ($contact)
            <div class="flex items-center h-16 p-2 mb-3 space-x-2 text-xl text-white bg-primary-500">
                <div class="w-12 h-12 overflow-hidden border border-gray-500 rounded-full">
                    <img src="{{ $contact->profile_photo_url }}" class="object-cover w-full h-full">
                </div>
                <h1>{{ $contact->name }}</h1>
            </div>
            <div id="messagesContainer" class="flex flex-col-reverse flex-grow p-2 space-y-2 overflow-y-auto">
                @forelse ($messages as $message)
                @if ($message->user_role == "receiver")
                <div class="flex items-start w-3/5 my-2 space-x-1">
                    <div class="flex-shrink-0 w-8 h-8 overflow-hidden border border-gray-500 rounded-full">
                        <img src="{{ $message->complement_owner->profile_photo_url }}" alt="profile_photo" class="object-cover w-full h-full">
                    </div>
                    <span class="flex p-2 break-all bg-gray-200 rounded-lg max-w-max-content">
                        <p class="overflow-x-hidden break-all">{{ $message->message }}</p>
                    </span>
                </div>
                @else
                <div class="flex flex-row-reverse items-start self-end justify-start w-3/5 my-2 space-x-1">
                    <div class="flex-shrink-0 w-8 h-8 ml-1 overflow-hidden border border-gray-500 rounded-full">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="profile_photo" class="object-cover w-full h-full">
                    </div>
                    <span class="flex p-2 text-white break-words bg-blue-600 rounded-lg max-w-max-content">
                        <p class="overflow-x-hidden break-all">{{ $message->message }}</p>
                    </span>
                </div>
                @endif

                @empty
                <div class="flex items-center justify-center flex-grow">
                    <h1>No messages. Send a message now...</h1>
                </div>
                @endforelse
            </div>
            @else
            <div id="messagesContainer" class="flex items-center justify-center flex-grow">
                <h1>Select a contact to view conversation</h1>
            </div>
            @endif
            <form wire:submit.prevent="sendMessage">
                <div class="grid grid-cols-6 gap-2 p-3 bg-primary-500">
                    <div class="relative col-span-5">
                        <textarea wire:model.defer="messageValue" x-ref="inputarea" id="messageInput" wire:key="messageInput" wire:keydown.enter.prevent="sendMessage" style="caret-color: green;" name="messagebox" id="messagebox" cols="30" rows="1" class="w-full h-full resize-none form-textarea">
                        </textarea>
                    </div>
                    <button type="submit" class="text-white bg-blue-600 rounded-lg hover:bg-blue-500">SEND <i class="fas fa-paper-plane"></i></button>
                </div>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', () => {
        let messagesContainer = document.querySelector("#messagesContainer");
        messagesContainer.onscroll = function(ev) {
            if (messagesContainer.scrollTop - messagesContainer.clientHeight <= ((messagesContainer.scrollHeight * -1) + 50)) {
                Livewire.emit("moreMessage");
            }
        };
    });

</script>
@endpush

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
@case('dean')
@include('includes.dean.sidebar')
@break
@default
@endswitch
@endsection
