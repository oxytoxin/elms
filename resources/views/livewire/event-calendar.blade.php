<div>
    @livewire('event-creator')
    <h1 class="mb-3 text-2xl font-semibold uppercase">Calendar of Events</h1>
    <button @click="Livewire.emit('openEventCreator')" class="p-2 text-white rounded-md bg-primary-500"><i class="mr-2 icofont-plus"></i>Create an Event</button>
    <div class="flex overflow-x-auto">
        <div id='calendar' class="w-full mt-5 overflow-x-auto"></div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.js"></script>
<script>
    document.addEventListener('livewire:load', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
            , headerToolbar: {
                left: 'prev,next today'
                , center: 'title'
                , right: 'dayGridMonth,timeGridDay'
            }
            , droppable: true,

        });
        calendar.addEventSource({
            url: '/eventcalendar/events'
        });
        calendar.render();
        window.addEventListener('event-created', () => {
            calendar.refetchEvents();
        });
    });

</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css">
@endpush

@push('metas')
<meta name="turbolinks-cache-control" content="no-cache">
@endpush

@section('sidebar')
@switch(session('whereami'))
@case('student')
@include('includes.student.sidebar')
@break
@case('teacher')
@include('includes.teacher.sidebar')
@break
@case('programhead')
@include('includes.head.sidebar')
@break
@case('dean')
@include('includes.dean.sidebar')
@break
@default
@endswitch
@endsection
