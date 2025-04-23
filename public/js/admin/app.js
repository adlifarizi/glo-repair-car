function showDialog(id, message = null) {
    const dialog = document.getElementById(id);
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

function handleBackdropClick(event, dialogId) {
    const content = document.getElementById(dialogId + '-content');
    if (!content.contains(event.target)) {
        document.getElementById(dialogId).classList.add('hidden');
    }
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

let logoutInitiated = false;

$(document).ready(function () {
    $(document).on('click', '.btn-logout', function (e) {
        e.preventDefault();

        if (logoutInitiated) return;
        logoutInitiated = true;

        showDialog('dialog-confirm-logout', 'Anda yakin ingin logout?');
    });

    document.addEventListener('logout-confirmed', () => {
        const token = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');

        if (!token) {
            window.location.href = '/login';
            return;
        }

        $.ajax({
            url: '/api/logout',
            type: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                localStorage.removeItem('access_token');
                localStorage.removeItem('admin_name');
                sessionStorage.removeItem('access_token');
                sessionStorage.removeItem('admin_name');
                window.location.href = '/login';
            },
            error: function () {
                alert('Gagal logout. Silakan coba lagi.');
                logoutInitiated = false;
            }
        });
    });

    document.addEventListener('logout-cancelled', () => {
        document.getElementById('dialog-confirm-logout').classList.add('hidden');
        logoutInitiated = false;
    });
});
