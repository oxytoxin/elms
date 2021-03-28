<div x-data="{showEventsList: @entangle('eventsListOpen')}" id="event_creator" x-cloak x-show.transition="showEventsList" class="fixed inset-0 z-50 p-10 overflow-y-auto">
    <div class="relative flex flex-col w-full h-full bg-white border-4 border-primary-600">
        <i @click="showEventsList = false" class="absolute text-red-600 cursor-pointer icofont-ui-close top-3 right-3"></i>
        <div class="flex flex-col flex-grow p-10">
            <h1 class="text-xl font-semibold">My Personal Events</h1>
            <div class="flex-grow h-0 overflow-y-auto">
                <div>
                    @forelse ($events as $event)
                    <div class="flex items-center p-3 space-x-3">
                        @if ($event->user_id == auth()->id())
                        <i wire:click="removeEvent({{ $event->id }})" class="text-red-600 cursor-pointer icofont-trash"></i>
                        @else
                        <i wire:click="removeEvent({{ $event->id }})" class="icofont-chevron-right"></i>
                        @endif
                        <h1>{{ $event->title }}</h1>
                    </div>
                    @empty
                    <h1>No events found. Create one now!</h1>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
