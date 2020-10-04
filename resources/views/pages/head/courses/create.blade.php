@extends('layouts.head')
@section('content')
@include('includes.head.header')
<main class="p-3">
    <div class="flex min-h-screen">
        <div class="w-5/6 mx-4">
            <h1 class="text-2xl font-semibold">COURSE MANAGER</h1>
            @livewire('create-course')
        </div>
        @include('includes.head.menu')
    </div>
</main>
@endsection