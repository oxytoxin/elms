<div x-data="{showEventCreator: @entangle('creatorOpen')}" id="event_creator" x-cloak x-show.transition="showEventCreator" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="z-50 flex flex-col items-center justify-center w-full min-h-screen">
        <div @click.away="showEventCreator = false" class="w-11/12 bg-white rounded-lg shadow-lg md:w-1/2 min-h-halfscreen">
            <h1 class="m-3 font-semibold">EVENT CREATOR</h1>
            <hr class="border-t-2 border-primary-600">
            <div class="m-3 italic text-green-400">
                @if (session()->has('message'))
                {{ session('message') }}
                @endif
            </div>
            <div class="flex flex-col p-5 mx-3 text-sm">
                    <div class="mt-2">
                        <label for="event_name">Event Name</label>
                        <input wire:model="event_name" placeholder="Event Name" type="text" class="w-full form-input" name="event_name">
                        <div>
                            @error('event_name')
                            <h1 class="text-sm italic text-red-600">{{ $message }}</h1>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="event_description">Event Description</label>
                        <input wire:model="event_description" placeholder="Event Description" type="text" class="w-full form-input" name="event_description">
                        <div>
                            @error('event_description')
                            <h1 class="text-sm italic text-red-600">{{ $message }}</h1>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                    <label for="event_target">Event Target</label>
                    <select wire:model="event_target" name="level" class="block w-full mt-2 form-select" id="level">
                        <option value="personal">Personal</option>
                        @switch(session('whereami'))
                            @case('teacher')
                                <option value="students">Students Only</option>
                                @break
                            @case('programhead')
                                <option value="all">All</option>
                                <option value="faculty">Faculty Only</option>
                                @break
                                @default
                        @endswitch
                    </select>
                </div>
                <div class="flex mt-2">
                    <div class="flex flex-col w-1/2 mr-2">
                        <label for="event_start" class="block">Event Date Start</label>
                        <input wire:model="event_start_day" type="date" name="start_date" class="form-input" id="start_date">
                        <div>
                            @error('event_start_day')
                                <h1 class="text-sm italic text-red-600">{{ $message }}</h1>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col w-1/2">
                        <label for="event_start" class="block">Event Time (Leave blank for whole day events)</label>
                        <input wire:model="event_start_time" type="time" name="start_time" class="form-input" id="start_time">
                    </div>
                </div>
                <div class="flex mt-2">
                    <div class="flex flex-col w-1/2 mr-2"><label for="event_end" class="block">Event Date End <span class="italic">(Optional)</span></label>
                    <input wire:model="event_end_day" type="date" name="end_date" class="form-input" id="end_date"></div>
                    <div class="flex flex-col w-1/2"><label for="event_end" class="block">Event Time (Leave blank for whole day events)</label>
                    <input wire:model="event_end_time" type="time" name="end_time" class="form-input" id="end_time"></div>
                </div>
                <button wire:click="addEvent" class="p-2 my-3 font-semibold text-white rounded-md bg-primary-500">ADD EVENT</button>
            </div>

        </div>
    </div>
  </div>
