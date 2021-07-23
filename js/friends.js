const link = document.querySelector('.main-navbar__link:first-child');
link.classList.add('selected');

const friendsList = document.querySelector('.friends-main__list');
const chevron = document.querySelector('.friends-main__tab .fa-chevron-up');
chevron.addEventListener('click', onFriendsChevronClick);

const addFriendModal = document.querySelector('dialog.add-friend');
addFriendModal.addEventListener('click', onAddFriendModalClick);
const addFriend = document.querySelector('.main-header__icons .fa-user-plus');
addFriend.addEventListener('click', showAddFriendModal);
const addFriendExit = addFriendModal.querySelector('.fa-arrow-left');
addFriendExit.addEventListener('click', hideAddFriendModal);

function onFriendsChevronClick() {
    friendsList.classList.toggle('closed');
    chevron.classList.toggle('flip');
}

function showAddFriendModal() { addFriendModal.classList.remove('add-friend--hidden'); }
function hideAddFriendModal() { addFriendModal.classList.add('add-friend--hidden'); }
function onAddFriendModalClick(event) {
    if (event.target == event.currentTarget)
        hideAddFriendModal();
}

const searchFriendModal = document.querySelector('dialog.search-friend');
const searchFriend = document.querySelector('.main-header__icons .fa-search');
searchFriend.addEventListener('click', showSearchFriendModal);
const searchFriendExit = searchFriendModal.querySelector('.fa-arrow-left');
searchFriendExit.addEventListener('click', hideSearchFriendModal);

function showSearchFriendModal() { searchFriendModal.classList.remove('search-friend--hidden'); }
function hideSearchFriendModal() { searchFriendModal.classList.add('search-friend--hidden'); }

const main = document.querySelector('main');
const header = document.querySelector('.main-header');
window.addEventListener('scroll', controlHeaderShadow);

function controlHeaderShadow() {
    const calcResult = main.offsetTop - window.scrollY;
    if (calcResult < 82)
        header.classList.add('show-box-shadow');
    else
        header.classList.remove('show-box-shadow');
}