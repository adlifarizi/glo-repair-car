$(document).ready(function () {
    // Initialize Swiper (will be populated after API call)
    let testimonialSwiper;

    function initSwiper() {
        testimonialSwiper = new Swiper('.testimonialSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                // Mobile: 1 slide per view
                0: {
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    grid: {
                        rows: 1,
                        fill: 'row'
                    },
                },
                // Tablet: 2 slides per view in 1 row
                640: {
                    slidesPerView: 2,
                    slidesPerGroup: 2,
                    grid: {
                        rows: 1,
                        fill: 'row'
                    },
                },
                // Desktop: 3 slides per view in 1 row
                1024: {
                    slidesPerView: 3,
                    slidesPerGroup: 3,
                    grid: {
                        rows: 1,
                        fill: 'row'
                    },
                }
            }
        });
    }

    function createPlaceholders() {
        const swiperWrapper = $('#testimonial-wrapper');
        swiperWrapper.empty();

        // Tentukan jumlah shimmer berdasarkan lebar layar
        let shimmerCount = 3; // default desktop
        const screenWidth = window.innerWidth;

        if (screenWidth < 640) {
            shimmerCount = 1; // mobile
        } else if (screenWidth < 1024) {
            shimmerCount = 2; // tablet
        }

        const slideContainer = $('<div class="swiper-slide"></div>');
        const gridContainer = $('<div class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>');

        // Create 4 shimmer placeholders
        for (let i = 0; i < shimmerCount; i++) {
            const placeholderSlide = `
                <div class="swiper-slide px-4 py-6 flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                    <div class="flex items-center space-x-1">
                        <i class='bx bxs-star text-gray-200 animate-pulse'></i>
                        <i class='bx bxs-star text-gray-200 animate-pulse'></i>
                        <i class='bx bxs-star text-gray-200 animate-pulse'></i>
                        <i class='bx bxs-star text-gray-200 animate-pulse'></i>
                        <i class='bx bxs-star text-gray-200 animate-pulse'></i>
                    </div>
                    <div class="w-full line-clamp-4 bg-gray-200 rounded my-4 animate-pulse"></div>
                    <div class="w-full h-5 bg-gray-200 rounded animate-pulse"></div>
                </div>
            `;
            gridContainer.append(placeholderSlide);
        }

        slideContainer.append(gridContainer);

        // Append the slide to the swiper wrapper
        swiperWrapper.append(slideContainer);
    }

    // Create initial placeholders
    createPlaceholders();

    function getFeedback() {
        // Get feedback data from API and display in Swiper
        $.ajax({
            url: '/api/feedback-show',
            type: 'GET',
            success: function (response) {
                let feedbackList = response.data || [];

                // Limit feedback to multiples of 4, max 16
                if (feedbackList.length > 16) {
                    feedbackList = feedbackList.slice(0, 16);
                }

                // Clear existing slides
                $('#testimonial-wrapper').empty();

                // If no feedback, add placeholders
                if (feedbackList.length === 0) {
                    // Reset Swiper instance agar tidak terpakai grid
                    if (testimonialSwiper) {
                        testimonialSwiper.destroy(true, true);
                        testimonialSwiper = null;
                    }

                    const placeholderSlide = `
                        <div class="swiper-slide px-4 py-6 flex flex-col items-center justify-center">
                            <p class="text-base font-medium text-center text-gray-500">
                                Belum ada ulasan. Jadilah yang pertama memberikan ulasan!
                            </p>
                        </div>
                    `;

                    $('#testimonial-wrapper').append(placeholderSlide);
                    return;
                }

                // Add slides from filtered feedback data
                feedbackList.forEach(function (item) {
                    const stars = generateStars(item.rating);
                    const customer_name = item.nama_pelanggan;
                    const feedback = item.feedback;

                    // Create slide with design matching the image
                    const slide = `
                        <div class="swiper-slide px-4 md:px-8 py-6 flex flex-col items-center justify-center border border-gray-300 bg-white shadow-sm rounded-lg">
                            <div class="h-full">
                                <div class="flex items-center justify-center text-red-500 mb-3">
                                    ${stars}
                                </div>
                                <p class="text-gray-600 text-center mb-4 line-clamp-4">
                                    ${feedback}
                                </p>
                                <h4 class="font-semibold text-gray-800 text-center">
                                    ${customer_name}
                                </h4>
                            </div>
                        </div>
                    `;

                    $('#testimonial-wrapper').append(slide);
                });

                // Initialize or update swiper
                if (testimonialSwiper) {
                    testimonialSwiper.update();
                } else {
                    initSwiper();
                }
            },
            error: function () {
                console.error('Gagal mengambil data feedback dari API');
            }
        });
    }

    // Function to generate star ratings
    function generateStars(rating) {
        let starsHTML = '';
        for (let i = 1; i <= 5; i++) {
            starsHTML += `<i class='bx ${i <= rating ? 'bxs-star' : 'bx-star'} text-red-500'></i>`;
        }
        return starsHTML;
    }

    // Call the function to get feedback and initialize slider
    getFeedback();


    /*
    |--------------------------------------------------------------------------
    | Map Scripts
    |--------------------------------------------------------------------------
    */
    // Initialize map variables
    let map, marker;
    let selectedLat = -6.5891473;  // Default latitude
    let selectedLng = 106.806127;  // Default longitude

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

    // Fetch map coordinates from API
    function fetchMapData() {
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

                updateMarkerPopup(fetchedCity, fetchedAddress, fetchedPhone);
            },
            error: function (xhr) {
                console.error('Error fetching map data:', xhr);

                updateMarkerPopup(fetchedCity, fetchedAddress, fetchedPhone);
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

                updateMarkerPopup(fetchedCity, fetchedAddress, fetchedPhone);
            },
            error: function (xhr) {
                console.error('Error in reverse geocoding:', xhr);

                // Use default values if geocoding fails
                const defaultAddress = 'Belum ada alamat';
                const defaultCity = 'Belum ada alamat';

                updateMarkerPopup(fetchedCity, fetchedAddress, fetchedPhone);
            }
        });
    }

    // Fetch contact information from API
    function fetchContactData() {
        $.ajax({
            url: '/api/kontak',
            type: 'GET',
            contentType: 'application/json',
            success: function (response) {
                if (response && response.data) {
                    // Extract contact data
                    const email = response.data.email || 'belum ada email';
                    fetchedPhone = response.data.nomor_telepon || response.data.nomor_whatsapp || 'belum ada nomor telepon';
                }

                updateMarkerPopup(fetchedCity, fetchedAddress, fetchedPhone);
            },
            error: function (xhr) {
                console.error('Error fetching contact data:', xhr);
                updateMarkerPopup(fetchedCity, fetchedAddress, fetchedPhone);
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