@extends('layouts.master')
@section('content')
<div class="px-5">
            <h1 class="p-2 text-2xl font-semibold">MODULES MANAGER</h1>
            <h1 class="p-2 mx-2 italic font-semibold text-white bg-primary-500">{{ $section->course->name }}</h1>
            <div class="grid gap-2 p-2 md:grid-cols-3 xxl:grid-cols-5 lg:grid-cols-4">
                @forelse($modules as $module)
                <div class="w-full overflow-hidden h-80">
                    <div class="h-1/2"><img src="{{ $module->image->url }}" class="object-cover w-full h-full"
                            alt="module"></div>
                    <div class="p-2 text-white h-4/12 bg-secondary-500">
                        <h1 class="text-sm text-center">{{ $module->name }}</h1>
                    </div>
                    <div class="h-2/12">
                        <a href="{{ route('student.module',['module'=>$module->id]) }}"
                            class="flex items-center justify-center w-full h-full p-1 text-white hover:text-black bg-primary-600">
                            View Module
                        </a>
                    </div>
                </div>
                @empty
                <h1>No Modules Found</h1>
                @endforelse
            </div>
</div>
@endsection
@section('sidebar')
    @include('includes.student.sidebar')
@endsection