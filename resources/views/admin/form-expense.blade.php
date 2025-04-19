@extends('admin.layouts.app')

@section('title', $mode === 'edit' ? 'Ubah Pengeluaran' : 'Tambah Pengeluaran')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog -->
            @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'message' => ''])

            <!-- Page title -->
            <div class="flex items-center md:items-center gap-4 justify-start my-4">
                <h1 class="hidden md:block font-semibold text-2xl text-red-800">Kelola Pengeluaran</h1>
                <p class="hidden md:block font-semibold"><i class="fa-solid fa-chevron-right"></i></p>
                <h2 class="font-medium text-2xl md:text-lg text-red-800 md:text-gray-400 capitalize md:normal-case">
                    {{ $mode === 'edit' ? 'Ubah Pengeluaran' : 'Tambah Pengeluaran' }}
                </h2>
            </div>

            <!-- Form -->
            <div class="p-4 bg-white rounded-xl">
                <p class="text-lg font-semibold">{{ $mode === 'edit' ? 'Ubah Pengeluaran' : 'Tambah Pengeluaran' }}</p>
                <p class="text-gray-600">
                    {{ $mode === 'edit' ? 'Ubah pengeluaran secara manual' : 'Tambah pengeluaran secara manual' }}
                </p>

                <form class="w-full mt-6" id="expense-form">

                    {{-- NOMINAL & TANGGAL PENGELUARAN --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                        <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                            <label for="nominal" class="text-sm font-medium text-gray-700">Nominal</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 bg-red-100 text-red-500 border border-r-0 border-gray-300 rounded-l-md text-sm">Rp</span>
                                <input type="number" name="nominal" id="nominal"
                                    value="{{ old('nominal', '') }}" placeholder="nominal pengeluaran"
                                    class="w-full border border-gray-300 rounded-r-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-[auto_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                            <label for="tanggal_pengeluaran" class="text-sm font-medium text-gray-700">Tanggal Pengeluaran</label>
                            <div class="flex items-center justify-between border border-gray-300 rounded-md px-4 py-2"
                                onclick="document.getElementById('tanggal_pengeluaran')._flatpickr.open();">
                                <input type="text" name="tanggal_pengeluaran" id="tanggal_pengeluaran"
                                    value="{{ old('tanggal_pengeluaran', '') }}"
                                    placeholder="tanggal pengeluaran" class="w-full focus:ring-0 focus:outline-none">
                                <i class='bx bx-calendar text-xl'></i>
                            </div>
                        </div>
                    </div>

                    {{-- BUKTI PENGELUARAN --}}
                    <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                        <label for="bukti_pengeluaran" class="text-sm font-medium text-gray-700">Bukti Pengeluaran</label>
                        <div class="flex items-center justify-between border border-gray-300 rounded-md px-4 py-2 relative">
                            <!-- Input file disembunyikan -->
                            <input type="file" name="bukti_pengeluaran" id="bukti_pengeluaran" accept="image/*"
                                class="absolute inset-0 opacity-0 cursor-pointer" />

                            <!-- Text input untuk menunjukkan nama file terpilih -->
                            <span id="file-name" class="w-full truncate text-gray-700">
                                {{ old('bukti_pengeluaran', '') }}
                            </span>

                            <!-- Tombol custom -->
                            <span class="text-red-800 font-medium whitespace-nowrap ml-4">Pilih File</span>
                        </div>
                    </div>

                    {{-- KETERANGAN --}}
                    <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-start mb-4 gap-2 md:gap-4">
                        <label for="keterangan" class="text-sm font-medium text-gray-700 mt-2">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="4" placeholder="keterangan"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                            {{ old('keterangan', '') }}
                        </textarea>
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit" id="submit-button"
                        class="w-full bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 rounded-md transition duration-200">
                        <span id="submit-button-text">Simpan Data</span>
                        <div id="spinner" class="hidden" role="status">
                            <i class="fa-solid fa-spinner animate-spin"></i>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const mode = "{{ $mode }}";
        const pengeluaranId = "{{ request()->route('id') ?? '' }}";
    </script>

    <script src="{{ asset('js/admin/form-expense.js') }}" defer></script>
@endsection