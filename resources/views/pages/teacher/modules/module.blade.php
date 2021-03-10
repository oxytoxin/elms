@extends('layouts.master')
@section('content')
<div>
    <div class="w-full px-2 m-4">
        <x-flash-notification />
        <h1 class="my-2 text-2xl uppercase"><i class="mr-2 icofont-star"></i>{{ $module->name }}</h1>
        <div class="flex flex-col items-center justify-between py-3 mb-5 border-t-2 border-b-2 md:flex-row border-primary-600">
            <h1 class="font-semibold">CREATE A TASK</h1>
            <div class="text-center">
                @foreach ($task_types as $task)
                <a href="{{ route('teacher.taskmaker',['module'=>$module->id,'course'=>$module->course->id,'type'=> $task->name ]) }}"><button class="p-2 m-2 font-semibold text-white rounded-md min-w-40 hover:text-primary-600 bg-primary-500"><i class="mr-2 icofont-ui-folder"></i>{{ strtoupper($task->name) }}</button></a>
                @endforeach
            </div>
        </div>
        <h1 class="font-semibold">Module Resources</h1>
        @forelse ($module->files as $file)
        <div class="inline-flex items-center justify-center bg-white border divide-x-2 rounded-lg">
            <a href="{{ route('teacher.preview',['file'=> $file->id]) }}" class="p-3" target="_blank">
                <i class="icofont-ui-file"></i>
                {{ $file->name }}
            </a>
            <a href="{{ route('file.download',['file'=> $file->id]) }}" target="_blank" class="p-3 text-white rounded-r-lg hover:text-primary-600 bg-primary-500">
                <i class="icofont-download-alt"></i>
            </a>
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
        <div class="inline-flex items-center justify-center bg-white border divide-x-2 rounded-lg">
            <a href="{{ route('teacher.preview',['file'=> $file->id]) }}" class="p-3" target="_blank">
                <i class="icofont-ui-file"></i>
                {{ $file->name }}
            </a>
            <a href="{{ route('file.download',['file'=> $file->id]) }}" target="blank" class="p-3 text-white rounded-r-lg hover:text-primary-600 bg-primary-500">
                <i class="icofont-download-alt"></i>
            </a>
        </div>
        @endforeach
        @empty
        <h1>No additional resources found.</h1>
        @endforelse
    </div>
</div>
@endsection
@section('sidebar')
@include('includes.teacher.sidebar')
@endsection
