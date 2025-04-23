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
                    <!-- Loading Indicator -->
                    <div id="chat-list-loading" class="text-center py-4">
                        <i class="bx bx-loader-alt animate-spin text-2xl text-gray-500"></i>
                        <p class="text-gray-500">Memuat daftar chat...</p>
                    </div>

                    <!-- Chat List Container -->
                    <div id="chat-sessions-container" class="space-y-2 hidden">
                        <!-- Data akan diisi oleh JavaScript -->
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
                <div id="chat-messages" class="flex-1 overflow-y-auto space-y-4">
                    <div id="messages-loading" class="text-center py-4 hidden">
                        <i class="bx bx-loader-alt animate-spin text-2xl text-gray-500"></i>
                        <p class="text-gray-500">Memuat pesan...</p>
                    </div>
                    <div id="messages-container" class="space-y-4">
                        <!-- Pesan akan diisi oleh JavaScript -->
                    </div>
                </div>

                <!-- Chat Input Area -->
                <div class="mt-4 flex items-center gap-2 md:gap-6">
                    <input id="message-input" type="text" placeholder="Ketik pesan balasan disini..."
                        class="flex-1 border border-gray-400 bg-transparent rounded-lg p-2" />
                    <button id="send-button" class="bg-gray-800 hover:bg-gray-900 text-white px-4 md:px-8 py-2 rounded-lg">
                        <span id="send-text" class="hidden md:inline">Balas</span>
                        <i id="send-icon" class="fa-regular fa-paper-plane text-white text-lg block md:hidden"></i>
                        <i id="sending-icon" class="bx bx-loader-alt animate-spin text-white text-lg hidden"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Variabel global
            let selectedSessionId = null;
            let sessions = [];

            // Inisialisasi
            loadChatSessions();
            setupEventListeners();

            // Fungsi untuk memuat daftar chat session
            function loadChatSessions() {
                $('#chat-list-loading').show();
                $('#chat-sessions-container').hide();

                $.ajax({
                    url: '/api/chat-sessions',
                    method: 'GET',
                    success: function (data) {
                        sessions = data.data || [];
                        renderChatSessions(sessions);
                        $('#chat-list-loading').hide();
                        $('#chat-sessions-container').show();

                        // Jika ada hash URL, load chat tersebut
                        if (window.location.hash.startsWith('#chat-')) {
                            const sessionId = parseInt(window.location.hash.replace('#chat-', ''));
                            if (!isNaN(sessionId)) {
                                loadChat(sessionId);
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error loading chat sessions:', error);
                        $('#chat-list-loading').html('<p class="text-red-500">Gagal memuat daftar chat</p>');
                    }
                });
            }

            // Fungsi untuk render daftar chat session
            function renderChatSessions(sessions) {
                const container = $('#chat-sessions-container');
                container.empty();

                if (sessions.length === 0) {
                    container.html('<p class="text-center text-gray-500 py-4">Tidak ada chat session aktif</p>');
                    return;
                }

                sessions.forEach(session => {
                    const lastMessage = session.last_message || 'Belum ada pesan';
                    const isActive = session.id === selectedSessionId ? 'bg-gray-100' : '';
                    const isExpired = new Date(session.expired_at) < new Date();

                    container.append(`
                        <div onclick="loadChat(${session.id})"
                            class="hover:bg-gray-100 mx-4 cursor-pointer py-2 border-b-2 border-gray-300 ${isActive} ${isExpired ? 'opacity-70' : ''}">
                            <div class="flex justify-between items-start">
                                <p class="text-lg font-semibold">Chat Session ID: ${session.id}</p>
                            </div>
                            <p class="text-gray-600 line-clamp-1">${lastMessage}</p>
                            ${isExpired ? '<p class="text-xs text-red-500">Session telah berakhir</p>' : ''}
                        </div>
                    `);
                });
            }

            // Fungsi untuk handle realtime
            function initPusherForAdmin(sessionId) {
                const channel = pusher.subscribe(`chat.session.${sessionId}`);

                channel.bind('new.message', (data) => {
                    if (data.chat.sender !== 'Admin') {
                        // Terima pesan baik dari admin maupun user (untuk sync)
                        const time = new Date(data.chat.created_at).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        const isAdmin = data.chat.sender === 'Admin';

                        $('#messages-container').append(`
                            <div class="flex ${isAdmin ? 'justify-end' : 'justify-start'} mb-4">
                                <div class="${isAdmin ? 'bg-red-200' : 'bg-[#F2F2F2]'} text-black rounded-lg py-2 px-4 max-w-xs shadow-sm">
                                    <p>${data.chat.content}</p>
                                    <span class="text-xs text-black block text-right mt-1">${time}</span>
                                </div>
                            </div>
                        `);
                        
                        $('#messages-container').scrollTop($('#messages-container')[0].scrollHeight);
                    }
                });

                return channel;
            }

            // Fungsi untuk memuat chat berdasarkan session ID
            window.loadChat = function (sessionId) {
                // Unsubscribe sebelumnya
                if (window.currentPusherChannel) {
                    pusher.unsubscribe(`chat.session.${selectedSessionId}`);
                }

                selectedSessionId = sessionId;

                // Update UI
                handleScreenSize();
                $('#messages-loading').show();
                $('#messages-container').hide();

                // Update URL hash
                history.pushState({ chatOpen: true }, '', `#chat-${sessionId}`);

                // Load chat messages
                $.ajax({
                    url: `/api/chat-by-session/${sessionId}`,
                    method: 'GET',
                    success: function (data) {
                        renderChatMessages(data.data);

                        // Update session info
                        const session = sessions.find(s => s.id === sessionId);
                        if (session) {
                            $('#chat-session-title').text(`Chat Session ID: ${sessionId}`);

                            const expiredDate = new Date(session.expired_at);
                            const now = new Date();
                            const isExpired = expiredDate < now;

                            if (isExpired) {
                                $('#session-expired-info').html(`
                                    <span class="text-red-500">Session telah berakhir pada ${formatDateTime(session.expired_at)}</span>
                                `);
                            } else {
                                $('#session-expired-info').html(`
                                    Session aktif sampai ${formatDateTime(session.expired_at)}
                                `);
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error loading messages:', error);
                        $('#messages-container').html(`
                            <p class="text-red-500">Gagal memuat pesan</p>
                        `).show();
                    },
                    complete: function () {
                        $('#messages-loading').hide();
                        $('#messages-container').show();
                    }
                });

                // Init realtime
                window.currentPusherChannel = initPusherForAdmin(sessionId);
            };

            // Fungsi untuk render pesan chat
            function renderChatMessages(messages) {
                const container = $('#messages-container');
                container.empty();

                if (!messages || messages.length === 0) {
                    container.html('<p class="text-gray-500 text-center py-4">Belum ada pesan pada session ini</p>');
                    return;
                }

                messages.forEach(message => {
                    const isAdmin = message.sender === 'Admin';
                    const time = formatTime(message.created_at);

                    container.append(`
                        <div class="flex ${isAdmin ? 'justify-end' : 'justify-start'} mb-4">
                            <div class="${isAdmin ? 'bg-red-200' : 'bg-[#F2F2F2]'} text-black rounded-lg py-2 px-4 max-w-xs shadow-sm">
                                <p>${message.content}</p>
                                <span class="text-xs text-black block text-right mt-1">${time}</span>
                            </div>
                        </div>
                    `);
                });

                // Scroll ke bawah
                container.scrollTop(container[0].scrollHeight);
            }

            // Fungsi untuk setup event listeners
            function setupEventListeners() {
                // Kirim pesan ketika tombol diklik atau enter ditekan
                $('#send-button').click(sendMessage);
                $('#message-input').keypress(function (e) {
                    if (e.which === 13) {
                        sendMessage();
                    }
                });

                // Handle window resize
                $(window).resize(handleScreenSize);

                // Handle popstate (tombol back)
                window.addEventListener('popstate', function (event) {
                    if (!(event.state && event.state.chatOpen)) {
                        goBackToList();
                    }
                });
            }

            // Fungsi untuk mengirim pesan
            function sendMessage() {
                if (!selectedSessionId) return;

                const message = $('#message-input').val().trim();
                if (!message) return;

                const sendButton = $('#send-button');
                const sendText = $('#send-text');
                const sendIcon = $('#send-icon');
                const sendingIcon = $('#sending-icon');

                // Tampilkan loading state
                sendButton.prop('disabled', true);
                sendText.addClass('hidden');
                sendIcon.addClass('hidden');
                sendingIcon.removeClass('hidden');

                $.ajax({
                    url: '/api/chat',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        sender: 'Admin',
                        content: message,
                        id_chat_sessions: selectedSessionId
                    },
                    success: function (data) {
                        // Tambahkan pesan ke UI
                        const time = formatTime(new Date());
                        $('#messages-container').append(`
                            <div class="flex justify-end mb-4">
                                <div class="bg-red-200 text-black rounded-lg py-2 px-4 max-w-xs shadow-sm">
                                    <p>${message}</p>
                                    <span class="text-xs text-black block text-right mt-1">${time}</span>
                                </div>
                            </div>
                        `);

                        // Kosongkan input
                        $('#message-input').val('');

                        // Scroll ke bawah
                        $('#messages-container').scrollTop($('#messages-container')[0].scrollHeight);

                        // Perbarui daftar chat session
                        const sessionIndex = sessions.findIndex(s => s.id === selectedSessionId);
                        if (sessionIndex !== -1) {
                            sessions[sessionIndex].last_message = message;
                            renderChatSessions(sessions);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error sending message:', error);
                        alert('Gagal mengirim pesan. Silakan coba lagi.');
                    },
                    complete: function () {
                        // Reset button state
                        sendButton.prop('disabled', false);
                        sendText.removeClass('hidden');
                        sendIcon.removeClass('hidden');
                        sendingIcon.addClass('hidden');
                    }
                });
            }

            // Fungsi untuk kembali ke daftar chat
            window.goBackToList = function () {
                selectedSessionId = null;
                handleScreenSize();
                history.pushState(null, '', window.location.pathname);
            };

            // Fungsi untuk menangani tampilan berdasarkan ukuran layar
            function handleScreenSize() {
                if (selectedSessionId !== null) {
                    // Jika ada chat yang dipilih
                    if (window.innerWidth < 768) {
                        // Mobile: sembunyikan daftar, tampilkan chat room
                        $('#chat-list').addClass('hidden');
                        $('#chat-room').removeClass('hidden').addClass('flex');
                    } else {
                        // Desktop: tampilkan keduanya
                        $('#chat-list').removeClass('hidden');
                        $('#chat-room').removeClass('hidden').addClass('flex');
                    }
                } else {
                    // Jika tidak ada chat yang dipilih
                    $('#chat-list').removeClass('hidden');
                    $('#chat-room').addClass('hidden').removeClass('flex');
                }
            }

            // Helper functions untuk format tanggal/waktu
            function formatTime(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }

            function formatDate(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function formatDateTime(dateStr) {
                const date = new Date(dateStr);
                return date.toLocaleString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        });
    </script>
@endsection