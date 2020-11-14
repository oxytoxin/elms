<div x-data="{showAdd:@entangle('showAdd')}">
    <div class="bg-white rounded-sm shadow-md card">
        <div class="flex justify-between px-3 py-1 border-b border-gray-500 title">
            <h1 class="text-sm font-semibold"><i wire:loading class="mr-2 fas fa-spinner fa-spin"></i>To Do</h1>
            <button @click="showAdd = true" class="focus:outline-none hover:text-primary-600"><i class="icofont-plus"></i></button>
        </div>
        <div @click.away="showAdd = !showAdd" x-cloak x-show.transition="showAdd" class="flex p-2">
            <input wire:model.defer="todo" autofocus type="text" class="w-10/12 text-xs form-input">
            <button wire:click="addTodo" class="px-2 mx-1 text-lg text-white rounded-lg focus:outline-none bg-primary-500 hover:bg-primary-600"><i class="icofont-check"></i></button>
        </div>
        <div class="px-2">
            @error('todo')
            <h1 class="text-xs italic text-red-600">{{ $message }}</h1>
            @enderror
        </div>
        <div class="p-2 text-sm min-h-16 content">
            <ul>
                @forelse ($todos as $todo)
                <li class="flex items-center px-1 my-1 truncate">
                    <button class="focus:outline-none" wire:click="markAsDone({{ $todo->id }})">
                        <i class="mr-1 text-lg cursor-pointer icofont-check-circled hover:text-primary-500"></i>
                    </button>
                    <button wire:click="removeTodo({{ $todo->id }})" class="mx-1 text-red-600 rounded-lg text-md focus:outline-none"><i class="icofont-trash"></i></button><span class="cursor-pointer {{ $todo->completed ? 'line-through' : '' }}" title="{{ $todo->content }}">{{ $todo->content }}</span>
                    </li>
                @empty
                    <li>Create your first to-do!</li>
                @endforelse
            </ul>
        </div>
    </div>
    @if (auth()->user()->isStudent())
    <div class="mt-5 bg-white rounded-sm shadow-md card">
        <div class="flex justify-between px-3 py-1 border-b border-gray-500 title">
            <h1 class="text-sm font-semibold">Upcoming Tasks</h1>
        </div>
        <div class="p-2 min-h-16 content">
            <ul>
                @forelse ($upcoming as $upcome)
                <li wire:key="upcoming_{{ $upcome->id }}" title="{{ $upcome->name }}" class="text-xs truncate">
                    <i class="mr-1 text-lg icofont-notepad"></i><a href="{{ route('student.task',['task'=>$upcome->id]) }}" class="truncate hover:underline">{{ $upcome->name }}</a>
                    <h1 class="text-xs text-right text-red-600">(Due: <span class="font-semibold">{{ $upcome->deadline->format('h:i A-M d, Y') }}</span> )</h1>
                </li>
                @empty
                <li class="text-xs"> Woohoo! No upcoming tasks.
                </li>
                @endforelse
            </ul>
        </div>
    </div>
    @endif
    <div class="mt-5 bg-white rounded-sm shadow-md card">
        <div class="flex justify-between px-3 py-1 border-b border-gray-500 title">
            <h1 class="text-sm font-semibold">Announcements</h1>
        </div>
        <div class="p-2 min-h-16 content">
            <ul class="text-xs">
                @forelse ($events as $event)
                <li title="{{ $event->title }}" class="p-1 truncate">
                    <i class="mr-1 text-lg text-red-600 icofont-alarm"></i><a href="{{ $event->url }}">{{ $event->title }}</a>
                </li>
                @empty
                <li class="p-1">
                    <i class="text-red-600 icofont-alarm"></i>No announcements.
                </li>
                @endforelse
                @if (count($events))
                <li class="p-1 font-semibold text-center truncate hover:bg-primary-500">
                   <a href="{{ \Request()->route()->getPrefix() .'/calendar' }}">SEE ALL</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
