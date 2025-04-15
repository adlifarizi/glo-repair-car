let selectedFeedbackId = null;

// Fungsi untuk mengambil data kontak dari API
function loadData() {
    $.ajax({
        url: '/api/feedback',
        type: 'GET',
        contentType: 'application/json',
        success: function (response) {
            if (response && response.data) {
                var tableBody = $('#feedback-table-body');
                tableBody.empty(); // Clear previous data

                // Loop through data and append rows to table
                response.data.forEach(function (item) {
                    var row = `
                        <tr class="odd:bg-white even:bg-gray-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button class="text-red-500 hover:underline" onclick="confirmDelete(${item.id})">Hapus</button><br>
                                <button class="text-orange-500 hover:underline" onclick="toggleVisibility(${item.id}, ${item.show})">
                                    ${item.show ? 'Sembunyikan' : 'Tampilkan' }
                                </button>
                            </td>
                            <td class="hidden">${item.show}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.rating}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.plat_no}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.nama_pelanggan}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.feedback}</td>
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
            let errorMessage = 'Gagal mengambil data ulasan';

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
    selectedFeedbackId = id;
    showDialog('dialog-confirm-delete', 'Yaking ingin menghapus ulasan ini?');
}

function toggleVisibility(id, currentStatus) {
    selectedFeedbackId = id;
    const newStatus = currentStatus ? 0 : 1;
    const action = newStatus ? 'ditampilkan' : 'disembunyikan';

    $.ajax({
        url: `/api/feedback/${selectedFeedbackId}/toggle-show`,
        type: 'PUT',
        contentType: 'application/json',
        success: function (response) {
            if (response) {
                // Tampilkan dialog sukses
                showDialog('dialog-success', `Data ulasan berhasil ${action}!`);

                // Muat ulang data tabel
                loadData();
            }
        },
        error: function (xhr) {
            let errorMessage = `Data ulasan gagal ${action}!`;

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

            if (errorMessage != "Terjadi kesalahan saat mengedit data") showDialog('dialog-error', errorMessage);
        }
    });
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
        },
        columnDefs: [
            {
                targets: 1, // Kolom ke-1, yaitu kolom "show"
                visible: false,
                searchable: true 
            }
        ]
    });

    table.column(1).search("1").draw();
    $('.filter-btn[data-show="1"]').addClass('bg-red-200 text-red-500');

    function updateFilterText(show) {
        if (show == 1) {
            $('#judul-tabel').text('Data Ulasan yang ditampilkan');
            $('#deskripsi-tabel').text('Data ini merupakan ulasan yang ditampilkan di website utama');
        } else {
            $('#judul-tabel').text('Data Ulasan yang disembunyikan');
            $('#deskripsi-tabel').text('Data ini merupakan ulasan yang disembunyikan di website utama');
        }
    }

    $('.filter-btn').on('click', function () {
        var show = $(this).data('show');
        $('.filter-btn').removeClass('bg-red-200 text-red-500').addClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
        $(this).addClass('bg-red-200 text-red-500').removeClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
        table.column(1).search(show).draw();
        updateFilterText(show);
    });

    $('#filter-select').on('change', function () {
        var show = $(this).val();
        $('.filter-btn').removeClass('bg-red-200 text-red-500').addClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
        $('.filter-btn[data-show="' + show + '"]').addClass('bg-red-200 text-red-500').removeClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
        table.column(1).search(show).draw();
        updateFilterText(show);
    });

    // Load data saat halaman dibuka
    loadData();

    document.addEventListener('delete-confirmed', () => {
        try {
            $.ajax({
                url: `/api/feedback/${selectedFeedbackId}`,
                type: 'DELETE',
                contentType: 'application/json',
                success: function (response) {
                    if (response) {
                        // Tutup dialog
                        document.getElementById('dialog-confirm-delete').classList.add('hidden');

                        // Tampilkan dialog sukses
                        showDialog('dialog-success', 'Data ulasan berhasil dihapus!');

                        // Muat ulang data tabel
                        loadData();
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'Data ulasan gagal dihapus!';

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