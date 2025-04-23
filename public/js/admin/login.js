$(document).ready(function () {
    // Periksa token di localStorage atau sessionStorage
    if (localStorage.getItem('access_token') || sessionStorage.getItem('access_token')) {
        // Token ditemukan, arahkan ke dashboard daripada login ulang
        window.location.href = window.location.origin + "/dashboard";
    }

    // Form submit handler
    $('#login-form').on('submit', function (e) {
        e.preventDefault();

        // Tampilkan spinner
        showSubmitSpinner('submit-button', 'spinner');

        // Ambil data form
        var formData = {
            email: $('#email').val(),
            password: $('#password').val(),
            remember: $('#remember_me').is(':checked') ? 1 : 0,
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
                console.log(response)
                hideSubmitSpinner('submit-button', 'spinner');
                showDialog('dialog-success');

                // Simpan token sesuai dengan 'remember'
                if (formData.remember) {
                    localStorage.setItem('access_token', response.access_token);  // Simpan di localStorage jika remember me
                    localStorage.setItem('admin_name', response.admin_name);
                } else {
                    sessionStorage.setItem('access_token', response.access_token);  // Simpan di sessionStorage jika tidak remember me
                    sessionStorage.setItem('admin_name', response.admin_name);
                }

                // Arahkan ke dashboard     atau halaman utama
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