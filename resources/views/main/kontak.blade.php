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
                <div id="map" class="absolute top-0 right-0 w-full md:w-[85%] h-full rounded-lg z-0"></div>

                <!-- Contact Info -->
                <div class="hidden md:block absolute top-1/2 -translate-y-1/2 left-0 w-80 z-10 rounded-lg bg-red-600">
                    <div class="bg-red-700 text-white rounded-lg p-6 contact-info-container">
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
                                    <p class="text-sm contact-address w-full"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Instagram -->
                        <div class="mb-6">
                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 2C5.343 2 4 3.343 4 5v14c0 1.657 1.343 3 3 3h10c1.657 0 3-1.343 3-3V5c0-1.657-1.343-3-3-3H7zm5 5a5 5 0 110 10 5 5 0 010-10zm6.5-.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold mb-1">Instagram</h3>
                                    <p class="text-sm contact-instagram"></p>
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
                                    <p class="text-sm contact-phone"></p>
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
                                    <p class="text-sm contact-email"></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Contact Info (mobile) -->
            <div class="block md:hidden w-full mt-4">
                <div class="bg-red-700 text-white rounded-lg p-6 contact-info-container">
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
                                <p class="text-sm contact-address"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="mb-6">
                        <div class="flex items-start gap-3">
                            <div class="mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5z" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none" />
                                    <circle cx="17" cy="7" r="1" fill="currentColor" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-1">Instagram</h3>
                                <p class="text-sm contact-instagram"></p>
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
                                <p class="text-sm contact-phone"></p>
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
                                <p class="text-sm contact-email"></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>

<script src="{{ asset('js/main/contact.js') }}" defer></script>

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
@endsection