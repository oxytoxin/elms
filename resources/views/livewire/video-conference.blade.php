<div>
    <div id="screen" class="h-96">
    </div>
    <h1>Hello</h1>
    <button id="screenTrigger">screen</button>
    <button id="usersTrigger">users</button>
    <div id="video-container">
        <h1>{{ $name }}</h1>
    </div>
    <h1>RemoteUsers</h1>
    <div id="remote-container" class="flex">
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/videocall.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', ()=>{
            document.querySelector('#screenTrigger').addEventListener('click', startScreenCall)
            var rtc = {
                client: null,
                localAudioTrack: null,
                localVideoTrack: null,
            };

            var options = {
            appId: "67e208f4732c41f8884faaf2d70fd986",
            channel: "demo_channel_name",
            token: "00667e208f4732c41f8884faaf2d70fd986IADSrGhSG76EYogNReTukYabljob2ExVfPgU9dMbE/L/gY4kO3kAAAAAEABI+NBc394LYAEAAQDg3gtg",
            };

            rtc.client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
            document.querySelector('#usersTrigger').addEventListener('click',()=>{
                console.log(rtc.client.remoteUsers);
            })
            console.log(rtc.client.remoteUsers);
            const subscribeToStream = async (u) => {
                if (u.hasVideo) {
                    await rtc.client.subscribe(u, 'video')
                    const remoteVideoTrack = u.videoTrack;
                    let container = createContainer(u.uid.toString(), '#remote-container')
                    remoteVideoTrack.play(container);
                }
                if (u.hasAudio) {
                    await rtc.client.subscribe(u, 'audio')
                    const remoteAudioTrack = u.audioTrack;
                    remoteAudioTrack.play();
                }
            }

            const createContainer = (id, container) => {
                const playerContainer = document.createElement("div");
                const playerId = document.createElement("h1");
                playerId.innerHTML = id;
                // Specify the ID of the DIV container. You can use the `uid` of the remote user.
                playerContainer.id = id;
                playerContainer.classList.add('w-48','h-48','flex','flex-col','items-center');
                playerContainer.append(playerId);
                let videoContainer = document.querySelector(container);
                videoContainer.append(playerContainer);
                return playerContainer;
            }

            async function leaveCall() {
                rtc.localAudioTrack.close();
                rtc.localVideoTrack.close();
                rtc.client.remoteUsers.forEach(user => {
                    const playerContainer = document.getElementById(user.uid);
                    playerContainer && playerContainer.remove();
                });
                await rtc.client.leave();
            }

            async function startScreenCall() {
            const screenClient = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
            await screenClient.join(options.appId, options.channel, options.token);
            const screenTrack = await AgoraRTC.createScreenVideoTrack();
            await screenClient.publish(screenTrack);
            console.log(screenClient.uid)
            const screen_container = document.querySelector('#screen');
            screenTrack.play(screen_container);
            return screenClient;
            }

            async function startBasicCall() {

                const uid = await rtc.client.join(options.appId, options.channel, options.token, @this.name);
                rtc.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
                rtc.localVideoTrack = await AgoraRTC.createCameraVideoTrack();
                let container = createContainer(rtc.client.uid.toString(), '#video-container')
                const myVideoTrack = rtc.localVideoTrack;
                myVideoTrack.play(container)
                await rtc.client.publish([rtc.localAudioTrack, rtc.localVideoTrack]);
                let pre_users = rtc.client.remoteUsers;
                pre_users.forEach(subscribeToStream);
                rtc.client.on("user-published", async (user, mediaType) => {
                    await rtc.client.subscribe(user, mediaType);
                    console.log("subscribe success");
                    if (mediaType === "video") {
                        const remoteVideoTrack = user.videoTrack;
                        let container =createContainer(user.uid.toString(), '#remote-container')
                        remoteVideoTrack.play(container);
                    }
                    if (mediaType === "audio") {
                        const remoteAudioTrack = user.audioTrack;
                        remoteAudioTrack.play();
                    }
                    });
                    rtc.client.on("user-unpublished", user => {
                    const playerContainer = document.getElementById(user.uid);
                    playerContainer && playerContainer.remove();
                    });
            }

            startBasicCall();
        });
    </script>
@endpush