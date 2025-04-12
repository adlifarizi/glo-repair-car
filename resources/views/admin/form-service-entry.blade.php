@extends('admin.layouts.app')

@section('title', isset($entriServis) ? 'Ubah Entri Servis' : 'Tambah Entri Servis')

@section('content')
    <div>
        <!-- Page title -->
        <div class="flex items-center md:items-center gap-4 justify-start my-4">
            <h1 class="hidden md:block font-semibold text-2xl text-red-800">Kelola Entri Servis</h1>
            <p class="hidden md:block font-semibold"><i class="fa-solid fa-chevron-right"></i></p>
            <h2 class="font-medium text-2xl md:text-lg text-red-800 md:text-gray-400 capitalize md:normal-case">
                {{ isset($entriServis) ? 'Ubah entri servis' : 'Tambah entri servis' }}
            </h2>
        </div>

        <!-- Form -->
        <div class="p-4 bg-white rounded-xl">
            <p class="text-lg font-semibold">{{ isset($entriServis) ? 'Ubah entri servis' : 'Tambah entri servis' }}</p>
            <p class="text-gray-600">
                {{ isset($entriServis) ? 'Ubah entri servis yang dipilih' : 'Tambahkan entri servis baru' }}
            </p>

            <form method="POST" class="w-full mt-6"
                action="{{ isset($entriServis) ? route('entry.update', $entriServis->id) : route('entry.store') }}">
                @csrf
                @if(isset($entriServis))
                    @method('PUT')
                @endif

                {{-- PLAT NOMOR --}}
                <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                    <label for="plat_nomor" class="text-sm font-medium text-gray-700">Plat Nomor Kendaraan</label>
                    <input type="text" name="plat_nomor" id="plat_nomor"
                        value="{{ old('plat_nomor', $entriServis->plat_nomor ?? '') }}"
                        placeholder="Plat nomor kendaraan pelanggan (ex. F 5383 UBT)"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                </div>

                {{-- NAMA PELANGGAN --}}
                <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                    <label for="nama_pelanggan" class="text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                        value="{{ old('nama_pelanggan', $entriServis->nama_pelanggan ?? '') }}"
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
                            <input type="text" name="nomor_whatsapp" id="nomor_whatsapp"
                                value="{{ old('nomor_whatsapp', $entriServis->nomor_whatsapp ?? '') }}"
                                placeholder="Nomor Whatsapp Pelanggan"
                                class="w-full border border-gray-300 rounded-r-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-[auto_1fr] grid-cols-1 md:items-center mb-4 gap-2 md:gap-4">
                        <label for="harga" class="text-sm font-medium text-gray-700">Harga</label>
                        <div class="flex">
                            <span
                                class="inline-flex items-center px-3 bg-red-100 text-red-500 border border-r-0 border-gray-300 rounded-l-md text-sm">Rp</span>
                            <input type="number" name="harga" id="harga"
                                value="{{ old('harga', $entriServis->harga ?? '') }}" placeholder="Nominal"
                                class="w-full border border-gray-300 rounded-r-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">
                        </div>
                    </div>
                </div>

                {{-- KETERANGAN --}}
                <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-start mb-4 gap-2 md:gap-4">
                    <label for="keterangan" class="text-sm font-medium text-gray-700 mt-2">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="4" placeholder="Keterangan"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-gray-500 focus:ring-1 ring-inset focus:outline-none">{{ old('keterangan', $entriServis->keterangan ?? '') }}</textarea>
                </div>

                {{-- STATUS SERVIS (hanya saat edit) --}}
                @if(isset($entriServis))
                            <div class="grid md:grid-cols-[130px_1fr] grid-cols-1 md:items-start mb-6 gap-2 md:gap-4">
                                <label class="text-sm font-medium text-gray-700">Status Servis</label>
                                <div>
                                    @php
                                        $status = old('status', $entriServis->status_servis ?? '');
                                    @endphp
                                    <div class="flex flex-col md:flex-row">
                                        <label class="inline-flex items-center gap-2 mr-4">
                                            <input type="radio" name="status" value="dalam_antrian" {{ $status == 'Dalam Antrian' ? 'checked' : '' }} class="accent-red-500">
                                            <span>Dalam antrian</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 mr-4">
                                            <input type="radio" name="status" value="dalam_perbaikan" {{ $status == 'Dalam Perbaikan' ? 'checked' : '' }} class="accent-red-500">
                                            <span>Dalam perbaikan</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" name="status" value="selesai" {{ $status == 'Selesai' ? 'checked' : '' }} class="accent-red-500">
                                            <span>Selesai</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                @endif

                {{-- BUTTON --}}
                <button type="submit"
                    class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 rounded-md transition duration-200">
                    {{ isset($entriServis) ? 'Simpan perubahan' : 'Simpan data' }}
                </button>
            </form>
        </div>
    </div>
@endsection