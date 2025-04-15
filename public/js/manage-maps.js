const defaultLat = -6.5891473;
const defaultLng = 106.806127;

let selectedLat = defaultLat;
let selectedLng = defaultLng;
let marker;

const redIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

$(document).ready(function () {
    // Initialize map
    const map = L.map('map').setView([defaultLat, defaultLng], 17);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    map.zoomControl.remove();
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    setTimeout(() => {
        const zoomInBtn = document.querySelector('.leaflet-control-zoom-in');
        const zoomOutBtn = document.querySelector('.leaflet-control-zoom-out');
        zoomInBtn.innerHTML = document.querySelector('#zoom-in-icon').innerHTML;
        zoomOutBtn.innerHTML = document.querySelector('#zoom-out-icon').innerHTML;
    }, 0);

    // Load map data when page loads
    loadMapData(map);

    // Handle map click events
    map.on('click', function (e) {
        const lat = e.latlng.lat.toFixed(7);
        const lng = e.latlng.lng.toFixed(7);
        selectedLat = lat;
        selectedLng = lng;

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lng], { icon: redIcon }).addTo(map)
            .bindPopup(`Latitude : ${lat}<br>Longitude : ${lng}`).openPopup();
    });

    // Handle save button click
    $('#submit-button').on('click', function () {
        saveMaps();
    });

    // Helper functions
    function loadMapData(map) {
        $.ajax({
            url: '/api/maps',
            type: 'GET',
            contentType: 'application/json',
            success: function (response) {
                if (response && response.data) {
                    selectedLat = parseFloat(response.data.latitude);
                    selectedLng = parseFloat(response.data.longitude);
                    map.setView([selectedLat, selectedLng], 17);

                    marker = L.marker([selectedLat, selectedLng], { icon: redIcon }).addTo(map)
                        .bindPopup(`Latitude : ${selectedLat}<br>Longitude : ${selectedLng}`).openPopup();
                }
            },
            error: function (xhr) {
                showDialog('dialog-error', 'Gagal mengambil data maps');
            }
        });
    }

    function saveMaps() {
        showSubmitSpinner('submit-button', 'spinner');

        $.ajax({
            url: '/api/maps',
            type: 'PUT',
            data: JSON.stringify({
                latitude: selectedLat,
                longitude: selectedLng
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                hideSubmitSpinner('submit-button', 'spinner');
                showDialog('dialog-success');
            },
            error: function (xhr) {
                hideSubmitSpinner('submit-button', 'spinner');
                let errorMessage = 'Gagal menyimpan lokasi.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                showDialog('dialog-error', null, errorMessage);
            }
        });
    }
});

// These functions are kept outside to maintain compatibility with existing code
function showDialog(id, message = null) {
    const dialog = document.getElementById(id);
    if (message) {
        dialog.querySelector('p').textContent = message;
    }
    dialog.classList.remove('hidden');
}

function showSpinner(buttonId, spinnerId) {
    const button = document.getElementById(buttonId);
    const spinner = document.getElementById(spinnerId);
    const buttonText = button.querySelector('#save-button-text');

    button.disabled = true;
    buttonText.classList.add('hidden');
    spinner.classList.remove('hidden');
}

function hideSpinner(buttonId, spinnerId) {
    const button = document.getElementById(buttonId);
    const spinner = document.getElementById(spinnerId);
    const buttonText = button.querySelector('#save-button-text');

    button.disabled = false;
    buttonText.classList.remove('hidden');
    spinner.classList.add('hidden');
}