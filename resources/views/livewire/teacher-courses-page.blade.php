<div class="w-full md:w-5/6">
    <h1 class="font-semibold">COURSE TITLE<i wire:loading class="fa fa-spinner fa-spin"></i></h1>
    <div class="box-border flex text-lg text-gray-300 border-2 border-black">
        <a href="#" wire:click="$set('tab','student')"
            class="flex items-center justify-center w-1/2 {{ $tab == 'student' ?  'bg-primary-500 text-gray-700' : '' }}">
            <div class="font-bold text-center uppercase hover:text-gray-700">ENROL STUDENT</div>
        </a>
        <a href="#" wire:click="$set('tab','resources')"
            class="flex items-center justify-center w-1/2 {{ $tab == 'resources' ?  'bg-primary-500 text-gray-700' : '' }}">
            <div class="font-bold text-center uppercase hover:text-gray-700">UPLOAD MODULE RESOURCES</div>
        </a>
    </div>

    @if ($tab == 'student')
    <div class="mt-2">
        <form action="">
            <label for="email">Student Email</label>
            <div class="flex flex-col items-center mt-2 md:flex-row">
                <input type="email" class="w-full form-input" placeholder="student@email.com" autocomplete="off"
                    autofocus name="email">
                <button
                    class="w-full p-2 mt-2 text-white whitespace-no-wrap rounded-lg md:ml-3 md:w-auto md:mt-0 hover:text-black focus:outline-none bg-primary-500">Enrol
                    Student</button>
            </div>
        </form>
    </div>
    <h1 class="my-2 font-bold">Course Student List</h1>
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
    @if ($tab == 'resources')
    <div class="mt-2">
        <form action="">
            <label class="font-semibold" for="title">Resource Title</label>
            <input type="text" class="flex-1 block w-full form-input" autocomplete="off" placeholder="Module Title"
                autofocus name="title">
            <label class="font-semibold" for="description">Resource Description</label>
            <textarea class="flex-1 w-full resize form-textarea" rows="4" autocomplete="off"
                placeholder="Module Description" autofocus name="description"></textarea>
            <div class="flex flex-col items-center mt-2 md:flex-row">
                <input type="file" class="w-full form-input" autocomplete="off" multiple name="module">
                <button
                    class="w-full p-2 mt-2 text-white whitespace-no-wrap rounded-lg md:w-auto md:ml-2 md:mt-0 hover:text-black focus:outline-none bg-primary-500">Upload
                    Resource</button>
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
                <td class="border-2 border-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga quia
                    mollitia non.</td>
                <td class="border-2 border-gray-600">Pending Approval</td>
                <td class="border-2 border-gray-600">1 sec ago</td>
            </tr>
        </tbody>
    </table>
    @endif
</div>