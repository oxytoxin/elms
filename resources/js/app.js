require('./bootstrap');

document.addEventListener('notification',(e)=>{
    document.querySelector('#notifAudio').play();
});