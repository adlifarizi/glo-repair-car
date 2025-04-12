<div id="{{ $id ?? 'dialog' }}" class="{{ $show ? '' : 'hidden' }} fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
    <div class="w-full max-w-md flex flex-col items-center justify-center gap-3 px-6 py-4 bg-white rounded-xl border shadow-md">
        @if($type === 'success')
            <i class="fa-regular fa-circle-check text-7xl text-green-500"></i>
            <h2 class="text-2xl text-gray-900 font-semibold">Berhasil!</h2>
        @elseif($type === 'error')
            <i class="fa-regular fa-circle-xmark text-7xl text-red-500"></i>
            <h2 class="text-2xl text-red-500 font-semibold">Gagal!</h2>
        @elseif($type === 'delete')
            <i class="fa-regular fa-circle-question text-7xl text-[#EEC9AA]"></i>
            <h2 class="text-2xl text-gray-900 font-semibold">Konfirmasi Penghapusan</h2>
        @endif

        <p class="text-gray-500">{{ $message ?? '' }}</p>

        @if($type === 'delete')
            <div class="flex gap-2">
                <button onclick="document.dispatchEvent(new CustomEvent('delete-confirmed'))"
                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                <button onclick="document.dispatchEvent(new CustomEvent('delete-cancelled'))"
                    class="px-4 py-2 border border-red-500 text-red-500 rounded hover:bg-red-50">Batal</button>
            </div>
        @else
            <button onclick="document.querySelector('#{{ $id ?? 'dialog' }}').classList.add('hidden')"
                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Oke</button>
        @endif
    </div>
</div>