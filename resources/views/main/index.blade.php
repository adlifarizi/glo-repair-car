@extends('main.layouts.app')

@section('title', 'Home')

@section('content')
    <div>
        <!-- Hero -->
        <section class="flex justify-center items-center bg-hero-image bg-cover h-72 md:h-96">
            <div class="flex flex-col gap-12 justify-center items-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white text-center">
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
                    <input type="text" placeholder="Masukkan Nomor Plat Anda"
                        class="px-2 text-left sm:text-center w-full text-base text-black placeholder-gray-500 focus:outline-none" />
                    <button class="px-2">
                        <i class='bx bx-search'></i>
                    </button>
                </div>

                <button
                    class="w-fit bg-red-500 hover:bg-red-700 text-white py-2 px-12 rounded transition duration-200 whitespace-nowrap select-none">
                    Lacak Progress
                </button>

                @include('main.components.progress-tracker')

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
                            Lorem ipsum dolor sit amet consectetur. Lorem amet metus elit rhoncus tincidunt. Quis tempus
                            molestie turpis in lorem cursus condimentum at.
                        </p>
                    </div>

                    <div class="flex flex-col items-end border border-gray-300 shadow-sm rounded-lg py-2 px-4 w-full">
                        <img src="{{ asset('icons/mekanik-ahli.svg') }}" class="w-10 h-10 md:w-16 md:h-16 mb-2">
                        <h5 class="text-base md:text-xl font-bold text-end text-black">
                            Mekanik Ahli
                        </h5>
                        <p class="text-base text-end text-gray-600">
                            Lorem ipsum dolor sit amet consectetur. Lorem amet metus elit rhoncus tincidunt. Quis tempus
                            molestie turpis in lorem cursus condimentum at.
                        </p>
                    </div>

                    <div class="flex flex-col items-end border border-gray-300 shadow-sm rounded-lg py-2 px-4 w-full">
                        <img src="{{ asset('icons/pemantauan-progress.svg') }}" class="w-10 h-10 md:w-16 md:h-16 mb-2">
                        <h5 class="text-base md:text-xl font-bold text-end text-black">
                            Pemantauan Progress
                        </h5>
                        <p class="text-base text-end text-gray-600">
                            Lorem ipsum dolor sit amet consectetur. Lorem amet metus elit rhoncus tincidunt. Quis tempus
                            molestie turpis in lorem cursus condimentum at.
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
                        <img src="{{ asset('images/ruang-tunggu.png') }}" class="object-cover rounded-t-lg">
                        <h5 class="text-base md:text-xl font-base text-end text-black py-4">
                            Ruang Tunggu
                        </h5>
                    </div>

                    <div class="flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                        <img src="{{ asset('images/wifi-gratis.png') }}" class="object-cover rounded-t-lg">
                        <h5 class="text-base md:text-xl font-base text-end text-black py-4">
                            Wifi Gratis
                        </h5>
                    </div>

                    <div class="flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                        <img src="{{ asset('images/garansi-servis.png') }}" class="object-cover rounded-t-lg">
                        <h5 class="text-base md:text-xl font-base text-end text-black py-4">
                            Garansi Servis
                        </h5>
                    </div>

                    <div class="flex flex-col items-center border border-gray-300 shadow-sm rounded-lg w-full">
                        <img src="{{ asset('images/garansi-servis.png') }}" class="object-cover rounded-t-lg">
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
                            <p class="text-base font-medium text-center text-red-700">Konsumen</p>
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
                            <p class="text-base font-medium text-center text-red-700">Konsumen</p>
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
                            <p class="text-base font-medium text-center text-red-700">Konsumen</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Maps -->
        <section class="flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Temukan Kami
                </h2>

                <iframe class="w-full h-72 md:h-96"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.4628677988408!2d106.80353987338422!3d-6.589245164409667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5d2e602b501%3A0x25a12f0f97fac4ee!2sSekolah%20Vokasi%20Institut%20Pertanian%20Bogor!5e0!3m2!1sid!2sid!4v1739615211587!5m2!1sid!2sid"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>

    </div>

    @push('scripts')
        <script src="{{ asset('js/progress-tracker.js') }}"></script>
    @endpush

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

    <script>
        var swiper = new Swiper(".testimoniSwiper", {
            slidesPerView: 1, // Default 1 untuk layar kecil
            spaceBetween: 10, // Jarak antar item
            loop: true, // Slide akan berulang
            autoplay: {
                delay: 3000, // Auto swipe tiap 3 detik
                disableOnInteraction: false, // Tetap autoplay meski user interaksi
            },
            breakpoints: {
                768: { slidesPerView: 2 }, // Medium screen: tampilkan 2 item
                1024: { slidesPerView: 3 }, // Large screen: tampilkan 3 item
            },
        });
    </script>


@endsection