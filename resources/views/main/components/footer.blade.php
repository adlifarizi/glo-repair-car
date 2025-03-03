<footer class="relative w-full bg-footer-image bg-cover pt-8">
    <div class="flex items-start justify-center gap-x-8 px-8">
        <div class="flex flex-col flex-1 px-6">
            <p class="text-lg md:text-xl lg:text-2xl font-bold text-white mb-2">
                Glo Repair Car
            </p>
            <p class="text-sm font-normal text-white">
                Lorem ipsum dolor sit amet consectetur. In aliquam sodales eros id. Sed elit mattis vel viverra feugiat
                aliquam.
            </p>
        </div>

        <div class="flex flex-col flex-shrink px-6">
            <p class="text-lg md:text-xl lg:text-2xl font-bold text-white mb-2">
                Halaman
            </p>
            <div class="flex flex-col space-y-1">
                <a href="{{ url('/') }}"
                    class="text-white hover:text-red-500 text-base transition-colors duration-200">
                    Beranda
                </a>
                <a href="{{ url('layanan') }}"
                    class="text-white hover:text-red-500 text-base transition-colors duration-200">
                    Layanan
                </a>
                <a href="{{ url('ulasan') }}"
                    class="text-white hover:text-red-500 text-base transition-colors duration-200">
                    Ulasan
                </a>
                <a href="{{ url('kontak') }}"
                    class="text-white hover:text-red-500 text-base transition-colors duration-200">
                    Kontak
                </a>
            </div>
        </div>

        <div class="flex flex-col flex-1 px-6">
            <p class="text-lg md:text-xl lg:text-2xl font-bold text-white mb-2">
                Kontak
            </p>
            <div class="flex flex-col space-y-1">
                <!-- Phone Section -->
                <div class="">
                    <div class="flex items-start gap-3">
                        <div class="mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">+62 81234567890</p>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="">
                    <div class="flex items-start gap-3">
                        <div class="mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">Jl. Malabar, RT.01/RW.08, Babakan
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email Section -->
                <div class="">
                    <div class="flex items-start gap-3">
                        <div class="mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">glorepaircar@gmail.com</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container w-full mt-8 py-2 text-center text-white bg-red-700/90 text-sm">
        © {{ date('Y') }} Glo Repair Car
    </div>
</footer>