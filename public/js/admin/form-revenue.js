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
        const action = mode === 'edit' ? 'diubah' : 'ditambahkan';

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
                showDialog('dialog-success', `Data pemasukan berhasil ${action}!`);

                // Redirect after success if needed
                setTimeout(() => {
                    window.location.href = '/kelola-pemasukan';
                }, 2000);
            },
            error: function (xhr) {
                hideSubmitSpinner('submit-button', 'spinner');
                let response = xhr.responseJSON;
                showDialog('dialog-error', response?.message || `Data pemasukan gagal ${action}!`);
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
                    const data = response.data;

                    // Ambil detail entri servis (karena dari pemasukan tidak lengkap)
                    if (data.id_servis) {
                        $.ajax({
                            url: `/api/entri-servis/${data.id_servis}`,
                            type: 'GET',
                            contentType: 'application/json',
                            success: function (servisResponse) {
                                if (servisResponse && servisResponse.data) {
                                    const servis = servisResponse.data;

                                    const label = `${servis.id} • ${servis.plat_no || '-'} • ${servis.nama_pelanggan || '-'} • ${'Rp' + formatNumber(servis.harga) || '-'} • ${servis.tanggal_selesai ? new Date(servis.tanggal_selesai).toLocaleDateString() : 'Belum selesai'}`;

                                    // Tambahkan manual ke Tom Select kalau belum ada
                                    if (!select.options[servis.id]) {
                                        select.addOption({
                                            id: servis.id,
                                            text: label
                                        });
                                    }

                                    // Set sebagai nilai terpilih
                                    select.setValue(servis.id);
                                }
                            },
                            error: function () {
                                console.error('Gagal mengambil detail entri servis');
                            }
                        });
                    }

                    $('#nominal').val(data.nominal || '');

                    if (data.tanggal_pemasukan) {
                        const dateOnly = data.tanggal_pemasukan.split(' ')[0];
                        datePicker.setDate(dateOnly, true, "Y-m-d");
                    }

                    if (data.bukti_pemasukan) {
                        const filename = data.bukti_pemasukan.split('/').pop();
                        fileName.textContent = filename || 'File sudah ada';
                        input.removeAttribute('required');
                        input.dataset.existingFile = data.bukti_pemasukan;
                    }

                    $('#keterangan').val(data.keterangan || '');
                }
            },
            error: function (xhr) {
                let errorMessage = 'Gagal mengambil data pemasukan.';

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

    // Inisialisasi Tom Select
    const select = new TomSelect('#id_servis', {
        valueField: 'id',
        labelField: 'text',
        searchField: 'text',
        create: false,
        placeholder: 'Pilih entri servis',
        render: {
            option: function (data, escape) {
                return `<div>${data.text}</div>`;
            },
            item: function (data, escape) {
                return `<div>${data.text.split(' • ')[0]}</div>`;
            }
        }
    });

    // Ambil data dari API
    $.ajax({
        url: '/api/entri-servis',
        type: 'GET',
        contentType: 'application/json',
        success: function (response) {
            if (response && response.data) {
                // Filter data yang belum dibayar
                const unpaidServices = response.data.filter(item => !item.sudah_dibayar);

                if (unpaidServices.length > 0) {
                    // Format data untuk dropdown
                    const options = unpaidServices.map(item => {
                        const formattedDate = item.tanggal_selesai
                            ? new Date(item.tanggal_selesai).toLocaleDateString()
                            : 'Belum selesai';

                        return {
                            id: item.id,
                            text: `${item.id} • ${item.plat_no} • ${item.nama_pelanggan} • ${'Rp' + formatNumber(item.harga) || '-'} • ${formattedDate}`
                        };
                    });

                    // Tambahkan options ke select
                    select.addOptions(options);

                    // Set nilai old input jika ada
                    const oldValue = "{{ old('id_servis', '') }}";
                    if (oldValue) {
                        select.setValue(oldValue);
                    }
                } else {
                    // Jika kosong, tampilkan info di dropdown
                    const infoId = 'no-servis-available';
                    select.addOption({
                        id: infoId,
                        text: '⚠️ Tidak ada data servis yang belum selesai & belum dibayar',
                        disabled: true
                    });
                    select.setValue(infoId);
                }
            }
        },
        error: function (xhr) {
            console.error('Gagal mengambil data servis:', xhr);
        }
    });

    // Helper function to format number (currency format)
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }
});