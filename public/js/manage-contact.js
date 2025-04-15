$(document).ready(function () {

    // Load data saat halaman dibuka
    loadContactData();

    // Form submit handler
    $('#contact-form').on('submit', function (e) {
        e.preventDefault();

        // Tampilkan spinner
        showSubmitSpinner('submit-button', 'spinner');

        // Ambil data form
        var formData = {
            email: $('#email').val(),
            instagram: $('#instagram').val(),
            nomor_telepon: $('#nomor_telepon').val(),
            nomor_whatsapp: $('#nomor_whatsapp').val()
        };

        // Kirim request AJAX
        $.ajax({
            url: '/api/kontak',
            type: 'PUT',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                hideSubmitSpinner('submit-button', 'spinner');
                showDialog('dialog-success', 'Data kontak berhasil diubah!');
            },
            error: function (xhr) {
                hideSubmitSpinner('submit-button', 'spinner');
                let errorMessage = 'Data kontak gagal diubah!';

                // Coba parse error response
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        const firstError = Object.values(errors)[0];
                        errorMessage = Array.isArray(firstError) ? firstError[0] : firstError;
                    }
                }

                showDialog('dialog-error', errorMessage);
            }
        });
    });

    // Fungsi untuk mengambil data kontak dari API
    function loadContactData() {
        $.ajax({
            url: '/api/kontak',
            type: 'GET',
            contentType: 'application/json',
            success: function (response) {
                if (response && response.data) {
                    // Isi form dengan data yang diterima
                    $('#email').val(response.data.email || '');
                    $('#instagram').val(response.data.instagram || '');
                    $('#nomor_telepon').val(response.data.nomor_telepon || '');
                    $('#nomor_whatsapp').val(response.data.nomor_whatsapp || '');
                }
            },
            error: function (xhr) {
                showDialog('dialog-error', 'Gagal mengambil data kontak');
            }
        });
    }
});