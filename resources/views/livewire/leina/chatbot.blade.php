<div x-data="{show:@entangle('showChatbot').defer}" {{ $showChatbot ? "wire:poll.10s" : '' }}>
    <div x-cloak x-show.transition="show" class="fixed inset-0 z-50">
        <div class="relative w-full h-full">
            <div class="absolute flex w-1/2 space-x-2 right-5 bottom-5">
                <form wire:submit.prevent="sendQuery" @click.away="show=false" class="flex flex-col flex-grow p-5 bg-gray-300 rounded-lg min-h-halfscreen">
                    <h1 class="text-lg font-semibold text-gray-700">Hi! How can Leina help you?</h1>
                    <h1 class="py-2 text-xs italic font-semibold text-gray-700">Email us at elms@sksu.edu.ph</h1>
                    <div class="flex flex-col flex-grow space-y-2">
                        <div x-ref="supportsContainer" @scroll="if($refs.supportsContainer.scrollHeight - $refs.supportsContainer.clientHeight <= $refs.supportsContainer.scrollTop * -1 + 5) @this.perPage += 5; console.log($refs.supportsContainer)" class="flex flex-col-reverse flex-grow h-0 overflow-y-auto bg-gray-100">
                            <div class="inline-block p-2 align-top">
                                <div class="flex flex-col-reverse space-y-2 space-y-reverse">
                                    @foreach ($supports as $k => $support)
                                    <div wire:key="support-{{ $support->id }}" class="flex {{ $support->isQuery ? 'justify-end' : '' }}">
                                        <h1 class="{{ $support->isQuery ? 'bg-blue-600 text-white' : 'bg-gray-200' }} w-3/4 p-2 rounded">{{ $support->message }}</h1>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input wire:model.defer="query" x-ref="messagebox" type="text" class="flex-grow rounded">
                            <div class="h-full">
                                <button type="submit" class="h-full px-2 text-white bg-blue-600 rounded-lg whitespace-nowrap hover:bg-blue-500">SEND <i class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>

                </form>
                <img src="{{ asset('img/leina.webp') }}" alt="leina" class="self-end h-full animate-pulse w-44">
            </div>
        </div>
    </div>
    <i @click="show = true; $nextTick(()=>{$refs.messagebox.focus();});" x-show="!show" class="fixed z-50 hidden text-6xl cursor-pointer md:block icofont-question-circle right-10 bottom-10 hover:text-primary-600 text-primary-500"></i>
</div>
