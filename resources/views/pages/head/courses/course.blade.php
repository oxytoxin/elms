@extends('layouts.head')
@section('content')
@include('includes.head.header')
<main class="md:p-3">
    <div class="flex min-h-screen">
        @livewire('head-courses-page',['course'=>$course])
        @include('includes.head.menu')
    </div>
</main>
@endsection