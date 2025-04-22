document.addEventListener('DOMContentLoaded', function () {
    const errorBox = document.getElementById('login-error');

    if (errorBox && errorBox.textContent.trim() !== '') {
        errorBox.style.display = 'block';
    }
});
