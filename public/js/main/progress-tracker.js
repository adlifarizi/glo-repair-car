$(document).ready(function () {
    // Inisialisasi awal: sembunyikan tab riwayat
    $('#history_content').addClass('hidden');
    $('#info_content').removeClass('hidden');
    $('#info_tab').addClass('text-red-500 border-b-2 border-red-500');
    $('#history_tab').removeClass('text-red-500 border-b-2 border-red-500').addClass('text-gray-500');

    // Tab switching (diletakkan di luar agar tidak nambah handler berkali-kali)
    $('#info_tab').on('click', function () {
        $('#info_content').removeClass('hidden');
        $('#history_content').addClass('hidden');
        $(this).addClass('text-red-500 border-b-2 border-red-500');
        $('#history_tab').removeClass('text-red-500 border-b-2 border-red-500').addClass('text-gray-500');
    });

    $('#history_tab').on('click', function () {
        $('#info_content').addClass('hidden');
        $('#history_content').removeClass('hidden');
        $(this).addClass('text-red-500 border-b-2 border-red-500');
        $('#info_tab').removeClass('text-red-500 border-b-2 border-red-500').addClass('text-gray-500');
    });

    $('#search_button, #submit-button').on('click', function () {
        const platNo = $('#plat_no').val().trim();

        if (!platNo) {
            showProgressTrackerErrorDialog('dialog-error', 'Mohon masukkan nomor plat!');
            return;
        }

        // Tampilkan spinner
        showSubmitSpinner('submit-button', 'spinner');

        $.ajax({
            url: '/api/check-progress',
            method: 'GET',
            data: { plat_no: platNo },
            success: function (response) {

                hideSubmitSpinner('submit-button', 'spinner');

                const data = response.data;

                if (data.length === 0) {
                    alert('Data tidak ditemukan');
                    return;
                }

                $('#progress_tracker').removeClass('hidden');

                const current = data[0];
                const statusSteps = ['Dalam antrian', 'Sedang diperbaiki', 'Selesai'];
                const currentStatusIndex = statusSteps.indexOf(current.status);

                $('#progress_updated_at').text(formatDate(current.updated_at));

                let statusHTML = '';
                statusSteps.forEach((status, index) => {
                    const isDone = index < currentStatusIndex;
                    const isActive = index === currentStatusIndex;

                    statusHTML += `
                        <div class="flex items-center">
                            <div class="w-10 h-10 ${isDone || isActive ? 'bg-green-600' : 'bg-gray-300'} rounded-lg text-white flex items-center justify-center">
                                <i class="fa fa-check text-xl"></i>
                            </div>
                            <div class="ml-4 font-medium ${isDone || isActive ? 'text-green-600' : 'text-gray-500'}">${status}</div>
                        </div>
                        ${index < statusSteps.length - 1 ? `
                            <div class="h-10 w-1 my-2 bg-gray-300 mx-4 relative">
                                <div class="absolute left-0 top-0 w-1 ${isDone ? 'bg-green-600' : ''}" style="height: 100%;"></div>
                            </div>
                        ` : ''}
                    `;
                });

                $('#status_steps').html(statusHTML);

                $('#info_content').html(`
                    <div class="flex items-center mb-2">
                        <i class='bx bxs-info-circle text-xl text-gray-800'></i>
                        <p class="ml-2 text-gray-800 font-medium">Informasi Servis</p>
                    </div>
                    <div class="w-full h-[1px] bg-gray-300 mb-4"></div>
                    <div class="grid grid-cols-[auto_min-content_auto] gap-x-3 gap-y-2 w-fit h-fit">
                        <p class="text-gray-700">Tanggal Servis</p><p>:</p><p>${formatDate(current.created_at)}</p>
                        <p class="text-gray-700">Detail Servis</p><p>:</p><p>${current.keterangan || 'Menunggu pemeriksaan'}</p>
                        <p class="text-gray-700">Estimasi Biaya</p><p>:</p><p>Rp${formatRupiah(current.harga)}</p>
                        ${!isNaN(parseInt(current.prediksi)) ? (() => {
                            const createdAt = new Date(current.created_at);
                            createdAt.setDate(createdAt.getDate() + parseInt(current.prediksi));
                            const tanggalPrediksi = createdAt.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            });
                            return `
                                <p class="text-gray-700">Prediksi Kembali</p><p>:</p><p>${tanggalPrediksi}</p>
                            `;
                        })() : ''}
                    </div>
                `);

                const history = data.slice(1);
                let currentHistoryIndex = 0;

                function renderHistory(index) {
                    const item = history[index];
                    const historyHTML = `
                        <div class="grid grid-cols-[auto_min-content_auto] gap-x-3 gap-y-2 w-fit h-fit">
                            <p class="text-gray-700">Tanggal Servis</p><p>:</p><p>${formatDate(item.created_at)}</p>
                            <p class="text-gray-700">Detail Servis</p><p>:</p><p>${item.keterangan || 'Tanpa keterangan'}</p>
                            <p class="text-gray-700">Biaya</p><p>:</p><p>Rp${formatRupiah(item.harga)}</p>
                            ${!isNaN(parseInt(item.prediksi)) ? (() => {
                                const createdAt = new Date(item.created_at);
                                createdAt.setDate(createdAt.getDate() + parseInt(item.prediksi));
                                const tanggalPrediksi = createdAt.toLocaleDateString('id-ID', {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric'
                                });
                                return `
                                    <p class="text-gray-700">Prediksi Kembali</p><p>:</p><p>${tanggalPrediksi}</p>
                                `;
                            })() : ''}
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <button id="prev_btn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded" ${index === 0 ? 'disabled' : ''}><i class="fa-solid fa-chevron-left"></i></button>
                            <span class="text-sm text-gray-500">Entri ${index + 1} dari ${history.length}</span>
                            <button id="next_btn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded" ${index === history.length - 1 ? 'disabled' : ''}><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    `;
                    $('#history_content').html(historyHTML);
                }

                if (history.length) {
                    $('#history_content').addClass('hidden'); // tetap hidden sampai user klik tab
                    renderHistory(currentHistoryIndex);

                    $('#history_content').off('click').on('click', '#prev_btn', function () {
                        if (currentHistoryIndex > 0) {
                            currentHistoryIndex--;
                            renderHistory(currentHistoryIndex);
                        }
                    });

                    $('#history_content').on('click', '#next_btn', function () {
                        if (currentHistoryIndex < history.length - 1) {
                            currentHistoryIndex++;
                            renderHistory(currentHistoryIndex);
                        }
                    });
                } else {
                    $('#history_content').addClass('hidden').html(`<p class="text-gray-500">Tidak ada riwayat servis sebelumnya.</p>`);
                }
            },
            error: function (xhr) {
                let response = xhr.responseJSON;
                hideSubmitSpinner('submit-button', 'spinner');
                showProgressTrackerErrorDialog('dialog-error', response?.message || 'Terjadi kesalahan saat mengambil data!', 'Silahkan hubungi admin');
            }
        });
    });

    function formatDate(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    }

    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
});
