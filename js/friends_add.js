const form = document.querySelector('.search-friend__form');
const submitButton = document.getElementById('submit-button');
submitButton.addEventListener('click', () => { form.submit(); });

const chararcterCount = document.getElementById('character-count');
const resetInput = document.querySelector('.search-friend__reset-input');
const searchInput = document.querySelector('.search-friend__form input');
if (searchInput)
    searchInput.addEventListener('keyup', onSearchInputKeyUp);

function onSearchInputKeyUp() {
    const charLength = parseInt(searchInput.value.length);
    chararcterCount.innerText = charLength;

    if (charLength > 0)
        resetInput.classList.remove('hidden');
    else
        resetInput.classList.add('hidden');
}