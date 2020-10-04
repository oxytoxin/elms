@extends('layouts.head')
@section('content')
@include('includes.head.header')
<main class="p-3">
    <div class="flex min-h-screen">
        <div class="w-5/6 px-2 mx-4">
            <h1 class="font-semibold">Module Title</h1>
            <h1 class="my-2">{{ $module->name }}</h1>
            <h1 class="font-semibold">Module Resources</h1>
            @forelse ($module->files as $file)
            <div class="flex items-center my-2">
                <a href="{{ route('file.download',['file'=> $file->id]) }}" target="_blank">
                    <h1 class="italic underline text-primary-600"><i
                            class="mr-2 icofont-download-alt"></i>{{ $file->name }}
                    </h1>
                </a>
                <a href="{{ route('head.preview',['file'=> $file->id]) }}" target="_blank" rel="noopener noreferrer"
                    class="px-2 ml-3 text-white border hover:text-black border-primary-600 bg-primary-500">Preview</a>
            </div>
            @empty
            <h1>No modules found.</h1>
            @endforelse
        </div>
        @include('includes.head.menu')
    </div>
</main>
@endsection