<div class="relative inline" x-data="{showNotifs: @entangle('showNotifs')}">
    <a wire:click="notificationsOpened"><i class="cursor-pointer hover:text-primary-600 icofont-alarm"></i><span class="absolute right-0 px-1 text-xs bg-orange-500 rounded-sm {{ !$unread ?: "animate-bounce" }}">{{ $unread }}</span></a>
    <div @click.away="showNotifs = false" x-cloak x-show.transition.opacity="showNotifs" class="absolute z-50 mr-3 text-gray-700 bg-white md:right-0 w-72">
        <ul class="flex flex-col overflow-y-auto text-xs font-normal divide-y max-h-96">
            @forelse ($notifications as $notification)
            <a href="{{ $notification->data['url'] ?: '#'  }}">
                <li class="flex items-center p-2 cursor-pointer hover:bg-green-300">
                    <div class="flex-shrink-0 w-12 h-12 mr-2 overflow-hidden text-center rounded-full">
                        @if ($notification->data['photo_url'])
                        <img src="{{ $notification->data['photo_url'] }}" class="object-cover w-full h-full" alt="notif_image">
                        @else
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @endif
                    </div>
                    <div class="flex-grow space-y-2 text-right">
                        <h1 class="break-words whitespace-normal">{{ $notification->data['message'] }}</h1>
                        <h1 class="text-xs text-right">{{ $notification->created_at->diffForHumans() }}</h1>
                    </div>
                </li>
            </a>
            @empty
            <li>
                <h1 class="p-2 text-center">No notifications.</h1>
            </li>
            @endforelse

        </ul>
    </div>
</div>
