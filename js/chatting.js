const submitButton = document.getElementById('submit-button');
submitButton.addEventListener('click', openUpForm);

const container = document.getElementById('message-box');
const input = document.getElementById('message-input');

const userNoteButton = document.getElementById('user-note-btn');
if (userNoteButton)
    userNoteButton.addEventListener('click', openUpForm);

function openUpForm(event) {
    if (!container.classList.contains('send-message__container--open')) {
        event.preventDefault();
        container.classList.add('send-message__container--open');
        input.classList.add('send-message__input--active');
        input.focus();

        if (userNoteButton)
            userNoteButton.classList.add('user-notification--closed');
    }
}

const anchorToLast = document.createElement('a');
anchorToLast.href = "#last-chat";
anchorToLast.click();