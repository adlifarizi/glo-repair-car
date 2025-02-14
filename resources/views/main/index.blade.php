@extends('main.layouts.app')

@section('title', 'Home')

@section('content')
<div>
    <!-- Hero -->
    <section class="flex justify-center items-center home-background h-72 md:h-96">
        <div class="flex flex-col gap-12 justify-center items-center">
            <h1 class="text-xl md:text-2xl lg:text-4xl font-bold text-white text-center">
                Perbaiki Mobil Anda<br>dengan Profesionalisme Terbaik
            </h1>

            <a href="/layanan"
                class="w-fit bg-red-500 hover:bg-red-700 text-white py-2 px-12 rounded transition duration-200 whitespace-nowrap select-none">
                Jelajahi
            </a>
        </div>
    </section>

    <!-- Cek Status Perbaikan -->
    <section class="flex justify-center items-center my-6 px-4 md:px-10 lg:px-16 xl:px-24">
        <div class="w-full md:w-9/12 flex flex-col justify-center items-center gap-y-7 bg-white border border-gray-300 shadow p-6 rounded">
            <h2 class="text-base sm:text-xl lg:text-3xl font-bold text-red-600 text-center">
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
        </div>
    </section>
</div>
@endsection
