require('./bootstrap');

document.addEventListener('notification',(e)=>{
    console.log('playing');
    document.querySelector('#notifAudio').pause();
    document.querySelector('#notifAudio').currentTime = 0;
    document.querySelector('#notifAudio').play();
});
document.addEventListener('message',(e)=>{
    console.log('playing');
    document.querySelector('#messageAudio').pause();
    document.querySelector('#messageAudio').currentTime = 0;
    document.querySelector('#messageAudio').play();
});