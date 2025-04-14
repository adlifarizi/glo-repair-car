<div class="w-full flex flex-col md:flex-row gap-8 hidden"> <!-- Hapus hidden saat hasil keluar -->
    <!-- Kartu Status Antrian -->
    <div class="bg-white rounded-lg ring-2 ring-gray-200 p-3 flex-1">
        <h2 class="text-gray-700 font-medium mb-4">3 Maret 2025, 09.34</h2>

        <!-- component -->
        <div class="max-w-xl mx-auto flex flex-col items-start">
            <!-- Step 1 -->
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-600 rounded-lg text-white flex items-center justify-center">
                    <i class="fa fa-check text-xl"></i>
                </div>
                <div class="ml-4 font-medium text-green-600">Dalam Antrian</div>
            </div>

            <!-- Connector -->
            <div class="h-10 w-1 my-2 bg-gray-300 mx-4 relative">
                <div class="absolute left-0 top-0 w-1 bg-green-600" style="height: 0%;"></div>
            </div>

            <!-- Step 2 -->
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-lg text-white flex items-center justify-center">
                    <i class="fa fa-check text-xl"></i>
                </div>
                <div class="ml-4 font-medium text-gray-500">Sedang Diperbaiki</div>
            </div>

            <!-- Connector -->
            <div class="h-10 w-1 my-2 bg-gray-300 mx-4 relative">
                <div class="absolute left-0 top-0 w-1 bg-green-600" style="height: 0%;"></div>
            </div>

            <!-- Step 3 -->
            <div class="flex items-center">
                <div
                    class="w-10 h-10 bg-gray-300 rounded-lg text-white flex items-center justify-center">
                    <i class="fa fa-check text-xl"></i>
                </div>
                <div class="ml-4 font-medium text-gray-500">Selesai</div>
            </div>
        </div>

    </div>

    <!-- Kartu Informasi Servis -->
    <div class="bg-white rounded-lg ring-2 ring-gray-200 p-3 flex-1">
        <div class="flex relative justify-between">
            <button class="w-full text-red-500 font-medium px-4 py-2 border-b-2 border-red-500 rounded-t-md">Informasi
                Servis</button>
            <button class="w-full text-gray-500 font-medium px-4 py-2 hover:bg-red-100 rounded-t-md">Riwayat Servis</button>
        </div>

        <div class="py-4">
            <div class="flex items-center mb-2">
                <i class='bx bxs-info-circle text-xl text-gray-800'></i>
                <p class="ml-2 text-gray-800 font-medium">Informasi Servis</p>
            </div>

            <!-- Divider Line -->
            <div class="w-full h-[1px] bg-gray-300"></div>

            <!-- Informasi -->
            <div class="w-full py-4">
                <div class="grid grid-cols-[auto_min-content_auto] gap-x-3 gap-y-2 w-fit h-fit">
                    <p class="text-gray-700"><i class='bx bxs-calendar-alt mr-2 hidden md:inline'></i>Tanggal Servis</p>
                    <p class="text-gray-700">:</p>
                    <p class="text-gray-700">10 Februari 2025</p>

                    <p class="text-gray-700"><i class='bx bxs-file mr-2 hidden md:inline'></i>Detail Servis</p>
                    <p class="text-gray-700">:</p>
                    <p class="text-gray-700">Menungu Pemeriksaan</p>

                    <p class="text-gray-700"><i class='bx bx-money mr-2 hidden md:inline'></i>Estimasi Biaya</p>
                    <p class="text-gray-700">:</p>
                    <p class="text-gray-700">Menungu Pemeriksaan</p>
                </div>
            </div>

        </div>
    </div>
</div>