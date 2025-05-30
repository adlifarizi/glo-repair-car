@extends('admin.layouts.app')

@section('title', 'Kelola Pemasukan')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog -->
            @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-confirm-delete', 'show' => false, 'type' => 'confirm-delete', 'message' => 'Yakin ingin menghapus pemasukan ini?'])

            <!-- Page title -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between my-4">
                <h1 class="font-semibold text-2xl">Kelola Pemasukan</h1>
                <a href="{{ url('/tambah-pemasukan') }}" class="bg-gray-800 text-white rounded px-6 py-2 cursor-pointer">Tambah pemasukan</a>
            </div>

            <!-- Table -->
            <div class="p-4 bg-white rounded-xl">
                <p class="text-lg font-semibold">Data Pemasukan</p>
                <p class="text-gray-600">Data ini merupakan pemasukan dari hasil servis</p>            

                <div class="my-4">
                    <input type="text" id="customSearch" placeholder="🔍︎ Cari data pemasukan" maxlength="255"
                        class="w-full border border-gray-400 rounded-lg py-2 px-4 focus:outline-none focus:ring-1 focus:ring-gray-500">
                </div>

                <!-- Table -->
                <table id="data-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Tindakan</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">ID Servis</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Nominal</th>
                            <th class="px-3 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Tanggal Pemasukan</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Keterangan</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Bukti Pemasukan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-600" id="pemasukan-table-body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/manage-revenue.js') }}" defer></script>

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