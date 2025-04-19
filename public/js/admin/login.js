$(document).ready(function () {
    // Form submit handler
    $('#login-form').on('submit', function (e) {
        e.preventDefault();

        // Tampilkan spinner
        showSubmitSpinner('submit-button', 'spinner');

        // Ambil data form
        var formData = {
            email: $('#email').val(),
            password: $('#password').val(),
        };

        // Kirim request AJAX
        $.ajax({
            url: '/api/login',
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                hideSubmitSpinner('submit-button', 'spinner');
                showDialog('dialog-success');

                // Simpan token
                localStorage.setItem('access_token', response.access_token);

                // Arahkan ke dashboard atau halaman utama
                window.location.href = window.location.origin + "/dashboard";
            },
            error: function (xhr) {
                hideSubmitSpinner('submit-button', 'spinner');

                let response = xhr.responseJSON;

                // Reset pesan error sebelumnya
                $('.error-message').remove();

                if (xhr.status === 422 && response.errors) {
                    // Validasi form (misalnya input kosong, email invalid)
                    $.each(response.errors, function (key, messages) {
                        const input = $('#' + key);
                        input.after('<p class="text-red-500 text-sm error-message mt-1">' + messages[0] + '</p>');
                    });
                } else {
                    showDialog('dialog-error', response.message);
                }
            }
        });
    });
});