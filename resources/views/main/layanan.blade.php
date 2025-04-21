@extends('main.layouts.app')

@section('title', 'Layanan')

@section('content')
    <div>
        <!-- Hero -->
        <section class="flex justify-center items-center bg-hero-image bg-cover h-72 md:h-96">
            <div class="flex flex-col justify-center items-center">
                <p class="text-base text-white text-center">
                    Beranda | <b>Layanan</b>
                </p>
                <h1 class="text-3xl md:text-4xl font-bold text-white text-center">
                    Layanan Kami
                </h1>
            </div>
        </section>

        <!-- Sekilas -->
        <section class="flex justify-center items-center my-10 md:my-14 px-4 md:px-10 lg:px-16 xl:px-24">
            <div class="w-full sm:w-5/6 flex flex-col md:flex-row gap-8 justify-end items-start">
                <!-- Info -->
                <div class="flex flex-1 flex-col items-end">
                    <p class="text-red-400 text-end">GLO REPAIR CAR</p>
                    <p class="text-3xl md:text-4xl text-red-700 text-end font-bold mb-5">Berkualitas dan<br>Profesional</p>
                    <p class="text-base text-gray-600 text-end pr-2 border-r-2 border-red-500">Glo Repair Car hadir sebagai
                        solusi perawatan dan perbaikan kendaraan Anda dengan standar terbaik. Kami mengutamakan kualitas
                        layanan, keahlian mekanik, serta kenyamanan pelanggan.</p>
                    <ul class="list-none self-start space-y-3 text-gray-600 text-lg font-medium my-4">
                        <li class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-[#D9D9D9]">
                                <img src="{{ asset('icons/layanan-ruang-tunggu.svg') }}" class="w-12 h-12">
                            </div>
                            Ruang Tunggu
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-[#D9D9D9]">
                                <img src="{{ asset('icons/layanan-garansi-servis.svg') }}" class="w-12 h-12">
                            </div>
                            Garansi Servis
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-[#D9D9D9]">
                                <img src="{{ asset('icons/layanan-sparepart.svg') }}" class="w-12 h-12">
                            </div>
                            Sparepart Original
                        </li>
                    </ul>
                </div>

                <!-- Image -->
                <div class="relative w-full md:w-1/2 h-auto">
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-4/5 bg-red-500 rounded-lg"></div>
                    <!-- Gambar -->
                    <img src="{{ asset('images/sekilas-layanan.png') }}"
                        class="w-full h-full object-cover rounded-lg relative">
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-3 gap-y-8">
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

                    <div class="flex flex-col items-end border border-gray-300 shadow-sm rounded-lg py-6 px-4 w-full">
                        <img src="{{ asset('icons/perbaikan-kendaraan.svg') }}" class="w-10 h-10 md:w-16 md:h-16 mb-2">
                        <h5 class="text-base md:text-xl font-bold text-end text-black">
                            Cuci Mobil Detailing
                        </h5>
                        <p class="text-base text-end text-gray-600">
                            Layanan cuci menyeluruh termasuk interior, eksterior, dan poles body mobil agar kendaraan Anda
                            tampil seperti baru.
                        </p>
                    </div>

                    <div class="flex flex-col items-end border border-gray-300 shadow-sm rounded-lg py-2 px-4 w-full">
                        <img src="{{ asset('icons/mekanik-ahli.svg') }}" class="w-10 h-10 md:w-16 md:h-16 mb-2">
                        <h5 class="text-base md:text-xl font-bold text-end text-black">
                            Servis Berkala
                        </h5>
                        <p class="text-base text-end text-gray-600">
                            Pastikan mobil Anda tetap prima dengan layanan servis rutin seperti ganti oli, pengecekan rem,
                            dan pemeriksaan sistem pendingin.
                        </p>
                    </div>

                    <div class="flex flex-col items-end border border-gray-300 shadow-sm rounded-lg py-2 px-4 w-full">
                        <img src="{{ asset('icons/pemantauan-progress.svg') }}" class="w-10 h-10 md:w-16 md:h-16 mb-2">
                        <h5 class="text-base md:text-xl font-bold text-end text-black">
                            Konsultasi Kendaraan
                        </h5>
                        <p class="text-base text-end text-gray-600">
                            Bingung dengan masalah mobil Anda? Konsultasikan gratis dengan mekanik kami untuk solusi terbaik
                            sebelum servis dilakukan.
                        </p>
                    </div>

                </div>
            </div>
        </section>

    </div>

@endsection