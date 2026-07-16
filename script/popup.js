// popup.js

window.addEventListener('DOMContentLoaded', () => {
    // Check if messages exist
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');

    if (successMessage && successMessage.textContent.trim() !== '') {
        alert(successMessage.textContent);
    }

    if (errorMessage && errorMessage.textContent.trim() !== '') {
        alert(errorMessage.textContent);
    }
});
