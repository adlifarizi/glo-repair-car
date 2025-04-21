<div id="{{ $id ?? 'dialog' }}"
    class="{{ $show ? '' : 'hidden' }} fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50"
    onclick="handleBackdropClick(event, '{{ $id ?? 'dialog' }}')">
    <div id="{{ $id ?? 'dialog' }}-content"
        class="w-full max-w-xs md:max-w-xl flex flex-col items-center justify-center gap-3 px-4 pt-4 pb-8 bg-white rounded-xl border shadow-md">

        <button onclick="document.querySelector('#{{ $id ?? 'dialog' }}').classList.add('hidden')"
            class="self-end text-gray-400 hover:text-gray-600"><i class="fa-regular fa-circle-xmark text-xl"></i></button>

        <img src="{{ asset('icons/progress-tracker-dialog.svg') }}" class="w-48 h-48 md:w-64 md:h-64">

        <p class="text-red-700 text-2xl font-semibold text-center">
            {{ $message ?? 'Data yang Anda Cari Tidak Ditemukan' }}
        </p>
        <p id="subMessage" class="text-red-500 text-sm font-medium text-center">
            {{ $subMessage ?? '' }}
        </p>

    </div>
</div>