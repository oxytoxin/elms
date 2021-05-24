<div>
    <div class="grid gap-3 mt-3 auto-rows-[1fr] md:grid-cols-[repeat(auto-fill,minmax(300px,1fr))]">
        @forelse ($drafts as $draft)
        <div class="flex flex-col h-full overflow-hidden bg-white border-4 rounded-lg hover:bg-green-300 border-primary-600">
            <a class="flex flex-col flex-grow" href="{{ route('teacher.taskmaker',['draft_id' => $draft->id]) }}">
                <div class="flex-grow space-y-2 bg-green-300">
                    <div class="flex justify-around p-3">
                        <div class="flex-shrink-0 w-12 h-12">
                            <img class="object-cover w-full h-full rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="teacher avatar">
                        </div>
                        <div class="space-y-1 text-sm font-semibold text-center">
                            <h1>{{ $draft->task_name }}</h1>
                            <h1 class="text-sm font-semibold text-gray-700">{{ $draft->module->name }}</h1>
                            <h1 class="text-sm font-semibold text-gray-700">{{ $draft->course->name }} <span class="text-orange-600">[{{ $draft->module->course->code }}]</span></h1>
                        </div>
                    </div>
                </div>
            </a>
            <div class="flex justify-center p-3 text-xs font-semibold uppercase">
                <div class="flex items-center space-x-2">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 60 60">
                        <title>calendar</title>
                        <path d="M18.75 22.5h7.5v7.5h-7.5zM30 22.5h7.5v7.5h-7.5zM41.25 22.5h7.5v7.5h-7.5zM7.5 45h7.5v7.5h-7.5zM18.75 45h7.5v7.5h-7.5zM30 45h7.5v7.5h-7.5zM18.75 33.75h7.5v7.5h-7.5zM30 33.75h7.5v7.5h-7.5zM41.25 33.75h7.5v7.5h-7.5zM7.5 33.75h7.5v7.5h-7.5zM48.75 0v3.75h-7.5v-3.75h-26.25v3.75h-7.5v-3.75h-7.5v60h56.25v-60h-7.5zM52.5 56.25h-48.75v-41.25h48.75v41.25z">
                        </path>
                    </svg>
                    <div>
                        <h1 class="text-red-600">{{ $draft->deadline ? $draft->deadline->format('h:i a, m/d/Y') : 'No deadline set' }}</h1>
                    </div>
                    <i wire:click="deleteDraft({{ $draft->id }})" class="text-xl cursor-pointer hover:text-red-600 icofont-trash"></i>
                </div>
            </div>
        </div>
        @empty
        <h1>Hooray! Nothing to do here yet.</h1>
        @endforelse
    </div>
</div>

@section('sidebar')
@include('includes.teacher.sidebar')
@endsection
