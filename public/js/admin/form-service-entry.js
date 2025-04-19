$(document).ready(function () {
    if (mode === 'edit' && serviceEntryId) {
        loadDataById(serviceEntryId);
    }

    // Form submit handler
    $('#service-entry-form').on('submit', function (e) {
        e.preventDefault();

        // Tampilkan spinner
        showSubmitSpinner('submit-button', 'spinner');

        var formElement = document.getElementById('service-entry-form');
        var formData = new FormData(formElement);

        const url = mode === 'edit' ? `/api/entri-servis/${serviceEntryId}` : '/api/entri-servis';
        const action = mode === 'edit' ? 'diubah' : 'ditambahkan';

        // Add status if POST
        if (mode === 'create') {
            formData.append('status', 'Dalam antrian');
        }

         // Add _method field for Laravel to handle PUT requests
         if (mode === 'edit') {
            formData.append('_method', 'PUT');
        }

        // Kirim request AJAX
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false, // <--- WAJIB untuk FormData
            contentType: false, // <--- WAJIB untuk FormData
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                hideSubmitSpinner('submit-button', 'spinner');
                showDialog('dialog-success', `Data entri servis berhasil ${action}!`);

                // Redirect after success if needed
                setTimeout(() => {
                    window.location.href = '/kelola-entri-servis';
                }, 2000);
            },
            error: function (xhr) {
                hideSubmitSpinner('submit-button', 'spinner');
                let response = xhr.responseJSON;
                showDialog('dialog-error', response?.message || `Data entri servis gagal ${action}!`);
            }
        });
    });

    function loadDataById(id) {
        $.ajax({
            url: `/api/entri-servis/${id}`,
            type: 'GET',
            contentType: 'application/json',
            success: function (response) {
                if (response && response.data) {
                    // Isi form dengan data yang diterima
                    $('#plat_no').val(response.data.plat_no || '');
                    $('#nama_pelanggan').val(response.data.nama_pelanggan || '');
                    $('#nama_pelanggan').val(response.data.nama_pelanggan || '');
                    $('#nomor_whatsapp').val(response.data.nomor_whatsapp || '');
                    $('#harga').val(response.data.harga || '');
                    $('#keterangan').val(response.data.keterangan || '');
                    $('#harga').val(response.data.harga || '');

                    if(mode === 'edit') {
                        const status = response.data.status;
                        $(`input[name="status"][value="${status}"]`).prop('checked', true);
                    }
                }
            },
            error: function (xhr) {
                let errorMessage = 'Gagal mengambil data entri servis.';

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

                if (errorMessage != "Data tidak ditemukan") showDialog('dialog-error', errorMessage);
            }
        });
    }

});