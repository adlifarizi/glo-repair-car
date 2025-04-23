$(document).ready(function () {
    /*
    |--------------------------------------------------------------------------
    | Stats
    |--------------------------------------------------------------------------
    */
    $.ajax({
        url: '/api/get-dashboard-data',
        type: 'GET',
        contentType: 'application/json',
        success: function (response) {
            if (response.success) {
                // Update data ke elemen HTML
                $('#jumlah-perbaikan').text(response.data.jumlah_servis_dalam_perbaikan);
                $('#jumlah-selesai').text(response.data.jumlah_transaksi_selesai);
                $('#rating-bengkel').text(response.data.rata_rata_rating);

                // Format number untuk mata uang
                $('#pemasukan-bulan-ini').text(formatRupiah(response.data.total_pemasukan_bulan_ini));
                $('#pengeluaran-bulan-ini').text(formatRupiah(response.data.total_pengeluaran_bulan_ini));
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });

    // Fungsi untuk format rupiah
    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }



    /*
    |--------------------------------------------------------------------------
    | Finance Chart
    |--------------------------------------------------------------------------
    */
    // Inisialisasi chart dengan data kosong
    const ctx = document.getElementById('financeChart').getContext('2d');
    let financeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                {
                    label: 'Pemasukan',
                    data: [],
                    radius: 4,
                    borderColor: 'rgba(137, 121, 255, 1)',
                    borderWidth: 2,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(255, 255, 255, 1)'
                },
                {
                    label: 'Pengeluaran',
                    data: [],
                    radius: 4,
                    borderColor: 'rgba(255, 146, 138, 1)',
                    borderWidth: 2,
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(255, 255, 255, 255)'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let value = context.raw.toLocaleString('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0
                            });
                            return `${context.dataset.label}: ${value}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function (value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Fungsi untuk mengelompokkan data berdasarkan bulan
    function groupByMonth(data, dateField) {
        const monthlyData = Array(12).fill(0);

        data.forEach(item => {
            const date = new Date(item[dateField]);
            const month = date.getMonth(); // 0-11
            monthlyData[month] += item.nominal;
        });

        return monthlyData;
    }

    // Mengambil data pemasukan dan pengeluaran
    $.when(
        $.ajax({
            url: '/api/pemasukan',
            type: 'GET',
            contentType: 'application/json',
        }),
        $.ajax({
            url: '/api/pengeluaran',
            type: 'GET',
            contentType: 'application/json',
        })
    ).done(function (pemasukanResponse, pengeluaranResponse) {
        // Proses data pemasukan
        const pemasukanData = pemasukanResponse[0].data || [];
        const monthlyPemasukan = groupByMonth(pemasukanData, 'tanggal_pemasukan');

        // Proses data pengeluaran
        const pengeluaranData = pengeluaranResponse[0].data || [];
        const monthlyPengeluaran = groupByMonth(pengeluaranData, 'tanggal_pengeluaran');

        // Update chart dengan data baru
        financeChart.data.datasets[0].data = monthlyPemasukan;
        financeChart.data.datasets[1].data = monthlyPengeluaran;
        financeChart.update();
    }).fail(function (xhr, status, error) {
        console.error('Error fetching data:', error);
    });



    /*
    |--------------------------------------------------------------------------
    | Entri Servis Chart
    |--------------------------------------------------------------------------
    */
    // Inisialisasi chart kosong
    const ctx2 = document.getElementById('serviceChart').getContext('2d');
    let serviceChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Dalam antrian', 'Dalam perbaikan', 'Selesai'],
            datasets: [{
                data: [0, 0, 0], // Data awal kosong
                backgroundColor: ['#FF928A', '#FFAE4C', '#8979FF'],
                borderWidth: 0,
            }]
        },
        options: {
            cutout: '60%',
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let value = context.raw;
                            let percentage = ((value / total) * 100).toFixed(2);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                },
                centerText: {
                    display: true,
                    text: ''
                }
            }
        },
        plugins: [{
            id: 'centerText',
            beforeDraw: (chart) => {
                if (chart.config.options.plugins.centerText.display !== false) {
                    const { width, height, ctx } = chart;
                    const text = chart.config.options.plugins.centerText.text;

                    ctx.restore();
                    ctx.font = 'bold 28px sans-serif';
                    ctx.fillStyle = '#111827';
                    ctx.textBaseline = 'middle';

                    const textX = (width - ctx.measureText(text).width) / 2;
                    const textY = height / 2;

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            }
        }]
    });

    // Fungsi untuk menghitung jumlah servis per status
    function countServicesByStatus(services) {
        const counts = {
            'Dalam antrian': 0,
            'Sedang diperbaiki': 0,
            'Selesai': 0
        };

        services.forEach(service => {
            if (service.status === 'Dalam antrian') {
                counts['Dalam antrian']++;
            } else if (service.status === 'Sedang diperbaiki') {
                counts['Sedang diperbaiki']++;
            } else if (service.status === 'Selesai') {
                counts['Selesai']++;
            }
        });

        return counts;
    }

    // Mengambil data entri servis dari API
    $.ajax({
        url: '/api/entri-servis',
        type: 'GET',
        contentType: 'application/json',
        success: function (response) {
            if (response && response.data) {
                const services = response.data;
                const counts = countServicesByStatus(services);
                const totalServis = services.length;

                // Update data chart
                serviceChart.data.datasets[0].data = [
                    counts['Dalam antrian'],
                    counts['Sedang diperbaiki'],
                    counts['Selesai']
                ];

                // Update teks di tengah chart
                serviceChart.options.plugins.centerText.text = totalServis.toString();

                // Update chart
                serviceChart.update();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching service data:', error);
        }
    });



    /*
    |--------------------------------------------------------------------------
    | 5 Ulasan Terbaru
    |--------------------------------------------------------------------------
    */
    // Mengambil data ulasan dari API
    $.ajax({
        url: '/api/feedback',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            const container = $('#ulasan-container');
            container.empty(); // Kosongkan container

            if (response.data && response.data.length > 0) {
                // Ambil 5 data terbaru
                const latestReviews = response.data.slice(0, 5);

                if (latestReviews.length === 0) {
                    container.append('<div class="text-gray-500">Belum ada ulasan</div>');
                    return;
                }

                latestReviews.forEach(feedback => {
                    container.append(`
                        <div class="text-gray-800 overflow-hidden group inline-flex items-center">
                            <i class="fa-solid fa-star mr-2"></i>
                            <p class="line-clamp-1">
                                Rating ${feedback.rating} bintang: Pelanggan ${feedback.nama_pelanggan} memberikan ulasan, "${feedback.feedback}"
                            </p>
                        </div>
                    `);
                });
            } else {
                container.append('<div class="text-gray-500">Belum ada ulasan</div>');
            }
        },
        error: function (xhr) {
            $('#ulasan-container').html(`
                <div class="text-gray-500">Gagal memuat ulasan</div>
            `);
            console.error('Error:', xhr.responseText);
        }
    });



    /*
    |--------------------------------------------------------------------------
    | 5 Chat Terbaru
    |--------------------------------------------------------------------------
    */
    $.ajax({
        url: '/api/chat-sessions',
        method: 'GET',
        success: function (response) {
            const container = $('#chat-container');
            container.empty(); // Kosongkan container

            if (response.data && response.data.length > 0) {
                // Ambil 5 data terbaru
                const latestChat = response.data.slice(0, 5);

                if (latestChat.length === 0) {
                    container.append('<div class="text-gray-500">Belum ada chat</div>');
                    return;
                }

                latestChat.forEach(session => {
                    container.append(`
                        <div class="inline-flex w-full items-center gap-2 text-gray-800 overflow-hidden group">
                            <div class="w-full flex items-center gap-2">
                                <i class="fa-regular fa-comment"></i>
                                <p class="line-clamp-1">
                                    Chat Session ID: ${session.id} - ${session.last_message}
                                </p>
                            </div>
                            <a href="/kelola-chat#chat-${session.id}" class="text-red-700 font-medium ml-4 cursor-pointer">Balas</a>
                        </div>
                    `);
                });
            } else {
                container.append('<div class="text-gray-500">Belum ada chat</div>');
            }
        },
        error: function (xhr) {
            $('#chat-container').html(`
                <div class="text-gray-500">Gagal memuat chat</div>
            `);
            console.error('Error:', xhr.responseText);
        }
    });
});