<div x-data="{ open: false }" x-cloak>

    <!-- Chat Window -->
    <div x-show="open" x-transition
        class="fixed flex flex-col bottom-24 right-4 w-80 md:w-[400px] h-[70svh] rounded-2xl bg-white overflow-hidden z-40 shadow-[0_3px_6px_rgba(0,0,0,0.12),3px_0_6px_rgba(0,0,0,0.06),-3px_0_6px_rgba(0,0,0,0.06)]">
        <div class="bg-red-700 text-white p-3 font-bold text-center">
            Admin
        </div>

        <div class="p-3 flex flex-1 flex-col gap-2 overflow-y-auto">
            <!-- User Message -->
            <div class="self-end max-w-[70%] bg-red-500 text-white p-2 rounded-xl rounded-br-none">
                Halo admin, saya mau nanya?
            </div>

            <!-- Admin Message -->
            <div class="self-start max-w-[70%] bg-gray-200 text-black p-2 rounded-xl rounded-bl-none">
                Ada apa?
            </div>

            <!-- User Message -->
            <div class="self-end max-w-[70%] bg-red-500 text-white p-2 rounded-xl rounded-br-none">
                Apakah servis di hari kamis tersedia?
            </div>

            <!-- Admin Message -->
            <div class="self-start max-w-[70%] bg-gray-200 text-black p-2 rounded-xl rounded-bl-none">
                Tersedia kak, bisa langsung datang ke bengkel ya
            </div>

            <!-- User Message -->
            <div class="self-end max-w-[70%] bg-red-500 text-white p-2 rounded-xl rounded-br-none">
                Terima kasih
            </div>

            <!-- Admin Message -->
            <div class="self-start max-w-[70%] bg-gray-200 text-black p-2 rounded-xl rounded-bl-none">
                Sama sama
            </div>
        </div>

        <div class="mx-3 mb-3 px-4 py-2 flex items-center gap-2 rounded-full shadow-[0_2px_6px_rgba(0,0,0,0.15),0_-2px_4px_rgba(0,0,0,0.05)]">
            <input type="text" placeholder="Ketik Pesan..." class="w-full focus:outline-none">
            <button class="text-red-500">
                <i class="bx bxs-send text-xl"></i>
            </button>
        </div>
    </div>

    <!-- Chat Bubble Button -->
    <button @click="open = !open"
        class="fixed z-50 bottom-4 right-4 w-16 h-16 bg-gradient-to-r from-red-700 to-red-500 text-white rounded-full flex items-center justify-center">
        <template x-if="!open">
            <i class="fa-regular fa-comment-dots text-2xl"></i>
        </template>
        <template x-if="open">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </template>
    </button>

</div>