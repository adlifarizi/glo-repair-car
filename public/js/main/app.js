
$(document).ready(function () {
    // Fetch maps coordinate
    $.ajax({
        url: '/api/maps',
        type: 'GET',
        contentType: 'application/json',
        success: function (response) {
            if (response && response.data) {
                const lat = response.data.latitude;
                const lng = response.data.longitude;

                // Reverse geocode
                $.ajax({
                    url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        const address = data.display_name || 'Alamat tidak ditemukan';
                        $('#footer-address').text(address);
                    },
                    error: function () {
                        $('#footer-address').text('Alamat gagal dimuat');
                    }
                });
            }
        },
        error: function () {
            $('#footer-address').text('Koordinat gagal dimuat');
        }
    });

    // Fetch contact info
    $.ajax({
        url: '/api/kontak',
        type: 'GET',
        contentType: 'application/json',
        success: function (response) {
            if (response && response.data) {
                $('#footer-phone').text(response.data.nomor_telepon || response.data.nomor_whatsapp || 'No HP tidak tersedia');
                $('#footer-email').text(response.data.email || 'Email tidak tersedia');
            }
        },
        error: function () {
            $('#footer-phone').text('No HP gagal dimuat');
            $('#footer-email').text('Email gagal dimuat');
        }
    });
});

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