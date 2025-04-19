$(document).ready(function () {
    // Initialize map variables
    let map, marker;
    let selectedLat = -6.5891473;  // Default latitude
    let selectedLng = 106.806127;  // Default longitude
    let isMapLoading = true;       // Track loading state for map
    let isContactLoading = true;   // Track loading state for contact info

    const redIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    // Initialize Leaflet map
    function initMap() {
        // Add shimmer effects before map loads
        addLoadingEffects();

        // Create the map
        map = L.map('map').setView([selectedLat, selectedLng], 17);

        // Remove default zoom controls
        map.zoomControl.remove();

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Add initial marker
        marker = L.marker([selectedLat, selectedLng], {
            icon: redIcon
        }).addTo(map);

        // Fetch data from APIs
        fetchMapData();
        fetchContactData();
    }

    // Add shimmer loading effects
    function addLoadingEffects() {
        $('.contact-info-container').addClass('animate-pulse');
        $('.contact-info-container *').css('color', 'transparent');
    }

    // Remove shimmer loading effects when both data fetches complete
    function checkAndRemoveLoadingEffects() {
        if (!isMapLoading && !isContactLoading) {
            $('.contact-info-container').removeClass('animate-pulse');
            $('.contact-info-container *').css('color', '');
        }
    }

    // Fetch map coordinates from API
    function fetchMapData() {
        isMapLoading = true;

        $.ajax({
            url: '/api/maps',
            type: 'GET',
            contentType: 'application/json',
            success: function (response) {
                if (response && response.data) {
                    // Update coordinates
                    selectedLat = parseFloat(response.data.latitude);
                    selectedLng = parseFloat(response.data.longitude);

                    // Update map view with new coordinates
                    map.setView([selectedLat, selectedLng], 17);

                    // Remove old marker if it exists
                    if (marker) {
                        map.removeLayer(marker);
                    }

                    // Add new marker with updated location
                    marker = L.marker([selectedLat, selectedLng], {
                        icon: redIcon
                    }).addTo(map);

                    // Perform reverse geocoding to get address from coordinates
                    reverseGeocode(selectedLat, selectedLng);
                }

                isMapLoading = false;
                checkAndRemoveLoadingEffects();
            },
            error: function (xhr) {
                console.error('Error fetching map data:', xhr);

                isMapLoading = false;
                checkAndRemoveLoadingEffects();
            }
        });
    }

    // Reverse geocode to get address from coordinates
    function reverseGeocode(lat, lng) {
        // Using Nominatim OpenStreetMap service for reverse geocoding
        $.ajax({
            url: `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data) {
                    // Extract address components
                    const address = data.display_name || 'Jl. Malabar, RT.01/RW.08, Babakan, Kecamatan Bogor Tengah, 16129';
                    const city = data.address.city || data.address.town || data.address.village || 'Bogor';

                    // Update marker popup with address information
                    updateMarkerPopup(city + ', Indonesia', address);

                    // Update contact info in the DOM
                    $('.contact-address').text(address);
                }
            },
            error: function (xhr) {
                console.error('Error in reverse geocoding:', xhr);

                // Use default values if geocoding fails
                const defaultAddress = 'Jl. Malabar, RT.01/RW.08, Babakan, Kecamatan Bogor Tengah, 16129';
                const defaultCity = 'Bogor, Indonesia';

                updateMarkerPopup(defaultCity, defaultAddress);
                $('.contact-address').text(defaultAddress);
            }
        });
    }

    // Fetch contact information from API
    function fetchContactData() {
        isContactLoading = true;

        $.ajax({
            url: '/api/kontak',
            type: 'GET',
            contentType: 'application/json',
            success: function (response) {
                if (response && response.data) {
                    // Extract contact data
                    const email = response.data.email || 'glorepaircar@gmail.com';
                    const phone = response.data.nomor_telepon || response.data.nomor_whatsapp || '+62 81234567890';

                    // Update contact info in the DOM
                    $('.contact-email').text(email);
                    $('.contact-phone').text(phone);

                    // Update phone in marker popup if it exists
                    if (marker && marker.getPopup()) {
                        const popup = marker.getPopup();
                        const content = popup.getContent();
                        const updatedContent = content.replace(/\+62 \d+/, phone);
                        popup.setContent(updatedContent);
                    }
                }

                isContactLoading = false;
                checkAndRemoveLoadingEffects();
            },
            error: function (xhr) {
                console.error('Error fetching contact data:', xhr);

                isContactLoading = false;
                checkAndRemoveLoadingEffects();
            }
        });
    }

    // Update marker popup with contact information
    function updateMarkerPopup(city, address, phone = null) {
        if (!phone) {
            // If phone is not provided, use default or get from DOM if available
            phone = $('.contact-phone').text() || '+62 81234567890';
        }

        if (marker) {
            marker.bindPopup(`
                <b>${city}</b><br>
                <span style="display: flex; align-items: center; gap: 6px;">
                    <span class="text-end">${address}</span>
                    <img src="/icons/contact-map.svg" width="auto" height="36" alt="Alamat">
                </span><br>
                <span style="display: flex; align-items: center; gap: 6px;">
                    <span>${phone}</span>
                    <img src="/icons/contact-phone.svg" width="auto" height="36" alt="Telepon">
                </span><br>
                <a href="https://www.google.com/maps/dir/?api=1&destination=${selectedLat},${selectedLng}" target="_blank" class="text-red-500 underline">🔗 Rute ke Lokasi</a>
            `).openPopup();
        }
    }

    // Initialize map when document is ready
    initMap();
});