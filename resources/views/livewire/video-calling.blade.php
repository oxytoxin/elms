<div id="meet" class="relative w-full h-full">
    <div class="absolute top-0 left-0 w-32 h-32 bg-transparent"></div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', () => {
        const domain = 'meet.jit.si';
        // const domain = 'jitsi.toxinsgrace.me';
        const options = {
            roomName: @this.room
            , userInfo: {
                email: @this.email
                , displayName: @this.name
            , }
            , configOverwrite: {
                enableWelcomePage: false
                , enableClosePage: false
                , disableAudioLevels: true
                , disableProfile: true
                , prejoinPageEnabled: true
                , disableProfile: true
                , disableDeepLinking: true
                , disableInviteFunctions: true
                , doNotStoreRoom: true
                , remoteVideoMenu: {
                    disableKick: true
                , }
            , }
            , interfaceConfigOverwrite: {
                HIDE_INVITE_MORE_HEADER: true
                , JITSI_WATERMARK_LINK: 'https://elms.toxinsgrace.me'
                , BRAND_WATERMARK_LINK: 'https://elms.toxinsgrace.me'
                , TOOLBAR_BUTTONS: [
                    'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen'
                    , 'fodeviceselection', 'hangup', 'profile', 'chat', 'recording'
                    , 'sharedvideo', 'settings', 'raisehand'
                    , 'videoquality', 'filmstrip', 'stats', 'shortcuts'
                    , 'tileview', 'videobackgroundblur', 'download'
                ]
            , }
            , parentNode: document.querySelector('#meet')
            , apiLogLevels: ['error']
        , };
        const api = new JitsiMeetExternalAPI(domain, options);
        api.on('videoConferenceLeft', (e) => {
            Livewire.emit('endmeeting');
        })
    })

</script>
@endpush

@push('styles')
<style>
    .welcome-page {
        display: none;
    }

</style>
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
