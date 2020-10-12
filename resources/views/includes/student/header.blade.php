<header class="sticky top-0 flex items-center justify-between h-12 p-2 text-gray-300 bg-primary-500">
    <div class="flex items-center left">
        <i @click="sidebar = !sidebar" class="m-2 cursor-pointer icofont-navigation-menu"></i>
        <h1 class="text-sm font-semibold">SULTAN KUDARAT STATE UNIVERSITY</h1>
    </div>
    <div class="flex items-center mr-4 text-2xl right">
        <a href="#"><i class="mx-2 cursor-pointer hover:text-white icofont-wechat"></i></a>
        <a href="#"><i class="mx-2 cursor-pointer hover:text-white icofont-alarm"></i></a>
        <a href="#"><i class="mx-2 cursor-pointer hover:text-white icofont-ui-calendar"></i></a>
        <a href="#"><i class="mx-2 cursor-pointer hover:text-white icofont-question-circle"></i></a>
        <a href="{{ route('profile.show') }}"><i class="mx-2 cursor-pointer hover:text-white icofont-user-alt-4"></i></a>
    </div>
</header>