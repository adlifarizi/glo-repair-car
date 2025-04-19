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
                // Desktop: 2 slides per view in 2 rows (total 4 items per slide)
                1024: {
                    slidesPerView: 2,
                    slidesPerGroup: 4, // Move 4 items at once
                    grid: {
                        rows: 2,
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
        let shimmerCount = 4; // default desktop
        const screenWidth = window.innerWidth;

        if (screenWidth < 640) {
            shimmerCount = 1; // mobile
        } else if (screenWidth < 1024) {
            shimmerCount = 2; // tablet
        }

        const slideContainer = $('<div class="swiper-slide"></div>');
        const gridContainer = $('<div class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>');

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
                } else if (feedbackList.length > 0) {
                    // Round to the nearest multiple of 4 (minimum 4)
                    const remainder = feedbackList.length % 4;
                    if (remainder > 0) {
                        // If we have more than 4 items, limit to the nearest lower multiple of 4
                        if (feedbackList.length > 4) {
                            feedbackList = feedbackList.slice(0, feedbackList.length - remainder);
                        }
                        // If we have less than 4 items, keep all of them
                    }
                }

                // Clear existing slides
                $('#testimonial-wrapper').empty();

                // If no feedback or less than 4 items, add placeholders
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
                                <h4 class="font-medium text-gray-800 text-center">
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

    // Rating bintang
    const ratingInput = $('#rating');
    const starButtons = $('.star-button');

    function updateStars(value) {
        starButtons.each(function (index) {
            const star = $(this).find('.star');
            if (index < value) {
                star.html('&#9733;'); // Solid star
            } else {
                star.html('&#9734;'); // Outline star
            }
        });
    }

    updateStars(parseInt(ratingInput.val()));

    starButtons.on('click', function () {
        const value = parseInt($(this).data('value'));
        ratingInput.val(value);
        updateStars(value);
    });

    // Submit Form Feedback
    $('#feedback-form').on('submit', function (e) {
        e.preventDefault();

        // Tampilkan spinner
        showSubmitSpinner('submit-button', 'spinner');

        var form = $(this)[0];
        var formData = new FormData(form);

        $.ajax({
            url: '/api/feedback',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                hideSubmitSpinner('submit-button', 'spinner');
                showDialog('dialog-success', 'Feedback berhasil ditambahkan!');

                form.reset();
                ratingInput.val(4);
                updateStars(4);
            },
            error: function (xhr) {
                let response = xhr.responseJSON;
                hideSubmitSpinner('submit-button', 'spinner');
                showDialog('dialog-error', response?.message || 'Feedback gagal dikirim!');
            }
        });
    });
});