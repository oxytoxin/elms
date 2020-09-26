<div class="w-5/6 p-2 m-4">
    <h1 class="font-semibold">COURSE TITLE</h1>
    <div class="box-border flex text-lg text-gray-300 border-2 border-black">
        <a href="#" wire:click="$set('tab','faculty')"
            class="flex items-center justify-center w-1/2 {{ $tab == 'faculty' ?  'bg-primary-500 text-gray-700' : '' }}">
            <div class="font-bold text-center uppercase hover:text-gray-700">ENROL FACULTY</div>
        </a>
        <a href="#" wire:click="$set('tab','modules')"
            class="flex items-center justify-center w-1/2 {{ $tab == 'modules' ?  'bg-primary-500 text-gray-700' : '' }}">
            <div class="font-bold text-center uppercase hover:text-gray-700">UPLOAD MODULE RESOURCES</div>
        </a>
    </div>
    @if ($tab == 'faculty')
    <div class="mt-2">
        <form action="">
            <label for="email">Faculty Email</label>
            <div class="flex items-center mt-2">
                <input type="email" class="flex-1 block form-input" autocomplete="off" autofocus name="email">
                <button class="p-2 ml-2 text-white rounded-lg hover:text-black focus:outline-none bg-primary-500">Enrol
                    Faculty</button>
            </div>
        </form>
    </div>
    <h1 class="my-2 font-bold">Course Faculty List</h1>
    <table class="table w-full border-2 border-collapse border-gray-600">
        <thead class="">
            <th class="border-2 border-gray-600">Name</th>
            <th class="border-2 border-gray-600">Email</th>
        </thead>
        <tbody class="text-center">
            <tr>
                <td class="border-2 border-gray-600">Name</td>
                <td class="border-2 border-gray-600">Email</td>
            </tr>
        </tbody>
    </table>
    @endif
    @if ($tab == 'modules')
    <div class="mt-2">
        <form action="">
            <label class="font-semibold" for="title">Module Title</label>
            <input type="text" class="flex-1 block w-full form-input" autocomplete="off" placeholder="Module Title"
                autofocus name="title">
            <div class="flex items-center mt-2">
                <input type="file" class="flex-1 block form-input" autocomplete="off" autofocus name="module">
                <button class="p-2 ml-2 text-white rounded-lg hover:text-black focus:outline-none bg-primary-500">Submit
                    for Approval</button>
            </div>
        </form>
    </div>
    <h1 class="my-2 font-bold">Course Module List</h1>
    <table class="table w-full border-2 border-collapse border-gray-600 table-fixed">
        <thead class="">
            <th class="border-2 border-gray-600">Title</th>
            <th class="border-2 border-gray-600">Status</th>
            <th class="border-2 border-gray-600">Date Approved</th>
        </thead>
        <tbody class="text-center">
            <tr>
                <td class="border-2 border-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Fuga quia mollitia non.</td>
                <td class="border-2 border-gray-600">Pending Approval</td>
                <td class="border-2 border-gray-600">1 sec ago</td>
            </tr>
        </tbody>
    </table>
    @endif
</div>