@extends('main.layouts.app')

@section('title', 'Kontak')

@section('content')
    <div>
        <!-- Hero -->
        <section class="flex justify-center items-center bg-hero-image bg-cover h-72 md:h-96">
            <div class="flex flex-col justify-center items-center">
                <p class="text-base text-white text-center">
                    Beranda | <b>Kontak</b>
                </p>
                <h1 class="text-3xl md:text-4xl font-bold text-white text-center">
                    Kontak Kami
                </h1>
            </div>
        </section>

        <!-- Maps -->
        <section class="flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="w-full sm:w-5/6 flex flex-col justify-center items-center">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 text-center mb-8">
                    Temukan Kami
                </h2>

                <div class="relative w-full h-[500px]">
                    <!-- Leaflet Map -->
                    <div id="map" class="absolute top-0 right-0 w-[85%] h-full rounded-lg z-0"></div>

                    <!-- Contact Info -->
                    <div class="absolute top-1/2 -translate-y-1/2 left-0 w-80 z-10">
                        <div class="bg-red-700 text-white rounded-lg p-6">
                            <h3 class="text-xl font-bold">Informasi Kontak</h3>

                            <div class="w-full h-[1px] bg-white my-4"></div>

                            <!-- Alamat -->
                            <div class="mb-6">
                                <div class="flex items-start gap-3">
                                    <div class="mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold mb-1">Alamat Bengkel</h3>
                                        <p class="text-sm">Jl. Malabar, RT.01/RW.08, Babakan, Kecamatan Bogor Tengah, 16129
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- HP -->
                            <div class="mb-6">
                                <div class="flex items-start gap-3">
                                    <div class="mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold mb-1">Nomor Handphone</h3>
                                        <p class="text-sm">+62 81234567890</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <div class="flex items-start gap-3">
                                    <div class="mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold mb-1">Email</h3>
                                        <p class="text-sm">glorepaircar@gmail.com</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Hidden icons for JS to access -->
        <div id="custom-icons" class="hidden">
            <div id="zoom-in-icon">
                <x-admin.icon.zoom-in />
            </div>
            <div id="zoom-out-icon">
                <x-admin.icon.zoom-out />
            </div>
        </div>
    </div>

    <style>
        .leaflet-popup-content-wrapper {
            font-size: 14px;
            color: #8E1616 !important;
        }
        
        .leaflet-control-zoom {
            position: absolute !important;
            right: 10px !important;
            bottom: 10px !important;
            display: flex;
            flex-direction: column;
            border: none !important;
            box-shadow: none !important;
        }

        .leaflet-control-zoom-in,
        .leaflet-control-zoom-out {
            border: none !important;
            width: 40px;
            height: 40px;
            text-align: center !important;
            padding: 0;
            font-size: 18px;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .leaflet-control-zoom-in {
            background-color: #8E1616 !important;
            color: white !important;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }

        .leaflet-control-zoom-out {
            background-color: white !important;
            color: black !important;
            border-bottom-left-radius: 10px !important;
            border-bottom-right-radius: 10px !important;
        }
    </style>

    <!-- Leaflet Map Script -->
    <script>
        const latitude = {{ $latitude }};
        const longitude = {{ $longitude }};

        const map = L.map('map').setView([latitude, longitude], 17);

        // Setelah inisialisasi map
        map.zoomControl.remove(); // Hapus default zoom

        // Custom control
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // Ganti isi tombol dengan ikon
        setTimeout(() => {
            const zoomInBtn = document.querySelector('.leaflet-control-zoom-in');
            const zoomOutBtn = document.querySelector('.leaflet-control-zoom-out');

            const zoomInIconHTML = document.querySelector('#zoom-in-icon').innerHTML;
            const zoomOutIconHTML = document.querySelector('#zoom-out-icon').innerHTML;

            zoomInBtn.innerHTML = zoomInIconHTML;
            zoomOutBtn.innerHTML = zoomOutIconHTML;
        }, 0);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([latitude, longitude]).addTo(map);

        marker.bindPopup(`
                    <b>Bogor, Indonesia</b><br>
                    Jl. Malabar, RT.01/RW.08, Babakan, 16129<br>
                    0812345678910<br>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${latitude},${longitude}" target="_blank" class="text-red-500 underline">🔗 Rute ke Lokasi</a>
                `).openPopup();
    </script>
@endsection