// public/js/progress-tracker.js
document.addEventListener('DOMContentLoaded', function () {
    const progressBar = document.getElementById('progress-bar');
    const carContainer = document.getElementById('car-container');
    const checkmark = document.getElementById('checkmark');
    let currentStatus = 'Dalam Antrian';

    const statusPositions = {
        'Dalam Antrian': 0,
        'Sedang Diperbaiki': 50,
        'Selesai Perbaikan': 100
    };

    function updateProgress(status) {
        const position = statusPositions[status];

        // Update progress bar
        progressBar.style.width = `${position}%`;

        // Move car
        carContainer.style.left = `${position}%`;

        // After car animation completes, lift the checkmark
        setTimeout(() => {
            checkmark.style.top = '-2rem'; // Lift checkmark up
        }, 1000);

        currentStatus = status;
    }

    // Attach to window so it can be called from blade
    window.updateProgress = updateProgress;

    // Example of how to handle the tracking button click
    const trackButton = document.querySelector('[data-track-progress]');
    if (trackButton) {
        trackButton.addEventListener('click', async function () {
            const platNumber = document.querySelector('[data-plat-input]').value;

            try {
                // Simulate API call - Replace this with your actual API endpoint
                // const response = await fetch(`/api/track-progress/${platNumber}`);
                // const data = await response.json();
                const status = "Sedang Diperbaiki"
                updateProgress(status);

                // For testing, cycle through statuses
                const statuses = Object.keys(statusPositions);
                const currentIndex = statuses.indexOf(currentStatus);
                const nextStatus = statuses[(currentIndex + 1) % statuses.length];
                updateProgress(nextStatus);
            } catch (error) {
                console.error('Error tracking progress:', error);
            }
        });
    }
});