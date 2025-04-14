@extends('admin.layouts.app')

@section('title', 'Kelola Pengeluaran')

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
                <h1 class="font-semibold text-2xl">Kelola Pengeluaran</h1>
                <a href="{{ url('/tambah-pengeluaran') }}" class="bg-gray-800 text-white rounded px-6 py-2 cursor-pointer">Tambah pengeluaran</a>
            </div>

            <!-- Table -->
            <div class="p-4 bg-white rounded-xl">
                <p class="text-lg font-semibold">Data Pengeluaran</p>
                <p class="text-gray-600">Data ini merupakan pengeluaran</p>            

                <div class="my-4">
                    <input type="text" id="customExpenseSearch" placeholder="🔍︎ Cari data pengeluaran"
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
                    <tbody class="bg-white text-gray-600">
                        @foreach ($pengeluaran as $item)
                            <tr class="odd:bg-white even:bg-gray-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ url('/ubah-pengeluaran', ['id' => $item->id]) }}" class="text-blue-500 hover:underline">Ubah</a><br>
                                    <button class="text-red-500 hover:underline" onclick="showDeleteDialog(event)">Hapus</button><br>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->tanggal_pengeluaran }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->keterangan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->bukti_pengeluaran }}</td>
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
            $('#customExpenseSearch').on('keyup', function () {
                var searchInput = $(this).val()
                table.search(searchInput).draw();
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