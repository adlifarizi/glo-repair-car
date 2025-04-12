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

        <!-- Daftar Ulasan -->
        <section class="flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
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

@endsection