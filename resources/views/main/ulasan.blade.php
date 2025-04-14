@extends('main.layouts.app')

@section('title', 'Ulasan')

@section('content')
    <div>
        <!-- Hero -->
        <section class="flex justify-center items-center bg-hero-image bg-cover h-72 md:h-96">
            <div class="flex flex-col justify-center items-center">
                <p class="text-base text-white text-center">
                    Beranda | <b>Ulasan</b>
                </p>
                <h1 class="text-3xl md:text-4xl font-bold text-white text-center">
                    Ulasan
                </h1>
            </div>
        </section>

        <!-- Daftar Ulasan dan Form -->
        <section class="flex flex-col gap-16 justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Apa yang Mereka Katakan?
                </h2>

                <!-- Swiper Container -->
                <div class="swiper testimoniSwiper w-full">
                    <div class="swiper-wrapper">
                        <!-- Item Testimoni -->
                        <div
                            class="swiper-slide px-4 py-6 flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                            <div class="flex items-center">
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                            </div>
                            <p class="text-base font-base text-center text-black py-4">
                                Lorem ipsum dolor sit amet consectetur. In aliquam sodales eros id. Sed elit mattis vel
                                viverra feugiat aliquam.
                            </p>
                            <p class="text-base font-bold text-center text-black">Cynthia Octavania</p>
                        </div>

                        <div
                            class="swiper-slide px-4 py-6 flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                            <div class="flex items-center">
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                            </div>
                            <p class="text-base font-base text-center text-black py-4">
                                Lorem ipsum dolor sit amet consectetur. In aliquam sodales eros id. Sed elit mattis vel
                                viverra feugiat aliquam.
                            </p>
                            <p class="text-base font-bold text-center text-black">John Doe</p>
                        </div>

                        <div
                            class="swiper-slide px-4 py-6 flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                            <div class="flex items-center">
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                            </div>
                            <p class="text-base font-base text-center text-black py-4">
                                Lorem ipsum dolor sit amet consectetur. In aliquam sodales eros id. Sed elit mattis vel
                                viverra feugiat aliquam.
                            </p>
                            <p class="text-base font-bold text-center text-black">Jane Smith</p>
                        </div>

                        <div
                            class="swiper-slide px-4 py-6 flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                            <div class="flex items-center">
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                                <i class='bx bxs-star text-red-400'></i>
                            </div>
                            <p class="text-base font-base text-center text-black py-4">
                                Lorem ipsum dolor sit amet consectetur. In aliquam sodales eros id. Sed elit mattis vel
                                viverra feugiat aliquam.
                            </p>
                            <p class="text-base font-bold text-center text-black">Jane Smith</p>
                        </div>

                    </div>

                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>

            </div>

            <!-- Form Ulasan -->
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Berikan Feedback Anda terhadap Kinerja Kami
                </h2>

                <form class="w-full">
                    @csrf
                    <!-- Rating -->
                    <div class="flex justify-center mb-4 space-x-2" id="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" class="text-5xl md:text-6xl focus:outline-none star-button" data-value="{{ $i }}">
                                <span class="star text-red-500" data-index="{{ $i }}">&#9733;</span> <!-- Default solid -->
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" value="4"> <!-- default value -->

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text" name="nama" placeholder="Nama" class="border border-gray-300 rounded p-2 w-full"
                            required>
                        <input type="text" name="plat_nomor" placeholder="Nomor Plat Kendaraan yang Pernah Diservis"
                            class="border border-gray-300 rounded p-2 w-full" required>
                    </div>

                    <textarea name="ulasan" rows="5" placeholder="Ulasan"
                        class="w-full border border-gray-300 rounded p-2 mb-4" required></textarea>

                    <button type="submit"
                        class="bg-red-500 text-white py-2 px-6 md:px-12 rounded hover:bg-red-600 block mx-auto">
                        Kirim Ulasan
                    </button>
                </form>

            </div>
        </section>

    </div>

    <script>
        var swiper = new Swiper(".testimoniSwiper", {
            slidesPerView: 2, // 2 kolom dalam satu baris
            grid: {
                rows: 2, // 2 baris dalam satu slide
                fill: "row" // Mengisi item dari atas ke bawah dalam satu baris sebelum pindah ke kolom berikutnya
            },
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1, // Mobile: 1 item per slide
                    grid: {
                        rows: 1
                    }
                },
                320: {
                    slidesPerView: 1, // Mobile: 1 item per slide
                    grid: {
                        rows: 1
                    }
                },
                768: {
                    slidesPerView: 2, // Tablet: 2 item per slide
                    grid: {
                        rows: 2
                    }
                }
            }
        });

    </script>

    <script>
        const ratingInput = document.getElementById('rating');
        const starButtons = document.querySelectorAll('.star-button');

        function updateStars(value) {
            starButtons.forEach((button, index) => {
                const star = button.querySelector('.star');
                if (index < value) {
                    star.innerHTML = '&#9733;'; // Solid star
                } else {
                    star.innerHTML = '&#9734;'; // Outline star
                }
            });
        }

        // Inisialisasi tampilan awal (misal value 4)
        updateStars(parseInt(ratingInput.value));

        starButtons.forEach(button => {
            button.addEventListener('click', function () {
                const value = parseInt(this.getAttribute('data-value'));
                ratingInput.value = value;
                updateStars(value);
            });
        });
    </script>

@endsection