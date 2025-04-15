const ctx = document.getElementById('financeChart').getContext('2d');
const financeChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025'],
        datasets: [
            {
                label: 'Pemasukan',
                borderColor: '#FFB740',
                backgroundColor: 'rgba(255, 183, 64, 0.2)',
                data: [20, 30, 50, 70, 90, 120, 150, 170],
                fill: true,
            },
            {
                label: 'Pengeluaran',
                borderColor: '#EF6F6C',
                backgroundColor: 'rgba(239, 111, 108, 0.2)',
                data: [10, 20, 35, 50, 60, 80, 110, 130],
                fill: true,
            },
        ],
    },
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: 'Tahun' } },
            y: { title: { display: true, text: 'Rupiah' } },
        },
    },
});

// Entri Servis Chart
const serviceCtx = document.getElementById('serviceChart').getContext('2d');
const serviceChart = new Chart(serviceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Dalam antrian', 'Dalam perbaikan', 'Selesai'],
        datasets: [{
            label: 'Entri Servis',
            data: [12, 19, 15],
            backgroundColor: ['#FF928A', '#FFAE4C', '#8979FF'],
        }],
    },
    options: {
        responsive: true,
    },
});
