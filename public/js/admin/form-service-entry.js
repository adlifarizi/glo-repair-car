$(document).ready(function () {
    let sudahBayar = false;
    let idServis = 0;
    let platNoServis = '';
    let nominalServis = 0;

    if (mode === 'edit' && serviceEntryId) {
        loadDataById(serviceEntryId);
    }

    // Form submit handler
    $('#service-entry-form').on('submit', async function (e) {
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

            const status = formData.get('status');
            const harga = parseInt(formData.get('harga'), 10);
            const createdAt = formData.get('created_at');

            if (status === 'Selesai' && harga && createdAt) {
                try {
                    const createdDate = new Date(createdAt);
                    const now = new Date();
                    const durasi_hari = Math.max(1, Math.ceil((now - createdDate) / (1000 * 60 * 60 * 24))); // hindari 0 hari

                    const predictionResponse = await fetch('https://glo-prediction.domcloud.dev/predict', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            harga: harga,
                            durasi_hari: durasi_hari
                        })
                    });

                    const predictionData = await predictionResponse.json();

                    if (predictionResponse.ok) {
                        formData.append('prediksi', predictionData.prediksi_hari_kunjungan);
                    } else {
                        throw new Error(predictionData?.message || 'Gagal memuat prediksi');
                    }
                } catch (error) {
                    hideSubmitSpinner('submit-button', 'spinner');
                    showDialog('dialog-error', 'Gagal memuat prediksi kunjungan: ' + error.message);
                    return;
                }
            }
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
                    $('#created_at').val(response.data.created_at || '')

                    // Ambil sudah_bayar dari response
                    sudahBayar = response.data.sudah_bayar;
                    idServis = response.data.id
                    platNoServis = response.data.plat_no
                    nominalServis = response.data.harga

                    if (mode === 'edit') {
                        const status = response.data.status;
                        $(`input[name="status"][value="${status}"]`).prop('checked', true);

                        // Jika status "Selesai", disable semua radio status agar tidak bisa diubah
                        if (status === 'Selesai') {
                            $('input[name="status"]').prop('disabled', true);
                        } else {
                            $('input[name="status"]').prop('disabled', false);
                        }
                    }

                    // Update tombol berdasarkan status dan sudah_bayar
                    updateTombolTransaksi();
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



    /*
    |--------------------------------------------------------------------------
    | Selesaikan Transaksi
    |--------------------------------------------------------------------------
    */
    function updateTombolTransaksi() {
        const btn = $('#selesaikan-transaksi-btn');
        const selectedStatus = $('input[name="status"]:checked').val();

        if (selectedStatus === 'Selesai' && !sudahBayar) {
            btn.prop('disabled', false)
                .removeClass('btn-disabled')
                .addClass('btn-active');
        } else {
            btn.prop('disabled', true)
                .removeClass('btn-active')
                .addClass('btn-disabled');
        }
    }

    // Inisialisasi
    updateTombolTransaksi();

    // Update saat radio status berubah
    $('input[name="status"]').on('change', function () {
        updateTombolTransaksi();
    });

    $('#selesaikan-transaksi-btn').click(function (e) {
        e.preventDefault(); // Mencegah form submit
        openModal();
    });

    $('#batal-btn').click(function () {
        closeModal(); // Menutup modal saat tombol batal diklik
    });


    // Fungsi untuk membuka modal
    function openModal() {
        $('#id_servis').val(idServis);
        $('#keterangan_modal').val(`Pemasukan dari entri servis dengan plat no: ${platNoServis}`);
        $('#nominal').val(nominalServis);
        const today = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
        $('#tanggal_pemasukan').val(today);

        $('#modal-pemasukan')
            .removeClass('hidden')
            .addClass('flex');

    }

    // Fungsi untuk menutup modal
    function closeModal() {
        $('#modal-pemasukan')
            .removeClass('flex')
            .addClass('hidden');
    }

    // Fungsi untuk mengirimkan data via AJAX
    $('#form-pemasukan').submit(function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: '/api/pemasukan',
            type: 'POST',
            data: formData,
            processData: false, // <--- WAJIB untuk FormData
            contentType: false, // <--- WAJIB untuk FormData
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                showDialog('dialog-success', `Data pemasukan berhasil ditambahkan!`);
                closeModal(); // Menutup modal setelah sukses
            },
            error: function (xhr) {
                let response = xhr.responseJSON;
                showDialog('dialog-error', response?.message || `Data pemasukan gagal ditambahkan!`);
            }
        });
    });


});