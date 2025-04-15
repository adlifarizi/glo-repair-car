let selectedPengeluaranId = null;

// Fungsi confirmDelete yang dipanggil saat tombol "Hapus" ditekan
function confirmDelete(id) {
    selectedPengeluaranId = id;
    showDialog('dialog-confirm-delete');
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

    // Load data saat halaman dibuka
    loadData();

    // Fungsi untuk mengambil data kontak dari API
    function loadData() {
        $.ajax({
            url: '/api/pengeluaran',
            type: 'GET',
            contentType: 'application/json',
            success: function (response) {
                if (response && response.data) {
                    var tableBody = $('#pengeluaran-table-body');
                    tableBody.empty(); // Clear previous data

                    // Loop through data and append rows to table
                    response.data.forEach(function (item) {
                        var row = `
                            <tr class="odd:bg-white even:bg-gray-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="/ubah-pengeluaran/${item.id}" class="text-blue-500 hover:underline">Ubah</a><br>
                                    <button class="text-red-500 hover:underline" onclick="confirmDelete(${item.id})">Hapus</button><br>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp${formatNumber(item.nominal)}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${formatDate(item.tanggal_pengeluaran)}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${item.keterangan ?? ''}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    ${item.bukti_pengeluaran
                                ? `<a href="${item.bukti_pengeluaran}" target="_blank" class="text-blue-500 hover:underline">Preview</a>`
                                : ''}
                                </td>

                            </tr>
                        `;
                        tableBody.append(row);
                    });

                    // Important: Clear and redraw the table
                    table.clear().rows.add($(tableBody).find('tr')).draw();
                }
            },
            error: function (xhr) {
                let errorMessage = 'Gagal mengambil data pengeluaran';

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

    // Helper function to format number (currency format)
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function formatDate(dateString) {
        const options = { day: '2-digit', month: 'long', year: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', options);
    }

    document.addEventListener('delete-confirmed', () => {
        try {
            $.ajax({
                url: `/api/pengeluaran/${selectedPengeluaranId}`,
                type: 'DELETE',
                contentType: 'application/json',
                success: function (response) {
                    if (response) {
                        // Tutup dialog
                        document.getElementById('dialog-confirm-delete').classList.add('hidden');

                        // Tampilkan dialog sukses
                        showDialog('dialog-success');

                        // Muat ulang data tabel
                        loadData();
                    }
                },
                error: function (xhr) {
                    let errorMessage = 'Gagal menghapus data pengeluaran';

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

                    if (errorMessage != "Terjadi kesalahan saat menghapus data") showDialog('dialog-error', null, errorMessage);
                }
            });
        } catch {
            showDialog('dialog-error');
        }
    });

    // Batal
    document.addEventListener('delete-cancelled', () => {
        document.getElementById('dialog-confirm-delete').classList.add('hidden');
    });

});