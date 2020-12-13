<div class="relative inline" x-data="{showNotifs: @entangle('showNotifs')}">
    <a wire:click="notificationsOpened"><i class="cursor-pointer hover:text-primary-600 icofont-alarm"></i><span class="absolute right-0 px-1 text-xs bg-orange-500 rounded-sm">{{ $unread }}</span></a>
    <div @click.away="showNotifs = false" x-cloak x-show.transition.opacity="showNotifs" class="absolute z-50 mr-3 text-gray-700 bg-white md:right-0 w-72">
        <ul class="flex flex-col overflow-y-auto text-xs font-normal divide-y max-h-96">
            @forelse ($notifications as $notification)
            <a href="{{ $notification->data['url'] }}">
            <li class="flex items-center p-2 cursor-pointer hover:bg-green-300">
                    <div class="flex-shrink-0 w-12 mr-2 overflow-hidden rounded-full">
                        <img src="{{ $notification->data['photo_url'] }}" class="object-cover w-full" alt="notif_image">
                    </div>
                    <div>
                        <h1 class="whitespace-normal">{{ $notification->data['message'] }}</h1>
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
