<div class="inline md:relative" x-data="{showNotifs:false}">
    <a @click="showNotifs = !showNotifs"><i class="mx-2 cursor-pointer hover:text-primary-600 icofont-alarm"></i></a>
    <div  @click.away="showNotifs = false" x-cloak x-show.transition.opacity="showNotifs" class="absolute right-0 z-50 mr-3 text-gray-700 bg-white w-72">
        <ul class="text-xs font-normal divide-y-2">
            <li class="flex items-center p-2 cursor-pointer hover:bg-gray-300">
                <div class="w-24 mr-2 overflow-hidden rounded-full">
                <img src="{{ auth()->user()->profile_photo_url }}" class="object-cover w-full" alt="notif_image">
                </div>
                <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, cupiditate.</h1>
            </li>
            <li class="flex items-center p-2 cursor-pointer hover:bg-gray-300">
                <div class="w-24 mr-2 overflow-hidden rounded-full">
                <img src="{{ auth()->user()->profile_photo_url }}" class="object-cover w-full" alt="notif_image">
                </div>
                <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, cupiditate.</h1>
            </li>
            <li class="flex items-center p-2 cursor-pointer hover:bg-gray-300">
                <div class="w-24 mr-2 overflow-hidden rounded-full">
                <img src="{{ auth()->user()->profile_photo_url }}" class="object-cover w-full" alt="notif_image">
                </div>
                <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, cupiditate.</h1>
            </li>
            <li class="flex items-center p-2 cursor-pointer hover:bg-gray-300">
                <div class="w-24 mr-2 overflow-hidden rounded-full">
                <img src="{{ auth()->user()->profile_photo_url }}" class="object-cover w-full" alt="notif_image">
                </div>
                <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, cupiditate.</h1>
            </li>
        </ul>
    </div>
</div>
