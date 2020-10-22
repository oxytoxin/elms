@extends('layouts.master')
@section('content')
<div class="px-5">
    <div class="flex">
        <div class="w-full mx-4">
            <h1 class="text-2xl font-semibold">{{ $file->fileable->name ? $file->fileable->name : $file->fileable->title }} | {{ $file->name }}</h1>
            <iframe src="https://docs.google.com/file/d/{{ $file->google_id }}/preview" frameborder="2"
                class="w-full min-h-halfscreen md:min-h-screen"></iframe>
        </div>
    </div>
</div>
@endsection
@section('sidebar')
    @include('includes.head.sidebar')
@endsection