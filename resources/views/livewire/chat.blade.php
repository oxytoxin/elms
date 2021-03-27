<div class="flex flex-col w-full h-full">
    <div x-data="{ showSearch : false }" class="grid flex-grow w-full h-0 grid-cols-6 grid-rows-2 bg-gray-400 md:grid-rows-1">
        <div class="flex flex-col h-full col-span-6 bg-gray-300 md:col-span-4">
            <div class="flex items-center h-16 p-2 bg-gray-300">{{ $current_chatroom ?  ($current_chatroom->name ? $current_chatroom->name : $current_chatroom->receiver_name ) : ($newMessageContact ? $newMessageContact['name'] : 'Messages')}}</div>
            <div x-ref="messagesContainer" @scroll="if($refs.messagesContainer.scrollHeight - $refs.messagesContainer.clientHeight <= $refs.messagesContainer.scrollTop * -1 + 5) @this.perPage += 10" class="flex flex-col-reverse flex-grow h-0 p-1 space-y-1 space-y-reverse overflow-y-auto bg-white">
                @forelse ($messages as $message)
                @if ($message->sender_id)
                @if ($message->sender_id == auth()->id())
                <div wire:key="message-{{ $message->id }}" class="flex justify-end ">
                    <h1 class="p-2 text-white break-all bg-blue-500 rounded-md max-w-56 md:max-w-96">{{ $message->message }}</h1>
                </div>
                @else
                <div wire:key="message-{{ $message->id }}">
                    <h1 class="text-xs">{{ $message->sender->name }}</h1>
                    <div class="flex">
                        <h1 class="p-2 break-all bg-gray-300 rounded-md max-w-56 md:max-w-96">{{ $message->message }}</h1>
                    </div>
                </div>
                @endif
                @else
                <div wire:key="message-{{ $message->id }}" class="flex justify-center">
                    <h1 class="text-xs text-gray-600">{{ $message->message }}</h1>
                </div>
                @endif
                @empty
                <div class="grid flex-grow place-items-center">
                    <h1>Start a conversation...</h1>
                </div>
                @endforelse
            </div>
            <form wire:submit.prevent="sendMessage" class="flex p-2 space-x-2">
                <textarea wire:keydown.enter.prevent="sendMessage" wire:model.defer="messageContent" x-ref="messageBox" autofocus placeholder="Say something..." class="flex-grow resize-none form-textarea" cols="30" rows="1"></textarea>
                <button type="submit" class="px-3 text-white bg-blue-600 rounded-lg hover:bg-blue-500">SEND <i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
        <div @click.away="showSearch = false; @this.search = ''; @this.perContacts = 20;" class="flex flex-col h-full col-span-6 bg-gray-300 md:col-span-2">
            <div class="flex items-center justify-between flex-shrink-0 h-16 p-2 text-xl text-white bg-primary-600">
                <span class="flex items-center space-x-2"><i class="text-3xl icofont-address-book"></i><span>Contacts</span></span>
                <i class="cursor-pointer icofont-search hover:text-gray-200" @click="
                showSearch = !showSearch;
                $nextTick(()=> $refs.searchComponent.focus());
                "></i>
            </div>
            <div x-cloak x-show.transition.opacity="showSearch" class="p-1">
                <input wire:model="search" x-ref="searchComponent" autocomplete="off" type="text" name="contactSearch" id="contactSearch" class="w-full form-input" placeholder="Search for name or email...">
            </div>
            <ul x-show.transition.opacity="showSearch" x-ref="contactsContainer" @scroll="if($refs.contactsContainer.scrollTop + $refs.contactsContainer.clientHeight >= $refs.contactsContainer.scrollHeight - 5) @this.perContacts += 10" class="relative flex-grow h-0 overflow-y-auto divide-y-2">
                <div>
                    @if ($search)
                    <div class="absolute top-0 z-30 w-full h-full bg-green-200 divide-y-2">
                        @forelse ($contacts as $contact)
                        <div wire:key="contact-{{ $contact->id }}" @click="$nextTick(()=>{$refs.messageBox.focus()})" wire:click="sendToNewContact({{ $contact }})" class="p-2 bg-gray-200 cursor-pointer hover:bg-gray-400">
                            <div class="flex items-center space-x-2">
                                <div class="relative items-center flex-shrink-0 w-12 h-12 overflow-hidden border border-gray-500 rounded-full max-w-16">
                                    <img class="object-cover w-full h-full" src="{{ $contact->profile_photo_url }}" alt="contact photo">
                                </div>
                                <div class="flex-grow w-0">
                                    <h1 class="text-black">{{ $contact->name }}</h1>
                                    <h1 class="w-full text-sm text-gray-700 truncate">{{ $contact->email }}</h1>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="grid h-full p-3 text-center place-items-center">
                            <h1>No contacts matched your search...</h1>
                        </div>
                        @endforelse
                    </div>
                    @endif
                </div>
                @forelse ($chatrooms as $chatroom)
                <li @click="
                    $nextTick(()=>{
                        $refs.messageBox.focus();
                    });
                " wire:click="changeChatroom({{ $chatroom->id }})" class="p-2 bg-gray-200 cursor-pointer hover:bg-gray-400">
                    <div class="flex items-center space-x-2">
                        <div class="relative items-center flex-shrink-0 w-12 h-12 overflow-hidden border border-gray-500 rounded-full max-w-16">
                            <img class="object-cover w-full h-full" src="{{ $chatroom->isGroup ? asset('img/sksulogo.png') : $chatroom->receiver->profile_photo_url }}" alt="contact photo">
                        </div>
                        <div class="flex-grow w-0">
                            @if ($chatroom->isGroup)
                            <h1 class="text-black">{{ $chatroom->name }}</h1>
                            @else
                            <h1 class="text-black">{{ $chatroom->receiver_name }}</h1>
                            @endif
                            <h1 class="w-full text-xs text-gray-700 truncate">{{ $chatroom->latestMessage->sender_id ? ($chatroom->latestMessage->sender_id == auth()->id() ? 'You:' : $chatroom->latestMessage->sender->shortname.':') : '' }} {{ $chatroom->latestMessage ? $chatroom->latestMessage->message : ''}}</h1>
                        </div>
                    </div>
                </li>
                @empty
                <div class="grid h-full p-3 text-center place-items-center">
                    <h1>No messages found.</h1>
                </div>
                @endforelse
            </ul>
        </div>
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
@case('dean')
@include('includes.dean.sidebar')
@break
@default
@endswitch
@endsection
