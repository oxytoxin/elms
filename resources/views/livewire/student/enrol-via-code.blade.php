<div class="p-5">
    <div class="p-10 bg-white shadow-lg">
        <div class="pb-10">
            <label for="invite_code" class="block font-semibold">Invite Code</label>
            <textarea wire:model="invite_code" rows="7" autofocus type="text" name="invite_code" class="w-full form-textarea" id="invite_code"></textarea>
            @if(session('error'))
                <h1 class="text-sm italic font-semibold text-red-600">{{ session('error') }}</h1>
            @endif
            <button wire:click="enroll" class="float-right p-3 mt-3 text-sm font-semibold text-white bg-primary-500 hover:text-primary-600">ENROLL VIA CODE</button>
        </div>
    </div>
</div>

@section('sidebar')
    @include('includes.student.sidebar')
@endsection