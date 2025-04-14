@extends('admin.layouts.app')

@section('title', 'Kelola Ulasan')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog: Konfirmasi Delete -->
            @include('admin.components.dialog', [
                'id' => 'dialog-confirm-delete',
                'show' => false,
                'type' => 'delete',
                'message' => 'Yakin ingin menghapus ulasan ini?'
            ])

            <!-- Dialog Success & Error -->
            @include('admin.components.dialog', ['id' => 'dialog-success-delete', 'show' => false, 'type' => 'success', 'message' => 'Ulasan berhasil dihapus!'])
            @include('admin.components.dialog', ['id' => 'dialog-error-delete', 'show' => false, 'type' => 'error', 'message' => 'Gagal menghapus ulasan!'])

            @include('admin.components.dialog', ['id' => 'dialog-success-show', 'show' => false, 'type' => 'success', 'message' => 'Ulasan berhasil ditampilkan!'])
            @include('admin.components.dialog', ['id' => 'dialog-error-show', 'show' => false, 'type' => 'error', 'message' => 'Gagal menampilkan ulasan!'])

            @include('admin.components.dialog', ['id' => 'dialog-success-hide', 'show' => false, 'type' => 'success', 'message' => 'Ulasan berhasil disembunyikan!'])
            @include('admin.components.dialog', ['id' => 'dialog-error-hide', 'show' => false, 'type' => 'error', 'message' => 'Gagal menyembunyikan ulasan!'])

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
                    <but ton class="filter-btn bg-white text-gray-400 border border-gray-400 hover:bg-gray-100 rounded-lg px-6 py-2" data-show="0">Disembunyikan</button>
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
                            <th class="px-6 py-3 hidden">Visibilitas</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Rating</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Plat Nomor</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap">Nama Pengulas</th>
                            <th class="px-6 py-3 text-left text-lg font-medium text-gray-800 whitespace-nowrap min-w-64">Ulasan</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white text-gray-600">

                        @foreach ($ulasan as $item)
                        <tr class="odd:bg-white even:bg-gray-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button class="text-red-500 hover:underline" onclick="confirmDelete({{ $item->id }})">Hapus</button><br>
                                <button class="text-orange-500 hover:underline" onclick="toggleVisibility({{ $item->id }}, {{ $item->show }})">
                                    {{ $item->show ? 'Sembunyikan' : 'Tampilkan' }}
                                </button>
                            </td>
                            <td class="hidden">{{ $item->show === true ? '1' : '0' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->rating }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->plat_no }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_pelanggan }}</td>
                            <td class="px-6 py-4">{{ $item->feedback }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let selectedReviewId = null;
        let actionType = '';

        $(document).ready(function () {
            var table = $('#data-table').DataTable({
                scrollX: true,
                lengthChange: false,
                language: {
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoFiltered: "",
                    infoEmpty: "Tidak ada data tersedia",
                },
                columnDefs: [
                    {
                        targets: 1, // Kolom ke-1, yaitu kolom "show"
                        visible: false,
                        searchable: true 
                    }
                ]
            });

            table.column(1).search("1").draw();
            $('.filter-btn[data-show="1"]').addClass('bg-red-200 text-red-500');

            function updateFilterText(show) {
                if (show == 1) {
                    $('#judul-tabel').text('Data Ulasan yang ditampilkan');
                    $('#deskripsi-tabel').text('Data ini merupakan ulasan yang ditampilkan di website utama');
                } else {
                    $('#judul-tabel').text('Data Ulasan yang disembunyikan');
                    $('#deskripsi-tabel').text('Data ini merupakan ulasan yang disembunyikan di website utama');
                }
            }

            $('.filter-btn').on('click', function () {
                var show = $(this).data('show');
                $('.filter-btn').removeClass('bg-red-200 text-red-500').addClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
                $(this).addClass('bg-red-200 text-red-500').removeClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
                table.column(1).search(show).draw();
                updateFilterText(show);
            });

            $('#filter-select').on('change', function () {
                var show = $(this).val();
                $('.filter-btn').removeClass('bg-red-200 text-red-500').addClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
                $('.filter-btn[data-show="' + show + '"]').addClass('bg-red-200 text-red-500').removeClass('bg-white text-gray-400 border border-gray-400 hover:bg-gray-100');
                table.column(1).search(show).draw();
                updateFilterText(show);
            });
        });

        function confirmDelete(id) {
            selectedReviewId = id;
            actionType = 'delete';
            showDialog('dialog-confirm-delete');
        }

        function toggleVisibility(id, currentStatus) {
            selectedReviewId = id;
            const newStatus = currentStatus ? 0 : 1;
            const action = newStatus ? 'show' : 'hide';

            // Simulasi update via redirect (ganti dengan AJAX jika ingin)
            // window.location.href = `/admin/ulasan/visibility/${id}/${newStatus}`;
        }

        function showDialog(id, message = null) {
            const dialog = document.getElementById(id);
            if (message) {
                dialog.querySelector('p').textContent = message;
            }
            dialog.classList.remove('hidden');
        }

        document.addEventListener('delete-confirmed', () => {
            if (selectedReviewId) {
                // window.location.href = `/admin/ulasan/hapus/${selectedReviewId}`;
            }
        });

        document.addEventListener('delete-cancelled', () => {
            document.getElementById('dialog-confirm-delete').classList.add('hidden');
            selectedReviewId = null;
        });
    </script>

    <style>
        .dt-search {
            display: none;
        }
    </style>
@endsection
