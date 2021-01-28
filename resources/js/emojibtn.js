import { EmojiButton } from '@joeattardi/emoji-button';

window.picker = new EmojiButton({
    autoHide : false,
});
const trigger = document.querySelector('#emojibtn');
const messageInput = document.querySelector('#messageInput');

trigger.addEventListener('click', () => picker.togglePicker(trigger));