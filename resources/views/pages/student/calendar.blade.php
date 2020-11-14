@extends('layouts.master')
@section('content')
<div class="px-5" x-data="{showEventCreator:false}">
    @livewire('event-creator')
    <h1 class="text-2xl font-semibold">Calendar of Events</h1>
    <button @click="showEventCreator = true" class="p-2 text-white rounded-md bg-primary-500"><i class="mr-2 icofont-plus"></i>Create an Event</button>
    <div class="flex overflow-x-auto">
        <div id='calendar' class="w-full mt-5 overflow-x-auto"></div>
    </div>
</div>
@endsection
@section('sidebar')
    @include('includes.student.sidebar')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.js"></script>
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
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css">
@endpush