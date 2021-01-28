@extends('layouts.master')
@section('content')
<div class="px-5">
    <div class="">
        @livewire('head-courses-page',['course'=>$course])
    </div>
</div>
@endsection
@section('sidebar')
    @include('includes.head.sidebar')
@endsection