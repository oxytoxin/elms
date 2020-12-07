@extends('layouts.master')
@section('content')
<div class="px-5">
        <div>
            <h1 class="flex justify-between p-2 text-2xl font-semibold"><span>MODULES MANAGER</span><a href="{{ route('teacher.addmodule',['section'=>$section->id]) }}" class="flex items-center p-2 text-sm text-white rounded-lg hover:bg-primary-600 focus:outline-none bg-primary-500"><i class="icofont-plus"></i>ADD MODULE</a></h1>
            <h1 class="p-2 mx-2 italic font-semibold text-white bg-primary-500">{{ $section->course->name }}</h1>
            <div class="grid gap-2 p-2 md:grid-cols-3 xxl:grid-cols-5 lg:grid-cols-4">
                @forelse($modules as $module)
                <div class="w-full overflow-hidden h-80">
                    <div class="h-1/2"><img src="{{ $module->image->url }}" class="object-cover w-full h-full"
                            alt="course"></div>
                    <div class="p-2 text-white h-4/12 bg-secondary-500">
                        <h1 class="text-sm text-center">{{ $module->name }}</h1>
                    </div>
                    <div class="h-2/12">
                        <a href="{{ route('teacher.module',['module'=>$module->id]) }}"
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
</div>
@endsection
@section('sidebar')
    @include('includes.teacher.sidebar')
@endsection