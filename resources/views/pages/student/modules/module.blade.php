@extends('layouts.student')
@section('content')
@include('includes.student.header')
<main class="p-3">
    <div class="flex min-h-screen">
        <div class="w-5/6 px-2 mx-4">
            <h1 class="font-semibold">Module Title</h1>
            <h1 class="my-2">Module Title</h1>
            <h1 class="font-semibold">Module Description</h1>
            <h1 class="my-2">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam, ut?</h1>
            <h1 class="font-semibold">Module Resources</h1>
            <div class="flex items-center my-2">
                <a href="#" target="_blank">
                    <h1 class="italic underline text-primary-600">Module1Week1.pdf</h1>
                </a>
                <a href="/" target="_blank" rel="noopener noreferrer"
                    class="px-2 ml-3 text-white border hover:text-black border-primary-600 bg-primary-500">Preview</a>
            </div>
            <div class="flex items-center my-2">
                <a href="#" target="_blank">
                    <h1 class="italic underline text-primary-600">Module1Week1.pptx</h1>
                </a>
                <a href="/" target="_blank" rel="noopener noreferrer"
                    class="px-2 ml-3 text-white border hover:text-black border-primary-600 bg-primary-500">Preview</a>
            </div>

        </div>
        @include('includes.student.menu')
    </div>
</main>
@endsection