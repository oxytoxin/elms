@extends('layouts.head')
@section('content')
@include('includes.head.header')
<main class="p-3">
    @include('includes.head.nav')
    <div class="flex min-h-screen">
        @livewire('head-courses-page')
        @include('includes.head.menu')
    </div>
</main>
@endsection