<div class="p-2">
    <h1 class="text-2xl font-semibold uppercase">Assignment</h1>
@foreach ($task_content as $item)
    <div class="p-2 mt-3 border border-gray-700 rounded-lg shadow-lg">
        <h1>({{ $item['points'] }} pt/s.) Question {{ $item['item_no'] }}. {{ $item['question'] }}</h1>
        @if ($item['files'])
        <div class="flex justify-center my-3">
            @foreach ($item['files'] as $file)
        <div class="flex flex-col items-center">
            <img src="{{ asset('storage'.'/'.$file) }}" alt="file" class="w-64">
        <a target="blank" href="{{ asset('storage'.'/'.$file) }}" class="text-sm italic underline text-primary-500">See full image.</a>
        </div>
        @endforeach
        </div>
    @endif
    @forelse ($item['options'] as $option)
        <input type="radio" name="answer_{{ $item['item_no'] }}" value="{{ $option }}" class="form-radio">
        <label for="">{{ $option }}</label>
    @empty
        <textarea cols="30" rows="5" class="w-full border-2 border-gray-700 form-textarea"></textarea>
    @endforelse
    </div>
@endforeach
</div>
@section('sidebar')
    @include('includes.student.sidebar')
@endsection