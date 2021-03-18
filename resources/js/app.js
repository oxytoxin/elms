require('./bootstrap');

document.addEventListener('notification',(e)=>{
    document.querySelector('#notifAudio').pause();
    document.querySelector('#notifAudio').currentTime = 0;
    document.querySelector('#notifAudio').play();
});
document.addEventListener('message',(e)=>{
    document.querySelector('#messageAudio').play();
});