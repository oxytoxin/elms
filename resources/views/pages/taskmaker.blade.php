@extends('layouts.master')

@section('content')
    @livewire('task-maker', ['user' => $user])
@endsection
