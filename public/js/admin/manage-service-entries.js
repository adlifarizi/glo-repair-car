let selectedServiceEntryId = null;

// Fungsi untuk mengambil data kontak dari API
function loadData() {
    $.ajax({
        url: '/api/entri-servis',
        type: 'GET',
        contentType: 'application/json',
        success: function (response) {
            if (response && response.data) {
                var tableBody = $('#service-entries-table-body');
                tableBody.empty(); // Clear previous data

                // Loop through data and append rows to table
                response.data.forEach(function (item) {
                    var row = `
                        <tr class="odd:bg-white even:bg-gray-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="/ubah-entri-servis/${item.id}" class="text-blue-500 hover:underline">Ubah</a><br>
                                <button class="text-red-500 hover:underline" onclick="confirmDelete(${item.id})">Hapus</button><br>
                                <button class="text-orange-500 hover:underline">Ingatkan Pelanggan</button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.plat_no}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.nama_pelanggan}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.nomor_whatsapp}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.status}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="${item.sudah_dibayar === true ? 'text-green-500' : 'text-red-600'}">
                                    ${item.sudah_dibayar === true ? 'Sudah dibayar' : 'Belum dibayar'}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs break-words">${item.keterangan ?? ''}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp${formatNumber(item.harga)}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.prediksi ?? ''}</td>
                        </tr>
                    `;
                    tableBody.append(row);
                });

                // Clear and redraw the table
                var table = $('#data-table').DataTable();
                table.clear().rows.add($(tableBody).find('tr')).draw();
            }
        },
        error: function (xhr) {
            let errorMessage = 'Gagal mengambil data entri servis';

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

// Fungsi confirmDelete yang dipanggil saat tombol "Hapus" ditekan
function confirmDelete(id) {
    selectedServiceEntryId = id;
    showDialog('dialog-confirm-delete', 'Yaking ingin menghapus entri servis ini?');
}

// Helper function to format number (currency format)
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

$(document).ready(function () {
    // Inisiasi tabel
    var table = $('#data-table').DataTable({
        scrollX: true,
        lengthChange: false,
        language: {
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoFiltered: "",
            infoEmpty: "Tidak ada data tersedia",
        }
    });

    // Custom search
    $('#customSearch').on('keyup', function () {
        var searchInput = $(this).val()
        table.search(searchInput).draw();
    });

    // Filter tombol berdasarkan status servis
    $('.filter-btn').on('click', function () {
        var status = $(this).data('status');

        // Reset semua button ke tampilan default
        $('.filter-btn').removeClass('bg-red-200 text-red-500').addClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');

        // Aktifkan tombol yang diklik
        $(this).addClass('bg-red-200 text-red-500').removeClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');

        // Kolom ke-4 adalah "Status Servis" (dimulai dari 0)
        table.column(4).search(status).draw();
    });

    // Filter dari dropdown (untuk layar kecil)
    $('#filter-select').on('change', function () {
        var status = $(this).val();

        // Sinkronisasi tombol juga (jika mau)
        $('.filter-btn').removeClass('bg-red-200 text-red-500').addClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
        $('.filter-btn[data-status="' + status + '"]').addClass('bg-red-200 text-red-500').removeClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');

        table.column(4).search(status).draw();
    });

    // Load data saat halaman dibuka
    loadData();

    document.addEventListener('delete-confirmed', () => {
        try {
            $.ajax({
                url: `/api/entri-servis/${selectedServiceEntryId}`,
                type: 'DELETE',
                contentType: 'application/json',
                success: function (response) {
                    if (response) {
                        // Tutup dialog
                        document.getElementById('dialog-confirm-delete').classList.add('hidden');

                        // Tampilkan dialog sukses
                        showDialog('dialog-success', 'Data entri servis berhasil dihapus!');

                        // Muat ulang data tabel
                        loadData();
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'Data entri servis gagal dihapus!';

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

                    if (errorMessage != "Terjadi kesalahan saat menghapus data") showDialog('dialog-error', errorMessage);
                }
            });
        } catch {
            showDialog('dialog-error', 'Terjadi kesalahan tak terduga');
        }
    });

    // Batal
    document.addEventListener('delete-cancelled', () => {
        document.getElementById('dialog-confirm-delete').classList.add('hidden');
    });

});