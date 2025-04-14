@extends('admin.layouts.app')

@section('title', 'Kelola Entri Servis')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog Berhasil -->
            @include('admin.components.dialog', [
                'id' => 'dialog-success',
                'show' => false,
                'type' => 'success',
                'message' => 'Data entri servis berhasil dihapus!'
            ])

            <!-- Dialog Gagal -->
            @include('admin.components.dialog', [
                'id' => 'dialog-error',
                'show' => false,
                'type' => 'error',
                'message' => 'Data entri servis gagal dihapus!'
            ])

            <!-- Dialog Delete -->
            @include('admin.components.dialog', [
                'id' => 'hapus-entri-servis',
                'show' => false,
                'type' => 'delete',
                'message' => 'Yakin ingin menghapus entri servis ini?'
            ])

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
                    <button class="filter-btn bg-red-200 text-red-500 rounded-lg px-6 py-2" data-status="">Semua Status</button>
                    <button
                        class="filter-btn bg-white text-gray-400 border border-gray-400 hover:bg-gray-100 rounded-lg px-6 py-2"
                        data-status="Dalam Antrian">Dalam Antrian</button>
                    <button
                        class="filter-btn bg-white text-gray-400 border border-gray-400 hover:bg-gray-100 rounded-lg px-6 py-2"
                        data-status="Dalam Perbaikan">Dalam Perbaikan</button>
                    <button
                        class="filter-btn bg-white text-gray-400 border border-gray-400 hover:bg-gray-100 rounded-lg px-6 py-2"
                        data-status="Selesai">Selesai</button>
                </div>

                <!-- Dropdown di layar kecil -->
                <div class="block md:hidden my-4">
                    <select id="filter-select"
                        class="w-full border border-gray-400 rounded-lg py-2 px-4 focus:outline-none focus:ring-1 focus:ring-gray-500">
                        <option value="">Semua Status</option>
                        <option value="Dalam Antrian">Dalam Antrian</option>
                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div class="my-4">
                    <input type="text" id="customServiceSearch" placeholder="🔍︎ Cari entri servis..."
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
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Keterangan</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Harga</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Kunjungan Selanjutnya</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-600">
                        @foreach ($pelanggan as $item)
                            <tr class="odd:bg-white even:bg-gray-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ url('/ubah-entri-servis', ['id' => $item->id]) }}" class="text-blue-500 hover:underline">Ubah</a><br>
                                    <button class="text-red-500 hover:underline" onclick="showDeleteDialog(event)">Hapus</button><br>
                                    <button class="text-orange-500 hover:underline">Ingatkan Pelanggan</button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->plat_nomor }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_pelanggan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->nomor_whatsapp }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->status_servis }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->keterangan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kunjungan_selanjutnya }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var table = $('#data-table').DataTable({
                scrollX: true,
                lengthChange: false,
                language: {
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoFiltered: "",
                    infoEmpty: "Tidak ada data tersedia",
                }
            });

            // Custom search
            $('#customServiceSearch').on('keyup', function () {
                var searchInput = $(this).val()
                table.search(searchInput).draw();
            });

            // Filter tombol berdasarkan status servis
            $('.filter-btn').on('click', function () {
                var status = $(this).data('status');

                // Reset semua button ke tampilan default
                $('.filter-btn').removeClass('bg-red-200 text-red-500').addClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');

                // Aktifkan tombol yang diklik
                $(this).addClass('bg-red-200 text-red-500').removeClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');

                // Kolom ke-4 adalah "Status Servis" (dimulai dari 0)
                table.column(4).search(status).draw();
            });

            // Filter dari dropdown (untuk layar kecil)
            $('#filter-select').on('change', function () {
                var status = $(this).val();

                // Sinkronisasi tombol juga (jika mau)
                $('.filter-btn').removeClass('bg-red-200 text-red-500').addClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
                $('.filter-btn[data-status="' + status + '"]').addClass('bg-red-200 text-red-500').removeClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');

                table.column(4).search(status).draw();
            });

        });
    </script>

    <script>
        function showSuccessDialog(event) {
            event.preventDefault();
            document.getElementById('dialog-success').classList.remove('hidden');
        }

        function showErrorDialog(event) {
            event.preventDefault();
            document.getElementById('dialog-error').classList.remove('hidden');
        }

        function showDeleteDialog(event) {
            event.preventDefault();
            document.getElementById('hapus-entri-servis').classList.remove('hidden');
        }

        // Tangani aksi konfirmasi
        document.addEventListener('delete-confirmed', () => {
            try {
                // Di sini lakukan aksi hapus, bisa redirect atau AJAX
                // Contoh redirect ke route:
                // window.location.href = '/admin/hapus/123'; // ganti sesuai ID

                // tutup setelah selesai
                document.getElementById('hapus-entri-servis').classList.add('hidden');

                // tunjukkan dialog berhasil
                showSuccessDialog(event);
            } catch {
                showErrorDialog(event);
            }
            
        });

        // Batal
        document.addEventListener('delete-cancelled', () => {
            document.getElementById('hapus-entri-servis').classList.add('hidden');
        });
    </script>

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