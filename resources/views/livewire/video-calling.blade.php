<div id="meet" class="w-full h-full">
</div>

@push('scripts')
<script src='https://meet.jit.si/external_api.js'></script>
<script>
    document.addEventListener('livewire:load', ()=>{
        const domain = 'jitsi.toxinsgrace.me';
        const options = {
            roomName: 'asdklawdkal;w',
            userInfo: {
                email: @this.email,
                displayName: @this.name,
            },
            configOverwrite:{
                disableProfile: true,
                disableInviteFunctions: true,
                doNotStoreRoom: true,
                remoteVideoMenu:
                {
                    disableKick: true,
                },
            },
            interfaceConfigOverwrite:{
                HIDE_INVITE_MORE_HEADER: true,
                JITSI_WATERMARK_LINK: 'https://elms.toxinsgrace.me'
            },
            parentNode: document.querySelector('#meet'),
            apiLogLevels: ['error'],
        };
        const api = new JitsiMeetExternalAPI(domain, options);
    })
</script>
@endpush

@push('styles')
    <style>
        .welcome-page{
        display:none;
        }
    </style>
@endpush

@section('sidebar')
    @switch(request()->route()->getPrefix())
        @case('/student')
            @include('includes.student.sidebar')
            @break
        @case('/teacher')
            @include('includes.teacher.sidebar')
            @break
        @case('/programhead')
            @include('includes.head.sidebar')
            @break
        @default
    @endswitch
@endsection