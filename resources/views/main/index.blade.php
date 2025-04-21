@extends('main.layouts.app')

@section('title', 'Home')

@section('content')
    <div>
        <!-- Dialog -->
        @include('main.components.progress-tracker-error-dialog', ['id' => 'dialog-error', 'show' => false, 'message' => 'Data yang Anda Cari Tidak Ditemukan'])

        <!-- Hero -->
        <section class="flex justify-center items-center bg-hero-image bg-cover h-72 md:h-96">
            <div class="flex flex-col gap-12 justify-center items-center">
                <h1 class="text-xl md:text-4xl font-bold text-white text-center">
                    Perbaiki Mobil Anda<br>dengan Profesionalisme Terbaik
                </h1>

                <a href="/layanan"
                    class="w-fit bg-red-600 hover:bg-red-700 text-white py-2 px-12 rounded transition duration-200 whitespace-nowrap select-none">
                    Jelajahi
                </a>
            </div>
        </section>

        <!-- Cek Status Perbaikan -->
        <section class="flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div
                class="w-full sm:w-5/6 flex flex-col justify-center items-center gap-y-7 bg-white border border-gray-300 shadow p-6 rounded-lg">
                <h2 class="text-lg md:text-xl lg:text-3xl font-bold text-red-700 text-center">
                    Pantau Status Perbaikan Mobil Anda di Sini
                </h2>

                <!-- Input Plat -->
                <div class="flex items-center border border-gray-300 rounded py-2 w-full sm:w-9/12">
                    <input id="plat_no" type="text" placeholder="Masukkan Nomor Plat Anda"
                        class="px-2 text-left sm:text-center w-full text-base text-black placeholder-gray-500 focus:outline-none" />
                    <button id="search_button" class="px-2">
                        <i class='bx bx-search'></i>
                    </button>
                </div>

                <button id="submit-button"
                    class="w-48 md:w-64 bg-red-500 hover:bg-red-700 text-white py-2 px-12 rounded transition duration-200 whitespace-nowrap select-none">
                    <span id="submit-button-text">Lacak Progress</span>
                    <div id="spinner" class="hidden" role="status">
                        <i class="fa-solid fa-spinner animate-spin"></i>
                    </div>
                </button>

                <div id="progress_tracker" class="w-full hidden">
                    @include('main.components.progress-tracker')
                </div>

            </div>
        </section>

        <!-- Layanan Kami -->
        <section class="flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h4 class="text-sm md:text-base font-base text-red-400 text-center">
                    Yang Kami Tawarkan
                </h4>
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Layanan Kami
                </h2>

                <!-- Daftar Layanan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="flex flex-col items-end border border-gray-300 shadow-sm rounded-lg py-6 px-4 w-full">
                        <img src="{{ asset('icons/perbaikan-kendaraan.svg') }}" class="w-10 h-10 md:w-16 md:h-16 mb-2">
                        <h5 class="text-base md:text-xl font-bold text-end text-black">
                            Perbaikan Kendaraan
                        </h5>
                        <p class="text-base text-end text-gray-600">
                            Kami menangani berbagai jenis perbaikan mulai dari mesin, rem, suspensi hingga kelistrikan.
                            Kendaraan Anda akan ditangani oleh mekanik berpengalaman dengan alat modern.
                        </p>
                    </div>

                    <div class="flex flex-col items-end border border-gray-300 shadow-sm rounded-lg py-2 px-4 w-full">
                        <img src="{{ asset('icons/mekanik-ahli.svg') }}" class="w-10 h-10 md:w-16 md:h-16 mb-2">
                        <h5 class="text-base md:text-xl font-bold text-end text-black">
                            Mekanik Ahli
                        </h5>
                        <p class="text-base text-end text-gray-600">
                            Tim kami terdiri dari mekanik bersertifikasi yang siap memberikan solusi terbaik untuk segala
                            jenis kerusakan kendaraan Anda.
                        </p>
                    </div>

                    <div class="flex flex-col items-end border border-gray-300 shadow-sm rounded-lg py-2 px-4 w-full">
                        <img src="{{ asset('icons/pemantauan-progress.svg') }}" class="w-10 h-10 md:w-16 md:h-16 mb-2">
                        <h5 class="text-base md:text-xl font-bold text-end text-black">
                            Pemantauan Progress
                        </h5>
                        <p class="text-base text-end text-gray-600">
                            Pantau perkembangan servis kendaraan Anda melalui website kami.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Layanan Penunjang -->
        <section class="flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h4 class="text-sm md:text-base font-base text-red-400 text-center">
                    Layanan Tambahan Kami
                </h4>
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Layanan Penunjang
                </h2>

                <!-- Daftar Layanan -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                        <img src="{{ asset('images/layanan-penunjang-ruang-tunggu.png') }}" class="object-cover rounded-t-lg">
                        <h5 class="text-base md:text-xl font-base text-end text-black py-4">
                            Ruang Tunggu
                        </h5>
                    </div>

                    <div class="flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                        <img src="{{ asset('images/layanan-penunjang-wifi-gratis.png') }}" class="object-cover rounded-t-lg">
                        <h5 class="text-base md:text-xl font-base text-end text-black py-4">
                            Wifi Gratis
                        </h5>
                    </div>

                    <div class="flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                        <img src="{{ asset('images/layanan-penunjang-garansi-servis.png') }}" class="object-cover rounded-t-lg">
                        <h5 class="text-base md:text-xl font-base text-end text-black py-4">
                            Garansi Servis
                        </h5>
                    </div>

                    <div class="flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                        <img src="{{ asset('images/layanan-penunjang-sparepart.png') }}" class="object-cover rounded-t-lg">
                        <h5 class="text-base md:text-xl font-base text-end text-black py-4">
                            Sparepart Original
                        </h5>
                    </div>

                </div>
            </div>
        </section>

        <!-- Counter -->
        <section id="counter-section"
            class="relative flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="absolute inset-0">
                <img src="{{ asset('images/counter-bg.png') }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-800/50"></div>
            </div>

            <div class="relative container mx-auto px-4 py-6">
                <div class="grid grid-cols-3 gap-4 md:gap-8">
                    <!-- Counter Item 1 -->
                    <div class="flex flex-col items-center text-center">
                        <img src="{{ asset('icons/user-group.svg') }}" class="w-12 h-12 md:w-24 md:h-24 mb-2">
                        <div class="text-xl md:text-2xl text-red-400 font-medium counter" data-target="200">0+</div>
                        <div class="text-red-400">Expert Technicians</div>
                    </div>

                    <!-- Counter Item 2 -->
                    <div class="flex flex-col items-center text-center">
                        <img src="{{ asset('icons/user-group.svg') }}" class="w-12 h-12 md:w-24 md:h-24 mb-2">
                        <div class="text-xl md:text-2xl text-red-400 font-medium counter" data-target="150">0+</div>
                        <div class="text-red-400">Happy Clients</div>
                    </div>

                    <!-- Counter Item 3 -->
                    <div class="flex flex-col items-center text-center">
                        <img src="{{ asset('icons/user-group.svg') }}" class="w-12 h-12 md:w-24 md:h-24 mb-2">
                        <div class="text-xl md:text-2xl text-red-400 font-medium counter" data-target="300">0+</div>
                        <div class="text-red-400">Completed Projects</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimoni -->
        <section class="flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Apa yang Mereka Katakan?
                </h2>

                <!-- Swiper Container -->
                <div class="swiper testimonialSwiper w-full relative">
                    <div class="swiper-wrapper" id="testimonial-wrapper">
                        <!-- Add at least one placeholder slide -->
                        <div class="swiper-slide">Loading...</div>
                    </div>

                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>

                <!-- Swiper Container -->
            </div>
        </section>


        <!-- Maps -->
        <section class="flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Temukan Kami
                </h2>

                <!-- Leaflet Map -->
                <div id="map" class="w-full h-72 md:h-96"></div>
            </div>
        </section>

    </div>

    <script src="{{ asset('js/main/progress-tracker.js') }}" defer></script>
    <script src="{{ asset('js/main/home.js') }}" defer></script>

    <style>
        .testimonialSwiper .swiper-pagination {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
        }

        .testimonialSwiper .swiper-slide {
            margin-bottom: 20px;
        }

        /* Bullet aktif warna merah */
        .swiper-pagination-bullet-active {
            background-color: #ef4444; /* red-500 */
            opacity: 1;
        }

        /* Custom style for fixed height text with line clamp */
        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 6rem; /* Adjust this value to match 4 lines of your text */
            word-break: break-word; /* Memecah kata yang sangat panjang */
            overflow-wrap: break-word; /* Alternatif untuk browser yang lebih baru */
            word-wrap: break-word; /* Untuk kompatibilitas browser */
        }
    </style>

    <style>
        .leaflet-popup-content {
            display: flex !important;
            flex-direction: column !important;
            justify-content: end !important;
            align-items: end !important;
        }

        .leaflet-popup-content b {
            color: #B30000 !important;
            font-size: large !important;
            font-weight: 600 !important;
        }

        .leaflet-control-zoom {
           display: hidden !important
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const counters = document.querySelectorAll(".counter");
            let hasAnimated = false;

            function startCounterAnimation() {
                counters.forEach(counter => {
                    let target = +counter.getAttribute("data-target");
                    let count = 0;
                    let increment = Math.ceil(target / 100); // Perubahan angka per iterasi
                    let speed = 10; // Kecepatan animasi (lebih kecil lebih cepat)

                    let updateCounter = () => {
                        count += increment;
                        if (count < target) {
                            counter.innerText = count + "+";
                            setTimeout(updateCounter, speed);
                        } else {
                            counter.innerText = target + "+";
                        }
                    };
                    updateCounter();
                });
            }

            // Menggunakan Intersection Observer untuk memulai animasi saat section terlihat
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !hasAnimated) {
                        hasAnimated = true;
                        startCounterAnimation();
                    }
                });
            }, { threshold: 0.5 }); // Trigger saat 50% dari section terlihat

            observer.observe(document.querySelector("#counter-section"));
        });
    </script>

@endsection