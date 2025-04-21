<div class="w-full flex flex-col md:flex-row gap-8"> <!-- Hapus hidden saat hasil keluar -->
    <!-- Kartu Status Antrian -->
    <div class="bg-white rounded-lg ring-2 ring-gray-200 p-3 flex-1">
        <h2 id="progress_updated_at" class="text-gray-700 font-medium mb-4">-</h2>

        <!-- component -->
        <div class="max-w-xl mx-auto flex flex-col items-start" id="status_steps">
            
        </div>

    </div>

    <!-- Kartu Informasi Servis -->
    <div class="bg-white rounded-lg ring-2 ring-gray-200 p-3 flex-1">
        <div class="flex relative justify-between">
            <button id="info_tab" class="w-full text-red-500 font-medium px-0 md:px-4 py-2 border-b-2 border-red-500 rounded-t-md">Informasi Servis</button>
            <button id="history_tab" class="w-full text-gray-500 font-medium px-0 md:px py-2 hover:bg-red-100 rounded-t-md">Riwayat Servis</button>
        </div>

        <div class="py-4" id="info_content">
            <!-- Akan diisi oleh JavaScript -->
        </div>

        <div class="py-4 hidden" id="history_content">
            <!-- Akan diisi oleh JavaScript -->
        </div>
    </div>
</div>