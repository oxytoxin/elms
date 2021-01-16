<div class="flex flex-col col-span-3 row-span-1 text-gray-400 bg-white md:order-2 md:col-span-1 md:flex-row" x-data="{showContactSearch:@entangle('showContactSearch')}">
    <div class="flex items-center justify-between flex-shrink-0 h-16 p-2 text-xl text-white bg-primary-600"><span class="flex items-center space-x-2"><i class="text-3xl icofont-address-book"></i><span>Contacts</span></span>
    @if ($showContactSearch)
    <i wire:click="closeContactSearch" class="cursor-pointer icofont-ui-close hover:text-gray-200"></i>
    @else
    <i wire:click="openContactSearch" class="cursor-pointer icofont-search hover:text-gray-200"></i>
    @endif
    </div>
    <div class="flex">
    <input wire:model="searchContact" autocomplete="off" x-show.transition="showContactSearch" type="text" name="contactSearch" id="contactSearch" class="flex-grow m-1 form-input" placeholder="Search for contacts...">
    </div>
    @if ($showContactSearch)
    <ul id="latestMessagesContainer" class="overflow-y-auto divide-y divide-gray-400">
        @forelse ($contacts as $contact)
        <li wire:key="{{ 'contact.'.$contact->id }}" wire:click="contactClicked({{ $contact->id }})" class="p-2 bg-gray-100 cursor-pointer hover:bg-gray-200">
            <div class="flex items-center space-x-2">
                <div class="relative items-center flex-shrink-0 w-12 h-12 overflow-hidden border border-gray-500 rounded-full max-w-16">
                    <img class="object-cover w-full h-full" src="{{ $contact->profile_photo_url }}" alt="contact photo">
                </div>
                <div class="flex-grow w-0">
                    <h1 class="text-black">{{ $contact->name }}</h1>
                </div>
            </div>
        </li>
        @empty
        <li class="p-2 bg-gray-100 cursor-pointer hover:bg-gray-200">
            <h1 class="text-xl text-center">Start a new conversation by searching for contacts...</h1>
        </li>
        @endforelse
    </ul>
    @else
    <ul id="latestMessagesContainer" class="overflow-y-auto divide-y divide-gray-400 h-">
        @forelse ($latest_messages as $latest_message)
        <li wire:click="contactClicked({{ $latest_message->complement_owner->id }})" class="p-2 bg-gray-100 cursor-pointer hover:bg-gray-200">
            <div class="flex items-start space-x-2">
                <div class="relative flex flex-col items-center flex-shrink-0 max-w-16">
                    <div class="w-12 h-12 overflow-hidden border border-gray-500 rounded-full">
                        <img class="object-cover w-full h-full" src="{{ $latest_message->complement_owner->profile_photo_url }}" alt="contact photo">
                    </div>
                    @if (!$latest_message->read_at && $latest_message->user_role == "receiver")
                    <div class="absolute w-3 h-3 bg-blue-600 rounded-full bottom-1 left-1"></div>
                    @endif
                </div>
                <div class="flex-grow w-0">
                    <h1 class="text-black">{{ $latest_message->complement_owner->name }}</h1>
                    <p class="text-sm {{ $latest_message->read_at || $latest_message->user_role == "sender" ?: "font-semibold" }} text-black truncate">{{ $latest_message->user_role == "sender" ? "You: " : "" }}{{ $latest_message->message }}</p>
                    <p class="text-xs text-right">{{ $latest_message->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </li>
        @empty
        <li class="p-2 bg-gray-100 cursor-pointer hover:bg-gray-200">
            <h1 class="text-xl text-center">Start a new conversation by searching for contacts...</h1>
        </li>
        @endforelse
    </ul>
    @endif
</div>

@push('scripts')
    <script>
        let latestMessagesContainer = document.querySelector("#latestMessagesContainer")
        latestMessagesContainer.onscroll = function(ev) {
            if(latestMessagesContainer.scrollTop + latestMessagesContainer.clientHeight >= latestMessagesContainer.scrollHeight - 1)
            {
                Livewire.emit("loadMore");
            }
        };
    </script>
@endpush