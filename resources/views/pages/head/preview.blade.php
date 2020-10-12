@extends('layouts.head')
@section('content')
@include('includes.head.header')
<main class="p-3">
    <div class="flex min-h-screen">
        <div class="w-full mx-4 md:w-5/6">
            <h1 class="text-2xl font-semibold">{{ $file->fileable->name ? $file->fileable->name : $file->fileable->title }} | {{ $file->name }}</h1>
            <iframe src="https://docs.google.com/file/d/{{ $file->google_id }}/preview" frameborder="2"
                class="w-full min-h-halfscreen md:min-h-screen"></iframe>
        </div>
        @include('includes.head.menu')
    </div>
</main>
@endsection