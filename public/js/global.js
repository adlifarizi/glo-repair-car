function showDialog(id, title = null, message = null) {
    const dialog = document.getElementById(id);
    if (title) {
        dialog.querySelector('h2').textContent = title;
    }
    if (message) {
        dialog.querySelector('p').textContent = message;
    }
    dialog.classList.remove('hidden');
}

function showConfirmDeleteDialog(id, title = null, message = null) {
    const dialog = document.getElementById(id);
    if (title) {
        dialog.querySelector('h2').textContent = title;
    }
    if (message) {
        dialog.querySelector('p').textContent = message;
    }
    dialog.classList.remove('hidden');
}

function showSubmitSpinner(buttonId, spinnerId) {
    const button = document.getElementById(buttonId);
    const spinner = document.getElementById(spinnerId);
    const buttonText = button.querySelector('#submit-button-text');

    button.disabled = true;
    buttonText.classList.add('hidden');
    spinner.classList.remove('hidden');
}

function hideSubmitSpinner(buttonId, spinnerId) {
    const button = document.getElementById(buttonId);
    const spinner = document.getElementById(spinnerId);
    const buttonText = button.querySelector('#submit-button-text');

    button.disabled = false;
    buttonText.classList.remove('hidden');
    spinner.classList.add('hidden');
}