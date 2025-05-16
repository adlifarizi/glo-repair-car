@extends('admin.layouts.app')

@section('title', $mode === 'edit' ? 'Ubah Entri Servis' : 'Tambah Entri Servis')

@section('content')
    <div class="min-h-screen">
        @include('admin.components.header')

        <div class="p-4">
            <!-- Dialog -->
            @include('admin.components.dialog', ['id' => 'dialog-success', 'show' => false, 'type' => 'success', 'message' => ''])
            @include('admin.components.dialog', ['id' => 'dialog-error', 'show' => false, 'type' => 'error', 'message' => ''])

            <!-- Page title -->
            <div class="flex items-center md:items-center gap-4 justify-start my-4">
                <h1 class="hidden md:block font-semibold text-2xl text-red-800">Kelola Entri Servis</h1>
                <p class="hidden md:block font-semibold"><i class="fa-solid fa-chevron-right"></i></p>
                <h2 class="font-medium text-2xl md:text-lg text-red-800 md:text-gray-400 capitalize md:normal-case">
                    {{ $mode === 'edit' ? 'Ubah Entri Servis' : 'Tambah Entri Servis' }}
                </h2>
            </div>

            <!-- Form -->
            <div class="p-4 bg-white rounded-xl">
                <p class="text-lg font-semibold">{{ $mode === 'edit' ? 'Ubah Entri Servis' : 'Tambah Entri Servis' }}</p>
                <p class="text-gray-600">
                    {{ $mode === 'edit' ? 'Ubah entri servis yang dipilih' : 'Tambahkan entri servis baru' }}
                </p>

                <form class="w-full mt-6" id="service-entry-form">

                    {{-- PLAT NOMOR --}}
                    <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                        <label for="plat_no" class="text-sm font-medium text-gray-700">Plat Nomor Kendaraan</label>
                        <input type="text" name="plat_no" id="plat_no" maxlength="20"
                            value="{{ old('plat_no', '') }}"
                            placeholder="Plat nomor kendaraan pelanggan (ex. F 5383 UBT)"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                    </div>

                    {{-- NAMA PELANGGAN --}}
                    <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                        <label for="nama_pelanggan" class="text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" maxlength="255"
                            value="{{ old('nama_pelanggan', '') }}"
                            placeholder="Nama pelanggan/pemilik kendaraan"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                    </div>

                    {{-- WHATSAPP & HARGA --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                        <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                            <label for="nomor_whatsapp" class="text-sm font-medium text-gray-700">Nomor Whatsapp</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 bg-red-100 text-red-500 border border-r-0 border-gray-300 rounded-l-md text-sm">+62</span>
                                <input type="text" name="nomor_whatsapp" id="nomor_whatsapp" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 14)"
  pattern="[0-9]{10,14}"
                                    value="{{ old('nomor_whatsapp', '') }}"
                                    placeholder="Nomor Whatsapp Pelanggan"
                                    class="w-full border border-gray-300 rounded-r-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-[auto_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                            <label for="harga" class="text-sm font-medium text-gray-700">Harga</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 bg-red-100 text-red-500 border border-r-0 border-gray-300 rounded-l-md text-sm">Rp</span>
                                <input type="number" name="harga" id="harga" oninput="validateNominal(this)"
                                    value="{{ old('harga', '') }}" placeholder="Nominal"
                                    class="w-full border border-gray-300 rounded-r-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- KETERANGAN --}}
                    <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-start mb-4 gap-2 md:gap-4">
                        <label for="keterangan" class="text-sm font-medium text-gray-700 mt-2">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="4"
                            maxlength="255" #16a34aplaceholder="Keterangan"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">{{ old('keterangan', '') }}</textarea>
                    </div>

                    <!-- Hidden created at -->
                     <input class="hidden" name="created_at" id="created_at"></input>

                    {{-- STATUS SERVIS (hanya saat edit) --}}
                    @if($mode === 'edit')
                        <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-start mb-6 gap-2 md:gap-4">
                            <label class="text-sm font-medium text-gray-700">Status Servis</label>
                            <div>
                                <div class="flex flex-col md:flex-row">
                                    <label class="inline-flex items-center gap-2 mr-4">
                                        <input type="radio" name="status" value="Dalam antrian" class="accent-red-500">
                                        <span>Dalam antrian</span>
                                    </label>
                                    <label class="inline-flex items-center gap-2 mr-4">
                                        <input type="radio" name="status" value="Sedang diperbaiki" class="accent-red-500">
                                        <span>Sedang diperbaiki</span>
                                    </label>
                                    <label class="inline-flex items-center gap-2">
                                        <input type="radio" name="status" value="Selesai" class="accent-red-500">
                                        <span>Selesai</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- SELESAIKAN TRANSAKSI (hanya saat edit dan belum bayar) --}}
                    @if($mode === 'edit')
                        <button id="selesaikan-transaksi-btn"
                            class="my-4 font-medium py-2 px-6 rounded-md btn-disabled"
                            disabled>
                            Selesaikan Transaksi
                        </button>
                    @endif


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

        <!-- Modal Popup -->
        <div id="modal-pemasukan" class="hidden fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50">
            <div class="bg-white p-6 rounded-md w-96">
                <h2 class="text-xl font-medium mb-4">Tambah Pemasukan</h2>
                <form id="form-pemasukan" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_servis" id="id_servis" value="">
                    <div class="mb-4">
                        <label for="nominal" class="block text-gray-700">Nominal</label>
                        <input type="number" id="nominal" oninput="validateNominal(this)" name="nominal" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="keterangan" class="block text-gray-700">Keterangan</label>
                        <textarea id="keterangan_modal" name="keterangan" rows="2" class="w-full p-2 border border-gray-300 rounded"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="tanggal_pemasukan" class="block text-gray-700">Tanggal Pemasukan</label>
                        <input type="date" id="tanggal_pemasukan" name="tanggal_pemasukan" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="bukti_pemasukan" class="block text-gray-700">Bukti Pemasukan (Upload File)</label>
                        <input type="file" accept="image/*" id="bukti_pemasukan" name="bukti_pemasukan" class="w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="batal-btn" class="py-2 px-4 bg-gray-300 hover:bg-gray-400 text-gray-600 rounded-md mr-2">Batal</button>
                        <button type="submit" class="py-2 px-4 bg-green-600 hover:bg-green-700 text-white rounded-md">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>

    <script>
        const mode = "{{ $mode }}";
        const serviceEntryId = "{{ request()->route('id') ?? '' }}";
    </script>

    <script src="{{ asset('js/admin/form-service-entry.js') }}" defer></script>
    <script src="{{ asset('js/admin/validate_nominal.js') }}"></script>


    <style>
        .btn-disabled {
            background-color: #d1d5db; /* bg-gray-300 */
            color: #6b7280; /* text-gray-500 */
            cursor: not-allowed;
        }

        .btn-disabled:hover {
            background-color: #d1d5db; /* tetap abu-abu */
        }

        .btn-active {
            background-color: #16a34a; /* bg-green-600 */
            color: white;
            cursor: pointer;
        }

        .btn-active:hover {
            background-color: #15803d; /* bg-green-700 */
        }
    </style>
@endsection