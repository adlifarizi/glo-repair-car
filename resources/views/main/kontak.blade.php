@extends('main.layouts.app')

@section('title', 'Layanan')

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
                    <!-- Map Section (Full Width) -->
                    <div class="absolute top-0 right-0 w-[85%] h-full">
                        <iframe class="w-full h-full rounded-lg shadow-lg"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.4628677988408!2d106.80353987338422!3d-6.589245164409667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5d2e602b501%3A0x25a12f0f97fac4ee!2sSekolah%20Vokasi%20Institut%20Pertanian%20Bogor!5e0!3m2!1sid!2sid!4v1739615211587!5m2!1sid!2sid"
                            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <!-- Contact Information Card (Absolute Positioning) -->
                    <div class="absolute top-1/2 -translate-y-1/2 left-0 w-80 z-10">
                        <div class="bg-red-700 text-white rounded-lg shadow-lg p-6">
                            <h3 class="text-xl font-bold mb-6">Informasi Kontak</h3>

                            <!-- Address Section -->
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
                                        <h3 class="font-semibold mb-1">Alamat Katering</h3>
                                        <p class="text-sm">Jl. Malabar, RT.01/RW.08, Babakan, Kecamatan Bogor Tengah, 16129
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Phone Section -->
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

                            <!-- Email Section -->
                            <div class="mb-6">
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

    </div>

@endsection