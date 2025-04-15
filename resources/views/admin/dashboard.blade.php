@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Page title -->
            <h1 class="font-semibold text-2xl my-4">Dashboard</h1>

            <!-- Stats -->
            <div class="overflow-x-auto whitespace-nowrap">
                <div class="flex flex-row gap-4 my-4 w-full">
                    <!-- Dalam Perbaikan -->
                    <div class="bg-white w-fit rounded-lg px-4 py-2">
                        <div class="flex gap-3">
                            <div
                                class="p-1 flex items-center justify-center w-12 h-12 text-red-300 text-center rounded-lg bg-red-700">
                                <!-- <i class="fa-solid fa-users"></i> -->
                            </div>
                            <div class="text-dark">
                                <p class="text-lg font-medium">11 Mobil</p>
                                <p class="text-sm text-gray-500">Dalam perbaikan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi Terselesaikan -->
                    <div class="bg-white w-fit rounded-lg px-4 py-2">
                        <div class="flex gap-3">
                            <div
                                class="p-1 flex items-center justify-center w-12 h-12 text-red-300 text-center rounded-lg bg-red-700">
                                <!-- <i class="fa-solid fa-users"></i> -->
                            </div>
                            <div class="text-dark">
                                <p class="text-lg font-medium">128 Transaksi</p>
                                <p class="text-sm text-gray-500">Terselesaikan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rating Bengkel -->
                    <div class="bg-white w-fit rounded-lg px-4 py-2">
                        <div class="flex gap-3">
                            <div
                                class="p-1 flex items-center justify-center w-12 h-12 text-red-300 text-center rounded-lg bg-red-700">
                                <!-- <i class="fa-solid fa-users"></i> -->
                            </div>
                            <div class="text-dark">
                                <p class="text-lg font-medium">4.8</p>
                                <p class="text-sm text-gray-500">Rating Bengkel</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pemasukan Bulan Ini -->
                    <div class="bg-white w-fit rounded-lg px-4 py-2">
                        <div class="flex gap-3">
                            <div
                                class="p-1 flex items-center justify-center w-12 h-12 text-red-300 text-center rounded-lg bg-red-700">
                                <!-- <i class="fa-solid fa-users"></i> -->
                            </div>
                            <div class="text-dark">
                                <p class="text-lg font-medium text-green-500">Rp23.000.000</p>
                                <p class="text-sm text-gray-500">Pemasukan Bulan Ini</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pengeluaran Bulan Ini -->
                    <div class="bg-white w-fit rounded-lg px-4 py-2">
                        <div class="flex gap-3">
                            <div
                                class="p-1 flex items-center justify-center w-12 h-12 text-red-300 text-center rounded-lg bg-red-700">
                                <!-- <i class="fa-solid fa-users"></i> -->
                            </div>
                            <div class="text-dark">
                                <p class="text-lg font-medium text-red-500">Rp10.000.000</p>
                                <p class="text-sm text-gray-500">Pengeluaran Bulan Ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="flex flex-col md:flex-row gap-4 w-full my-4">
                <!-- Finance -->
                <div class="w-full md:w-[60%] bg-white rounded-xl p-3 flex flex-col items-center justify-center">
                    <!-- Chart -->
                    <canvas id="financeChart"></canvas>
                    <!-- Legend -->
                    <div class="flex flex-row items-start md:items-center gap-1 md:gap-4 text-sm">
                        <div class="inline-flex items-center">
                            <img src="{{ asset('icons/legend-pemasukan.svg') }}" class="w-8 h-8">Pemasukan
                        </div>
                        <div class="inline-flex items-center">
                            <img src="{{ asset('icons/legend-pengeluaran.svg') }}" class="w-8 h-8"> Pengeluaran
                        </div>
                    </div>
                </div>

                <!-- Entri Servis -->
                <div class="w-full md:w-[40%] bg-white rounded-xl p-3 flex flex-col gap-2 items-center justify-between">
                    <p class="font-bold text-xl">Entri Servis</p>
                    <!-- Chart -->
                    <div class="w-80%">
                        <canvas id="serviceChart" class="h-40"></canvas>
                    </div>

                    <!-- Legend -->
                    <div class="flex flex-row items-start md:items-center gap-1 md:gap-4 mt-4 text-gray-700 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#FF928A]"></div>
                            <span>Dalam antrian</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#FFAE4C]"></div>
                            <span>Dalam perbaikan</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#8979FF]"></div>
                            <span>Selesai</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Ulasan dan Chat Terbaru -->
            <div class="flex flex-col md:flex-row gap-4 w-full my-4">
                <!-- Ulasan -->
                <div class="w-full md:w-[40%] bg-white rounded-xl p-4 flex flex-col items-start gap-4">
                    <p class="font-semibold text-xl">Ulasan Terbaru</p>

                    <!-- Review List -->
                    <div class="flex flex-col gap-3 w-full">
                        @foreach ([
                            'Pelanggan Wang Yiren memberikan ulasan, "Servis sangat memuaskan dan cepat, teknisi sangat ramah!"',
                            'Pelanggan Lee Ji-eun bilang, "Pengalaman terbaik! Akan kembali lagi ke sini!"',
                            'Pelanggan Johnny Wang menulis, "Hasil servis sangat memuaskan dan sesuai ekspektasi."',
                            'Pelanggan Karina menyampaikan, "Teknisi datang tepat waktu dan pengerjaan cepat."',
                            'Pelanggan Baekhyun berkata, "Layanan oke banget! Sangat direkomendasikan."'
                        ] as $review)
                            <div class="inline-flex items-center gap-2 text-gray-800 overflow-hidden group">
                                <i class="fa-solid fa-star shrink-0"></i>
                                <p class="line-clamp-1">
                                    Rating 5 bintang: {{ $review }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <a href="#" class="bg-gray-800 text-white rounded px-6 py-2 cursor-pointer">Lihat semua</a>
                </div>


                <div class="w-full md:w-[60%] bg-white rounded-xl p-4 flex flex-col items-start gap-4">
                    <p class="font-semibold text-xl">Chat Pelanggan Terbaru</p>

                    <!-- Chat List -->
                    <div class="flex flex-col gap-3 w-full">
                        @foreach ([
                            'Berapa lama waktu yang dibutuhkan untuk memperbaiki mesin mobil saya?',
                            'Berapa lama waktu yang dibutuhkan untuk memperbaiki mesin mobil saya?',
                            'Berapa lama waktu yang dibutuhkan untuk memperbaiki mesin mobil saya?',
                            'Berapa lama waktu yang dibutuhkan untuk memperbaiki mesin mobil saya?',
                            'Berapa lama waktu yang dibutuhkan untuk memperbaiki mesin mobil saya?',
                        ] as $chat)
                            <div class="inline-flex w-full items-center gap-2 text-gray-800 overflow-hidden group">
                                <i class="fa-regular fa-comment"></i>
                                <p class="line-clamp-1">
                                    Chat Session ID: 67890 - {{ $chat }}
                                </p>
                                <a class="text-red-700 font-medium ml-4 cursor-pointer">Balas</a>
                            </div>                        
                        @endforeach
                    </div>

                    <a class="bg-gray-800 text-white rounded px-6 py-2 cursor-pointer">Lihat semua</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Load js -->
    <script src="{{ asset('js/dashboard.js') }}" defer></script>
@endsection