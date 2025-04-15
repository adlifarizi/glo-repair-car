@extends('admin.layouts.app')

@section('title', 'Kelola Maps')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog -->
            @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'message' => 'Data maps berhasil diubah!'])
            @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'message' => 'Data maps gagal diubah!'])

            <!-- Page Title -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between my-4">
                <h1 class="font-semibold text-2xl">Kelola Maps</h1>
            </div>

            <!-- Table & Filter -->
            <div class="p-4 bg-white rounded-xl">
                <p class="text-lg font-semibold">Kelola lokasi Glo Repair Car</p>
                <p class="text-gray-600">Ketuk pada peta untuk menetapkan lokasi Glo Repair Car berada</p>

                <div class="w-full">
                    <div id="map" class="z-10 w-full h-72 md:h-96 my-6"></div>

                    <!-- Tombol simpan -->
                    <button id="submit-button"
                        class="w-full bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 rounded-md transition duration-200">
                        <span id="submit-button-text">Simpan Lokasi</span>
                        <div id="spinner" class="hidden" role="status">
                            <i class="fa-solid fa-spinner animate-spin"></i>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Hidden icons for JS to access -->
            <div id="custom-icons" class="hidden">
                <div id="zoom-in-icon">
                    <x-admin.icon.zoom-in />
                </div>
                <div id="zoom-out-icon">
                    <x-admin.icon.zoom-out />
                </div>
            </div>
        </div>
    </div>

    <style>
        .leaflet-popup-content-wrapper {
            font-size: 14px;
            color: #8E1616 !important;
        }

        .leaflet-control-zoom {
            position: absolute !important;
            right: 10px !important;
            bottom: 10px !important;
            display: flex;
            flex-direction: column;
            border: none !important;
            box-shadow: none !important;
        }

        .leaflet-control-zoom-in,
        .leaflet-control-zoom-out {
            border: none !important;
            width: 40px;
            height: 40px;
            text-align: center !important;
            padding: 0;
            font-size: 18px;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .leaflet-control-zoom-in {
            background-color: #8E1616 !important;
            color: white !important;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }

        .leaflet-control-zoom-out {
            background-color: white !important;
            color: black !important;
            border-bottom-left-radius: 10px !important;
            border-bottom-right-radius: 10px !important;
        }
    </style>

    <!-- Load js -->
    <script src="{{ asset('js/manage-maps.js') }}" defer></script>
@endsection