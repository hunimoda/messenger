const password = document.getElementById('password');
const passwordCheck = document.getElementById('password-re');
passwordCheck.addEventListener('keyup', checkPassword);

const passwordCheckSpan = document.querySelector('.password-check__message');

const signupForm = document.getElementById('signup-page__form');
signupForm.addEventListener('submit', checkBeforeSubmit);

function checkPassword() {
    let checkResult = false;
    let innerHTML = '';
    passwordCheckSpan.classList.remove('password-check__message--pass');

    if (password.value == '') {
        innerHTML = '<i class="fas fa-exclamation-triangle"></i> 비밀번호를 입력하세요.';
        passwordCheck.value = '';
        password.focus();
    }
    else if (passwordCheck.value != password.value) {
        innerHTML = '<i class="fas fa-exclamation-triangle"></i> 비밀번호가 일치하지 않습니다!';
        passwordCheck.focus();
    }
    else {
        innerHTML = '<i class="fas fa-check-circle"></i> 비밀번호가 일치합니다.';
        passwordCheckSpan.classList.add('password-check__message--pass');
        checkResult = true;
    }

    passwordCheckSpan.innerHTML = innerHTML;
    return checkResult;
}

function checkBeforeSubmit(event) {
    if (!checkPassword())
        event.preventDefault();
}