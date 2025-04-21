$(document).ready(function () {
    // Initialize map variables
    let map, marker;
    let selectedLat = -6.5891473;  // Default latitude
    let selectedLng = 106.806127;  // Default longitude
    let isMapLoading = true;       // Track loading state for map
    let isContactLoading = true;   // Track loading state for contact info

    let fetchedCity = '';
    let fetchedAddress = '';
    let fetchedPhone = '';

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
    
        // Create the map WITHOUT initial view
        map = L.map('map', {
            zoomControl: false
        });
    
        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
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

            updateMarkerPopup(fetchedCity, fetchedAddress, fetchedPhone);
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
                    fetchedAddress = data.display_name || 'Belum ada alamat';
                    fetchedCity = data.address.city || data.address.town || data.address.village || 'Belum ada alamat';

                    $('.contact-address').text(fetchedAddress);
                }

                isMapLoading = false;
                checkAndRemoveLoadingEffects();
            },
            error: function (xhr) {
                console.error('Error in reverse geocoding:', xhr);

                // Use default values if geocoding fails
                const defaultAddress = 'Belum ada alamat';
                const defaultCity = 'Belum ada alamat';

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
                    const email = response.data.email || 'belum ada email';
                    fetchedPhone = response.data.nomor_telepon || response.data.nomor_whatsapp || 'belum ada nomor telepon';

                    $('.contact-email').text(email);
                    $('.contact-phone').text(fetchedPhone);
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
            phone = $('.contact-phone').text() || 'belum ada nomor telepon';
        }

        // Tambahkan +62 kalau belum ada
        if (phone && phone !== 'belum ada nomor telepon' && !phone.startsWith('+62')) {
            phone = '+62 ' + phone.replace(/^0/, ''); // Ubah 0812 jadi +62 812
        }

        const popupContent = `
            <b>${city}, Indonesia</b><br>
            <span style="display: flex; align-items: center; gap: 6px;">
                <span class="text-end">${address}</span>
                <img src="/icons/contact-map.svg" width="auto" height="36" alt="Alamat">
            </span><br>
            <span style="display: flex; align-items: center; gap: 6px;">
                <span>${phone}</span>
                <img src="/icons/contact-phone.svg" width="auto" height="36" alt="Telepon">
            </span><br>
            <a href="https://www.google.com/maps/dir/?api=1&destination=${selectedLat},${selectedLng}" target="_blank" class="text-red-500 underline">🔗 Rute ke Lokasi</a>
        `;

        if (marker) {
            if (marker.getPopup()) {
                marker.setPopupContent(popupContent).openPopup();
            } else {
                marker.bindPopup(popupContent).openPopup();
            }
        }
    }

    // Initialize map when document is ready
    initMap();
});