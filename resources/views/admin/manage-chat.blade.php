@extends('admin.layouts.app')

@section('title', 'Kelola Chat')

@section('content')
    <div class="h-screen flex flex-col">
        @include('admin.components.header')

        <!-- Page title -->
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between m-4">
            <h1 class="font-semibold text-2xl">Kelola Chat Pelanggan</h1>
        </div>

        <div class="flex flex-1 overflow-hidden gap-6">
            <!-- Bagian Kiri - List Chat Session -->
            <div id="chat-list"
                class="w-full md:w-[40%] mx-0 md:ml-4 mb-0 md:mb-4 bg-white rounded-xl flex flex-col overflow-hidden md:overflow-visible ">
                <div class="p-4">
                    <p class="text-lg font-semibold">Data Chat Pelanggan</p>
                    <p class="text-gray-600">Data chat dari pelanggan yang belum berakhir dan harus dijawab</p>
                </div>

                <!-- Chat List-->
                <div class="overflow-y-auto pb-4 flex-1">
                    <!-- Chat List -->
                    <div class="space-y-2">
                        @foreach($sessions as $session)
                            <div onclick="loadChat({{ $session->id }})"
                                class="hover:bg-gray-100 mx-4 cursor-pointer py-2 border-b-2 border-gray-300">
                                <p class="text-xl font-semibold">Chat Session ID: {{ $session->id }}</p>
                                <p class="text-gray-600 line-clamp-1">Berapa lama waktu yang dibutuhkan untuk memperbaiki mesin
                                    mobil saya?</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan - Chat Room -->
            <div id="chat-room"
                class="w-full md:w-[60%] mx-0 md:mr-4 mb-0 md:mb-4 p-4 bg-chat-admin bg-no-repeat bg-cover rounded-xl md:flex flex-col hidden">
                <!-- Back Button (mobile only) -->
                <div class="md:hidden mb-4">
                    <button onclick="goBackToList()" class="text-blue-600 hover:underline">
                        Kembali ke daftar chat
                    </button>
                </div>

                <!-- Chat Header -->
                <div class="mb-4">
                    <h2 class="text-lg font-semibold" id="chat-session-title">Chat Session ID: </h2>
                    <p class="text-gray-500" id="session-expired-info"></p>
                </div>

                <!-- Chat Messages Area-->
                <div id="chat-messages" class="flex-1 overflow-y-auto">
                    <div class="space-y-4">

                    </div>
                </div>

                <!-- Chat Input Area -->
                <div class="mt-4 flex items-center gap-2 md:gap-6">
                    <input type="text" placeholder="Ketik pesan balasan disini..."
                        class="flex-1 border border-gray-400 bg-transparent rounded-lg p-2" />
                    <button class="bg-gray-800 hover:bg-gray-900 text-white px-4 md:px-8 py-2 rounded-lg">
                        <p class="hidden md:block">Balas</p>
                        <i class="fa-regular fa-paper-plane text-white text-lg block md:hidden"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedSessionId = null;

        function handleScreenSize() {
            if (selectedSessionId !== null) {
                // Jika ada chat yang dipilih
                if (window.innerWidth < 768) {
                    // Di layar mobile: sembunyikan chat list, tampilkan chat room
                    document.getElementById('chat-list').classList.add('hidden');
                    document.getElementById('chat-room').classList.remove('hidden');
                    document.getElementById('chat-room').classList.add('flex');
                } else {
                    // Di layar desktop: tampilkan keduanya
                    document.getElementById('chat-list').classList.remove('hidden');
                    document.getElementById('chat-room').classList.remove('hidden');
                    document.getElementById('chat-room').classList.add('flex');
                }
            } else {
                // Jika tidak ada chat yang dipilih
                document.getElementById('chat-list').classList.remove('hidden');
                document.getElementById('chat-room').classList.add('hidden');
                document.getElementById('chat-room').classList.remove('flex');
            }
        }

        function loadChat(sessionId) {
            selectedSessionId = sessionId;

            // Tambahkan state ke history
            history.pushState({ chatOpen: true }, '', `#chat-${sessionId}`);

            // Tampilkan chat room berdasarkan ukuran layar
            handleScreenSize();


            fetch(`/kelola-chat/session/${sessionId}`)
                .then(res => res.json())
                .then(data => {
                    const chatContainer = document.getElementById('chat-messages');
                    const sessionTitle = document.getElementById('chat-session-title');
                    const expiredInfo = document.getElementById('session-expired-info');

                    // Set judul session ID
                    sessionTitle.innerText = `Chat Session ID: ${sessionId}`;

                    // Set tanggal expired
                    if (data.expired_at) {
                        const expiredDate = new Date(data.expired_at);
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        expiredInfo.innerText = `Chat berakhir pada ${expiredDate.toLocaleDateString('id-ID', options)}`;
                    } else {
                        expiredInfo.innerText = '';
                    }

                    let html = `<div class="space-y-4">`;

                    if (data.chats.length === 0) {
                        html += `<p class="text-gray-500">Belum ada pesan pada session ini.</p>`;
                    }

                    data.chats.forEach(chat => {
                        if (chat.sender === 'admin') {
                            html += `
                                <div class="flex justify-end mb-4">
                                    <div class="bg-red-200 text-black rounded-lg py-2 px-4 max-w-xs">
                                        <p>${chat.content}</p>
                                        <span class="text-xs text-black block text-right mt-1">${formatTime(chat.created_at)}</span>
                                    </div>
                                </div>`;
                        } else {
                            html += `
                                <div class="flex mb-4">
                                    <div class="bg-[#F2F2F2] text-black rounded-lg py-2 px-4 max-w-xs shadow-sm">
                                        <p>${chat.content}</p>
                                        <span class="text-xs text-black block text-right mt-1">${formatTime(chat.created_at)}</span>
                                    </div>
                                </div>`;
                        }
                    });

                    html += `</div>`;
                    chatContainer.innerHTML = html;
                });
        }

        // Tambahkan event listener untuk resize window
        window.addEventListener('resize', handleScreenSize);

        function goBackToList() {
            selectedSessionId = null;

            // Perbarui tampilan
            handleScreenSize();

            // Perbaiki history
            history.pushState(null, '', window.location.pathname);
        }

        function formatTime(datetimeStr) {
            const date = new Date(datetimeStr);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }

        // Handle tombol back
        window.addEventListener('popstate', function (event) {
            if (event.state && event.state.chatOpen) {
                // Jika back ke chat room, biarkan (tidak perlu apa-apa)
            } else {
                // Jika tidak ada state, artinya kembali ke daftar chat
                goBackToList();
            }
        });

        // Pastikan tampilan sesuai saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada hash URL #chat-X
            if (window.location.hash.startsWith('#chat-')) {
                const sessionId = parseInt(window.location.hash.replace('#chat-', ''));
                if (!isNaN(sessionId)) {
                    loadChat(sessionId);
                }
            } else {
                handleScreenSize(); // Pastikan layout awal benar
            }
        });

    </script>

@endsection