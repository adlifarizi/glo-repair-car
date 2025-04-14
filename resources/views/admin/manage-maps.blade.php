@extends('admin.layouts.app')

@section('title', 'Kelola Maps')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog -->
            @include('admin.components.dialog', ['id' => 'dialog-success-edit', 'show' => false, 'type' => 'success', 'message' => 'Data maps berhasil diubah!'])
            @include('admin.components.dialog', ['id' => 'dialog-error-edit', 'show' => false, 'type' => 'error', 'message' => 'Data maps gagal diubah!'])

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
                    <button onclick="showDialog('dialog-success-edit')"
                        class="w-full bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 rounded-md transition duration-200">
                        Simpan Lokasi
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

    <script>
        function showDialog(id, message = null) {
            const dialog = document.getElementById(id);
            if (message) {
                dialog.querySelector('p').textContent = message;
            }
            dialog.classList.remove('hidden');
        }
    </script>

    <script>
        const defaultLat = -6.5891473;
        const defaultLng = 106.806127;

        // Inisialisasi map
        const map = L.map('map').setView([defaultLat, defaultLng], 17);

        // Setelah inisialisasi map
        map.zoomControl.remove(); // Hapus default zoom

        // Custom control
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // Ganti isi tombol dengan ikon
        setTimeout(() => {
            const zoomInBtn = document.querySelector('.leaflet-control-zoom-in');
            const zoomOutBtn = document.querySelector('.leaflet-control-zoom-out');

            const zoomInIconHTML = document.querySelector('#zoom-in-icon').innerHTML;
            const zoomOutIconHTML = document.querySelector('#zoom-out-icon').innerHTML;

            zoomInBtn.innerHTML = zoomInIconHTML;
            zoomOutBtn.innerHTML = zoomOutIconHTML;
        }, 0);

        // Tambah tile dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Custom marker icon merah
        const redIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Tampilkan marker default
        let marker = L.marker([defaultLat, defaultLng], { icon: redIcon }).addTo(map)
            .bindPopup(`Latitude: ${defaultLat}<br>Longitude: ${defaultLng}`).openPopup();

        // Event klik map
        map.on('click', function (e) {
            const lat = e.latlng.lat.toFixed(7);
            const lng = e.latlng.lng.toFixed(7);

            // Hapus marker sebelumnya
            if (marker) {
                map.removeLayer(marker);
            }

            // Tambahkan marker baru dengan icon merah
            marker = L.marker([lat, lng], { icon: redIcon }).addTo(map)
                .bindPopup(`Latitude : ${lat}<br>Longitude : ${lng}`).openPopup();

        });
    </script>
@endsection