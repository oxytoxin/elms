@if (session('message'))
<div x-show.transition.opacity="show" x-data="{show:true}" x-init="
    setTimeout(()=>{
        show = false;
    },3000);
" class="fixed inset-0 z-50 grid px-5 bg-gray-500 bg-opacity-50 place-items-center">
    <div class="flex flex-col w-full p-5 bg-white shadow-lg min-h-halfscreen md:w-1/2">
        <h1 class="flex items-center text-[3rem] text-center justify-center flex-grow"><span>{{ session('message') }}</span></h1>
        <button @click="show = false" class="p-3 font-semibold text-white rounded cursor-pointer bg-primary-500">CLOSE</button>
    </div>
</div>
@endif
