@extends('admin.layouts.app')

@section('title', 'Kelola Entri Servis')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog -->
            @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-confirm-delete', 'show' => false, 'type' => 'confirm-delete', 'message' => 'Yakin ingin menghapus entri servis ini?'])

            <!-- Page title -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between my-4">
                <h1 class="font-semibold text-2xl">Kelola Entri Servis</h1>
                <a href="{{ url('/tambah-entri-servis') }}" class="bg-gray-800 text-white rounded px-6 py-2 cursor-pointer">Tambah entri servis</a>
            </div>

            <!-- Table -->
            <div class="p-4 bg-white rounded-xl">
                <p class="text-lg font-semibold">Data Entri Servis</p>
                <p class="text-gray-600">Data ini merupakan data servis mobil yang akan berlangsung hingga sudah selesai diperbaiki</p>

                <!-- Filter Status -->
                <!-- Tombol di layar besar -->
                <div class="hidden md:flex my-4 gap-2">
                    <button class="filter-btn bg-red-200 text-red-500 rounded-lg px-6 py-2" data-status="">Semua status</button>
                    <button
                        class="filter-btn bg-white text-gray-400 border border-gray-400 hover:bg-gray-100 rounded-lg px-6 py-2"
                        data-status="Dalam antrian">Dalam antrian</button>
                    <button
                        class="filter-btn bg-white text-gray-400 border border-gray-400 hover:bg-gray-100 rounded-lg px-6 py-2"
                        data-status="Sedang diperbaiki">Sedang diperbaiki</button>
                    <button
                        class="filter-btn bg-white text-gray-400 border border-gray-400 hover:bg-gray-100 rounded-lg px-6 py-2"
                        data-status="Selesai">Selesai</button>
                </div>

                <!-- Dropdown di layar kecil -->
                <div class="block md:hidden my-4">
                    <select id="filter-select"
                        class="w-full border border-gray-400 rounded-lg py-2 px-4 focus:outline-none focus:ring-1 focus:ring-gray-500">
                        <option value="">Semua Status</option>
                        <option value="Dalam antrian">Dalam Antrian</option>
                        <option value="Sedang diperbaiki">Dalam Perbaikan</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div class="my-4">
                    <input type="text" id="customSearch" placeholder="🔍︎ Cari entri servis..." maxlength="255"
                        class="w-full border border-gray-400 rounded-lg py-2 px-4 focus:outline-none focus:ring-1 focus:ring-gray-500">
                </div>

                <!-- Table -->
                <table id="data-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Tindakan</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Plat Nomor</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Nama Pelanggan</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Nomor Whatsapp</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Status Servis</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Status Pembayaran</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Keterangan</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Harga</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Kunjungan Selanjutnya</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-600" id="service-entries-table-body">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/manage-service-entries.js') }}" defer></script>

    <style>
        .dt-search {
            display: none;
        }

        /* Sembunyikan label jika tidak perlu */
        .dt-search label {
            display: none;
        }

        /* Input styling */
        .dt-search input.dt-input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 1rem !important;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            font-size: 1rem;
            box-sizing: border-box;
        }
    </style>

@endsection