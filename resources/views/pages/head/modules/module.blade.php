@extends('layouts.master')
@section('content')
<div class="px-5">
    <div class="flex">
        <div class="w-full px-2 m-4">
            <h1 class="my-2 text-2xl"><i class="mr-2 icofont-star"></i>{{ $module->name }}</h1>
            <h1 class="font-semibold">Module Resources</h1>
            @forelse ($module->files as $file)
            <div class="flex items-center my-2">
                <a href="{{ route('file.download',['file'=> $file->id]) }}" target="_blank">
                    <h1 class="italic underline text-primary-600"><i
                            class="mr-2 icofont-download-alt"></i>{{ $file->name }}
                    </h1>
                </a>
                <a href="{{ route('teacher.preview',['file'=> $file->id]) }}" target="_blank" rel="noopener noreferrer"
                    class="px-2 ml-3 text-white border hover:text-black border-primary-600 bg-primary-500">Preview</a>
            </div>
            @empty
            <h1>No modules found.</h1>
            @endforelse
            <h1 class="font-semibold">Additional Resources</h1>
            @forelse ($resources as $resource)
            <h1 class="my-2 italic font-semibold">{{ $resource->title }}</h1>
            <p class="my-2 italic text-justify"><span class="font-semibold">Description:
                </span>{{ $resource->description }}</p>
            @foreach ($resource->files as $file)
            <div class="flex items-center my-2">
                <a href="{{ route('file.download',['file'=> $file->id]) }}" target="_blank">
                    <h1 class="italic underline text-primary-600"><i
                            class="mr-2 icofont-download-alt"></i>{{ $file->name }}
                    </h1>
                </a>
                <a href="{{ route('teacher.preview',['file'=> $file->id]) }}" target="_blank" rel="noopener noreferrer"
                    class="px-2 ml-3 text-white border hover:text-black border-primary-600 bg-primary-500">Preview</a>
            </div>
            @endforeach
            @empty
            <h1>No additional resources found.</h1>
            @endforelse
    </div>
    </div>
@endsection
@section('sidebar')
    @include('includes.head.sidebar')
@endsection