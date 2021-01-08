import { EmojiButton } from '@joeattardi/emoji-button';

window.picker = new EmojiButton({
    autoHide : false,
});
const trigger = document.querySelector('#emojibtn');
const messageInput = document.querySelector('#messageInput');

// picker.on('emoji', selection => {
//  messageInput.value += selection.emoji;
// });

trigger.addEventListener('click', () => picker.togglePicker(trigger));