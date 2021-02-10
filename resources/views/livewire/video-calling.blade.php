<div id="meet" class="w-full h-full">
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', () => {
        // const domain = 'meet.jit.si';
        const domain = 'jitsi.toxinsgrace.me';
        const options = {
            roomName: @this.room
            , userInfo: {
                email: @this.email
                , displayName: @this.name
            , }
            , configOverwrite: {
                enableWelcomePage: false
                , enableClosePage: true
                , disableProfile: true
                , prejoinPageEnabled: false
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
