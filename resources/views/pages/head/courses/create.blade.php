@extends('layouts.master')
@section('content')
<div class="px-5">
    <div class="">
        <div>
            <h1 class="text-2xl font-semibold">COURSE MANAGER</h1>
            @livewire('create-course')
        </div>
    </div>
</div>
@endsection
@section('sidebar')
    @include('includes.head.sidebar')
@endsection