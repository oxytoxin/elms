@extends('layouts.master')
@section('content')
<div>
    @livewire('event-creator')
    <h1 class="mb-3 text-2xl font-semibold uppercase">Calendar of Events</h1>
    <button @click="Livewire.emit('openEventCreator')" class="p-2 text-white rounded-md bg-primary-500"><i class="mr-2 icofont-plus"></i>Create an Event</button>
    <div class="flex overflow-x-auto">
        <div id='calendar' class="w-full mt-5 overflow-x-auto"></div>
    </div>
</div>
@endsection
@section('sidebar')
    @include('includes.student.sidebar')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridDay'
        },
        droppable:true,
        events: {!! json_encode($events->toArray()) !!}

      });
      calendar.render();
    });
    window.addEventListener('event-created',()=>{
        location.reload()
    })
  </script>
@endpush