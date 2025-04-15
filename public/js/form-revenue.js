$(document).ready(function () {

    const datePicker = flatpickr("#tanggal_pemasukan", {
        dateFormat: "Y-m-d",
        allowInput: true,
    });

    const input = document.getElementById('bukti_pemasukan');
    const fileName = document.getElementById('file-name');

    input.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            fileName.textContent = this.files[0].name;
        } else {
            fileName.textContent = '';
        }
    });

    if (mode === 'edit' && pemasukanId) {
        loadDataById(pemasukanId);
    }

    // Form submit handler
    $('#revenue-form').on('submit', function (e) {
        e.preventDefault();

        // Tampilkan spinner
        showSubmitSpinner('submit-button', 'spinner');

        var formElement = document.getElementById('revenue-form');
        var formData = new FormData(formElement);

        const url = mode === 'edit' ? `/api/pemasukan/${pemasukanId}` : '/api/pemasukan';

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
                showDialog('dialog-success');

                // Redirect after success if needed
                setTimeout(() => {
                    window.location.href = '/kelola-pemasukan';
                }, 2000);
            },
            error: function (xhr) {
                hideSubmitSpinner('submit-button', 'spinner');
                let response = xhr.responseJSON;
                showDialog('dialog-error', null, response?.message || 'Terjadi kesalahan saat menyimpan data');
            }
        });
    });

    function loadDataById(id) {
        $.ajax({
            url: `/api/pemasukan/${id}`,
            type: 'GET',
            contentType: 'application/json',
            success: function (response) {
                if (response && response.data) {
                    // Isi form dengan data yang diterima
                    $('#id_servis').val(response.data.id_servis || '');
                    $('#nominal').val(response.data.nominal || '');

                    // Format tanggal jika perlu
                    if (response.data.tanggal_pemasukan) {
                        // Extract date part if it's a datetime string
                        const dateString = response.data.tanggal_pemasukan;
                        // Parse and set the date correctly for flatpickr
                        const dateOnly = dateString.split(' ')[0]; // Get just the date part

                        // Set the date properly via flatpickr API
                        datePicker.setDate(dateOnly, true, "Y-m-d");
                    }

                    // Handle file input differently - we can't set its value,
                    // but we can show the filename in our custom element
                    if (response.data.bukti_pemasukan) {
                        // Extract just the filename from the path
                        const fullPath = response.data.bukti_pemasukan;
                        const filename = fullPath.split('/').pop();
                        fileName.textContent = filename || 'File sudah ada';

                        // Make file input not required since we already have a file
                        input.removeAttribute('required');

                        // Store the existing file path
                        input.dataset.existingFile = fullPath;
                    }

                    $('#keterangan').val(response.data.keterangan || '');
                }
            },
            error: function (xhr) {
                let errorMessage = 'Gagal mengambil data pemasukan.';

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

                if (errorMessage != "Data tidak ditemukan") showDialog('dialog-error', null, errorMessage);
            }
        });
    }

});