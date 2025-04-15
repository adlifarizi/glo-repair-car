@extends('admin.layouts.app')

@section('title', 'Kelola Kontak')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog -->
            @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'message' => 'Data kontak berhasil diubah!'])
            @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'message' => 'Data kontak gagal diubah!'])

            <!-- Page Title -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between my-4">
                <h1 class="font-semibold text-2xl">Kelola Kontak</h1>
            </div>

            <!-- Table & Filter -->
            <div class="p-4 bg-white rounded-xl">
                <p class="text-lg font-semibold">Ubah kontak</p>
                <p class="text-gray-600">Ubah kontak dan media sosial yang dapat dihubungi oleh pelanggan</p>


                <form class="w-full mt-6" id="contact-form">
                    {{-- ALAMAT EMAIL --}}
                    <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                        <label for="email" class="text-sm font-medium text-gray-700">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', '') }}"
                            placeholder="example@gmail.com"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                    </div>

                    {{-- URL INSTAGRAM --}}
                    <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                        <label for="instagram" class="text-sm font-medium text-gray-700">URL Instagram</label>
                        <input type="text" name="instagram" id="instagram"
                            value="{{ old('instagram', '') }}"
                            placeholder="https://www.instagram.com/username/"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                    </div>

                    {{-- NOMOR TELEPON & WHATSAPP --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                        <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                            <label for="nomor_telepon" class="text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 bg-red-100 text-red-500 border border-r-0 border-gray-300 rounded-l-md text-sm">+62</span>
                                <input type="text" name="nomor_telepon" id="nomor_telepon"
                                    value="{{ old('nomor_telepon', '') }}" placeholder="8xxx"
                                    class="w-full border border-gray-300 rounded-r-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-[auto_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                            <label for="nomor_whatsapp" class="text-sm font-medium text-gray-700">Nomor Whatsapp</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 bg-red-100 text-red-500 border border-r-0 border-gray-300 rounded-l-md text-sm">+62</span>
                                <input type="text" name="nomor_whatsapp" id="nomor_whatsapp"
                                    value="{{ old('nomor_whatsapp', '') }}" placeholder="8xxx"
                                    class="w-full border border-gray-300 rounded-r-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                            </div>
                        </div>
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

    <!-- Load js -->
    <script src="{{ asset('js/manage-contact.js') }}" defer></script>
@endsection