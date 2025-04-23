@extends('admin.layouts.app')

@section('title', 'Kelola Ulasan')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog -->
            @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-confirm-delete', 'show' => false, 'type' => 'confirm-delete', 'message' => 'Yakin ingin menghapus ulasan ini?'])

            <!-- Page Title -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between my-4">
                <h1 class="font-semibold text-2xl">Kelola Ulasan</h1>
            </div>

            <!-- Table & Filter -->
            <div class="p-4 bg-white rounded-xl">
                <p id="judul-tabel" class="text-lg font-semibold">Data Ulasan yang ditampilkan</p>
                <p id="deskripsi-tabel" class="text-gray-600">Data ini merupakan ulasan yang ditampilkan di website utama</p>

                <!-- Filter -->
                <div class="hidden md:flex my-4 gap-2">
                    <button class="filter-btn bg-red-200 text-red-500 rounded-lg px-6 py-2" data-show="1">Ditampilkan</button>
                    <button class="filter-btn bg-white text-gray-400 border border-gray-400 hover:bg-gray-100 rounded-lg px-6 py-2" data-show="0">Disembunyikan</button>
                </div>

                <div class="block md:hidden my-4">
                    <select id="filter-select" class="w-full border border-gray-400 rounded-lg py-2 px-4 focus:outline-none focus:ring-1 focus:ring-gray-500">
                        <option value="1">Ditampilkan</option>
                        <option value="0">Disembunyikan</option>
                    </select>
                </div>

                <table id="data-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Tindakan</th>
                            <th class="px-6 py-3">Visibilitas</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Rating</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Plat Nomor</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Nama Pengulas</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap min-w-64">Ulasan</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white text-gray-600" id="feedback-table-body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/manage-feedback.js') }}" defer></script>

    <style>
        .dt-search {
            display: none;
        }
    </style>
@endsection
