import AgoraRTC from "agora-rtc-sdk-ng"
AgoraRTC.setLogLevel(4);
var rtc = {
    // For the local client.
    client: null,
    // For the local audio and video tracks.
    localAudioTrack: null,
    localVideoTrack: null,
  };

var options = {
// Pass your app ID here.
appId: "67e208f4732c41f8884faaf2d70fd986",
// Set the channel name.
channel: "demo_channel_name",
// Pass a token if your project enables the App Certificate.
token: "00667e208f4732c41f8884faaf2d70fd986IADSrGhSG76EYogNReTukYabljob2ExVfPgU9dMbE/L/gY4kO3kAAAAAEABI+NBc394LYAEAAQDg3gtg",
};

async function startBasicCall() {
rtc.client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
const uid = await rtc.client.join(options.appId, options.channel, options.token);
console.log(rtc.client)
// Create an audio track from the audio sampled by a microphone.
rtc.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
// Create a video track from the video captured by a camera.
rtc.localVideoTrack = await AgoraRTC.createCameraVideoTrack();
// Publish the local audio and video tracks to the channel.
const playerContainer = document.createElement("div");
        // Specify the ID of the DIV container. You can use the `uid` of the remote user.
        playerContainer.id = rtc.client.uid.toString();
        playerContainer.style.width = "150px";
        playerContainer.style.height = "150px";
        let videoContainer = document.querySelector('#video-container');
        videoContainer.append(playerContainer);
        const myVideoTrack = rtc.localVideoTrack;
        myVideoTrack.play(playerContainer)
await rtc.client.publish([rtc.localAudioTrack, rtc.localVideoTrack]);
console.log("publish success!");
// Livewire.emit('newUser',uid);
rtc.client.on("user-published", async (user, mediaType) => {
    // Subscribe to a remote user.
    await rtc.client.subscribe(user, mediaType);
    console.log("subscribe success");

    // If the subscribed track is video.
    if (mediaType === "video") {
        // Get `RemoteVideoTrack` in the `user` object.
        const remoteVideoTrack = user.videoTrack;
        // Dynamically create a container in the form of a DIV element for playing the remote video track.
        const playerContainer = document.createElement("div");
        // Specify the ID of the DIV container. You can use the `uid` of the remote user.
        playerContainer.id = user.uid.toString();
        playerContainer.style.width = "150px";
        playerContainer.style.height = "150px";
        let videoContainer = document.querySelector('#remote-container');
        videoContainer.append(playerContainer);

        // Play the remote video track.
        // Pass the DIV container and the SDK dynamically creates a player in the container for playing the remote video track.
        remoteVideoTrack.play(playerContainer);

        // Or just pass the ID of the DIV container.
        // remoteVideoTrack.play(playerContainer.id);
    }

    // If the subscribed track is audio.
    if (mediaType === "audio") {
        // Get `RemoteAudioTrack` in the `user` object.
        const remoteAudioTrack = user.audioTrack;
        // Play the audio track. No need to pass any DOM element.
        remoteAudioTrack.play();
    }
    });
    rtc.client.on("user-unpublished", user => {
    // Get the dynamically created DIV container.
    const playerContainer = document.getElementById(user.uid);
    // Destroy the container.
    playerContainer && playerContainer.remove();
    });
    async function leaveCall() {
    // Destroy the local audio and video tracks.
    rtc.localAudioTrack.close();
    rtc.localVideoTrack.close();

    // Traverse all remote users.
    rtc.client.remoteUsers.forEach(user => {
        // Destroy the dynamically created DIV container.

        const playerContainer = document.getElementById(user.uid);
        playerContainer && playerContainer.remove();
    });

    // Leave the channel.
    await rtc.client.leave();
    }
}

startBasicCall();
// document.addEventListener('livewire:load',()=>{
// })