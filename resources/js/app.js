require('./bootstrap');

document.addEventListener('notification',(e)=>{
    document.querySelector('#notifAudio').play();
});
document.addEventListener('message',(e)=>{
    document.querySelector('#messageAudio').play();
});