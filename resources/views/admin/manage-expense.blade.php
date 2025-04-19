@extends('admin.layouts.app')

@section('title', 'Kelola Pengeluaran')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog -->
            @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-confirm-delete', 'show' => false, 'type' => 'confirm-delete', 'message' => 'Yakin ingin menghapus pengeluaran ini?'])

            <!-- Page title -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between my-4">
                <h1 class="font-semibold text-2xl">Kelola Pengeluaran</h1>
                <a href="{{ url('/tambah-pengeluaran') }}" class="bg-gray-800 text-white rounded px-6 py-2 cursor-pointer">Tambah pengeluaran</a>
            </div>

            <!-- Table -->
            <div class="p-4 bg-white rounded-xl">
                <p class="text-lg font-semibold">Data Pengeluaran</p>
                <p class="text-gray-600">Data ini merupakan pengeluaran</p>            

                <div class="my-4">
                    <input type="text" id="customSearch" placeholder="🔍︎ Cari data pengeluaran"
                        class="w-full border border-gray-400 rounded-lg py-2 px-4 focus:outline-none focus:ring-1 focus:ring-gray-500">
                </div>

                <!-- Table -->
                <table id="data-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Tindakan</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Nominal</th>
                            <th class="py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Tanggal Pengeluaran</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Keterangan</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Bukti Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-600" id="pengeluaran-table-body">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin/manage-expense.js') }}" defer></script>

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