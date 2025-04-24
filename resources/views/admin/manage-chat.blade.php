@extends('admin.layouts.app')

@section('title', 'Kelola Chat')

@section('content')
    <div class="h-screen flex flex-col" x-data="adminChatManager()" x-init="initialize()">
        @include('admin.components.header')

        <!-- Page title -->
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between m-4">
            <h1 class="font-semibold text-2xl">Kelola Chat Pelanggan</h1>
        </div>

        <div class="flex flex-1 overflow-hidden gap-6 min-h-0">
            <!-- Bagian Kiri - List Chat Session -->
            <div id="chat-list"
                class="w-full md:w-[40%] mx-0 md:ml-4 mb-0 md:mb-4 bg-white rounded-xl flex flex-col overflow-hidden md:overflow-visible"
                :class="{'hidden': isMobile && selectedSessionId !== null}">
                <div class="p-4">
                    <p class="text-lg font-semibold">Data Chat Pelanggan</p>
                    <p class="text-gray-600">Data chat dari pelanggan yang belum berakhir dan harus dijawab</p>
                </div>

                <!-- Chat List-->
                <div class="overflow-y-auto pb-4 flex-1">
                    <!-- Loading Indicator -->
                    <div x-show="loadingSessions" class="text-center py-4">
                        <i class="bx bx-loader-alt animate-spin text-2xl text-gray-500"></i>
                        <p class="text-gray-500">Memuat daftar chat...</p>
                    </div>

                    <!-- Chat List Container -->
                    <div x-show="!loadingSessions" class="space-y-2">
                        <template x-if="sessions.length === 0">
                            <p class="text-center text-gray-500 py-4">Tidak ada chat session aktif</p>
                        </template>
                        
                        <template x-for="session in sessions" :key="session.id">
                            <div @click="loadChat(session.id)"
                                class="hover:bg-gray-100 mx-4 cursor-pointer py-2 border-b-2 border-gray-300"
                                :class="{
                                    'bg-gray-100': session.id === selectedSessionId,
                                    'opacity-70': isSessionExpired(session.expired_at)
                                }">
                                <div class="flex justify-between items-start">
                                    <p class="text-lg font-semibold" x-text="`Chat Session ID: ${session.id}`"></p>
                                </div>
                                <p class="text-gray-600 line-clamp-1" x-text="session.last_message || 'Belum ada pesan'"></p>
                                <template x-if="isSessionExpired(session.expired_at)">
                                    <p class="text-xs text-red-500">Session telah berakhir</p>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan - Chat Room -->
            <div id="chat-room"
                class="w-full md:w-[60%] mx-0 md:mr-4 mb-0 md:mb-4 p-4 bg-chat-admin bg-no-repeat bg-cover rounded-xl flex flex-col min-h-0"
                :class="{'hidden': selectedSessionId === null}">
                <!-- Back Button (mobile only) -->
                <div class="md:hidden mb-4" x-show="isMobile && selectedSessionId !== null">
                    <button @click="goBackToList()" class="text-blue-600 hover:underline">
                        Kembali ke daftar chat
                    </button>
                </div>

                <!-- Chat Header -->
                <div class="mb-4">
                    <h2 class="text-lg font-semibold" x-text="`Chat Session ID: ${selectedSessionId || ''}`"></h2>
                    <div x-show="selectedSession">
                        <p class="text-gray-500" x-show="isSessionExpired(selectedSession?.expired_at)">
                            <span class="text-red-500" x-text="`Session telah berakhir pada ${formatDateTime(selectedSession?.expired_at)}`"></span>
                        </p>
                        <p class="text-gray-500" x-show="!isSessionExpired(selectedSession?.expired_at)">
                            <span x-text="`Session aktif sampai ${formatDateTime(selectedSession?.expired_at)}`"></span>
                        </p>
                    </div>
                </div>

                <!-- Chat Messages Area-->
                <div class="flex-1 overflow-y-auto space-y-4 min-h-0" x-ref="messagesContainer">
                    <!-- Loading Indicator -->
                    <div x-show="loadingMessages" class="text-center py-4">
                        <i class="bx bx-loader-alt animate-spin text-2xl text-gray-500"></i>
                        <p class="text-gray-500">Memuat pesan...</p>
                    </div>

                    <!-- Empty State -->
                    <template x-if="!loadingMessages && messages.length === 0">
                        <p class="text-gray-500 text-center py-4">Belum ada pesan pada session ini</p>
                    </template>
                    
                    <!-- Messages -->
                    <template x-for="(message, index) in messages" :key="index">
                        <div class="flex mb-4" :class="message.sender === 'Admin' ? 'justify-end' : 'justify-start'">
                            <div class="py-2 px-4 max-w-xs shadow-sm rounded-lg"
                                :class="message.sender === 'Admin' ? 'bg-red-200' : 'bg-[#F2F2F2]'">
                                <p x-text="message.content"></p>
                                <span class="text-xs text-black block text-right mt-1" x-text="formatTime(message.created_at)"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Chat Input Area -->
                <div class="mt-4 flex items-center gap-2 md:gap-6">
                    <input x-model="newMessage" @keyup.enter="sendMessage()" type="text" placeholder="Ketik pesan balasan disini..."
                        class="flex-1 border border-gray-400 bg-transparent rounded-lg p-2" />
                    <button @click="sendMessage()" class="bg-gray-800 hover:bg-gray-900 text-white px-4 md:px-8 py-2 rounded-lg"
                        :disabled="sending">
                        <span class="hidden md:inline" x-show="!sending">Balas</span>
                        <i class="fa-regular fa-paper-plane text-white text-lg block md:hidden" x-show="!sending"></i>
                        <i class="bx bx-loader-alt animate-spin text-white text-lg" x-show="sending"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function adminChatManager() {
            return {
                sessions: [],
                messages: [],
                selectedSessionId: null,
                selectedSession: null,
                newMessage: '',
                loadingSessions: true,
                loadingMessages: false,
                sending: false,
                isMobile: window.innerWidth < 768,
                pusher: null,
                
                initialize() {
                    this.loadChatSessions();
                    this.setupPusher();
                    this.setupEventListeners();
                    
                    // Check URL hash for direct chat loading
                    if (window.location.hash.startsWith('#chat-')) {
                        const sessionId = parseInt(window.location.hash.replace('#chat-', ''));
                        if (!isNaN(sessionId)) {
                            this.loadChat(sessionId);
                        }
                    }
                },
                
                setupPusher() {
                    this.pusher = new Pusher('{{ $pusherKey }}', {
                        cluster: '{{ $pusherCluster }}',
                        encrypted: true,
                        forceTLS: true,
                    });
                    
                    // Subscribe to general channel for session updates
                    const channel = this.pusher.subscribe('chat.updates');
                    
                    channel.bind('new-session', (data) => {
                        // Refresh session list when new chat comes in
                        this.loadChatSessions();
                    });
                },
                
                listenForMessages(sessionId) {
                    const messageChannel = this.pusher.subscribe('chat.' + sessionId);
                    
                    messageChannel.bind('new-message', (data) => {
                        // Only add message if sender is not admin
                        if (data.sender !== 'Admin' && this.selectedSessionId === sessionId) {
                            this.messages.push({
                                content: data.message,
                                sender: data.sender || 'Pelanggan',
                                created_at: new Date()
                            });
                            
                            // Update last message in session list
                            const sessionIndex = this.sessions.findIndex(s => s.id === sessionId);
                            if (sessionIndex !== -1) {
                                this.sessions[sessionIndex].last_message = data.message;
                            }
                            
                            // Scroll to bottom
                            this.$nextTick(() => {
                                this.scrollToBottom();
                            });
                        }
                    });
                },
                
                setupEventListeners() {
                    // Handle window resize
                    window.addEventListener('resize', () => {
                        this.isMobile = window.innerWidth < 768;
                    });

                    // Handle popstate (tombol back)
                    window.addEventListener('popstate', (event) => {
                        if (!(event.state && event.state.chatOpen)) {
                            this.goBackToList();
                        }
                    });
                },
                
                loadChatSessions() {
                    this.loadingSessions = true;
                    
                    $.ajax({
                        url: '/api/chat-sessions',
                        method: 'GET',
                        success: (data) => {
                            this.sessions = data.data || [];
                            this.loadingSessions = false;
                        },
                        error: (xhr, status, error) => {
                            console.error('Error loading chat sessions:', error);
                            this.loadingSessions = false;
                        }
                    });
                },
                
                loadChat(sessionId) {
                    this.selectedSessionId = sessionId;
                    this.loadingMessages = true;
                    this.messages = [];
                    
                    // Find selected session
                    this.selectedSession = this.sessions.find(s => s.id === sessionId);
                    
                    // Listen for new messages
                    this.listenForMessages(sessionId);
                    
                    // Update URL hash
                    history.pushState({ chatOpen: true }, '', `#chat-${sessionId}`);
                    
                    $.ajax({
                        url: `/api/chat-by-session/${sessionId}`,
                        method: 'GET',
                        success: (data) => {
                            this.messages = data.data || [];
                            this.loadingMessages = false;
                            
                            this.$nextTick(() => {
                                this.scrollToBottom();
                            });
                        },
                        error: (xhr, status, error) => {
                            console.error('Error loading messages:', error);
                            this.loadingMessages = false;
                        }
                    });
                },
                
                sendMessage() {
                    if (!this.selectedSessionId || !this.newMessage.trim()) return;
                    
                    const message = this.newMessage.trim();
                    this.sending = true;
                    
                    $.ajax({
                        url: '/api/chat',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            sender: 'Admin',
                            content: message,
                            id_chat_sessions: this.selectedSessionId
                        },
                        success: (data) => {
                            // Add message to UI
                            this.messages.push({
                                content: message,
                                sender: 'Admin',
                                created_at: new Date()
                            });
                            
                            // Clear input
                            this.newMessage = '';
                            
                            // Update last message in session list
                            const sessionIndex = this.sessions.findIndex(s => s.id === this.selectedSessionId);
                            if (sessionIndex !== -1) {
                                this.sessions[sessionIndex].last_message = message;
                            }
                            
                            this.$nextTick(() => {
                                this.scrollToBottom();
                            });
                        },
                        error: (xhr, status, error) => {
                            console.error('Error sending message:', error);
                            alert('Gagal mengirim pesan. Silakan coba lagi.');
                        },
                        complete: () => {
                            this.sending = false;
                        }
                    });
                },
                
                goBackToList() {
                    this.selectedSessionId = null;
                    this.selectedSession = null;
                    this.messages = [];
                    history.pushState(null, '', window.location.pathname);
                },
                
                scrollToBottom() {
                    if (this.$refs.messagesContainer) {
                        this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                    }
                },
                
                isSessionExpired(expiredAt) {
                    if (!expiredAt) return false;
                    return new Date(expiredAt) < new Date();
                },
                
                formatTime(dateStr) {
                    const date = new Date(dateStr);
                    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                },
                
                formatDateTime(dateStr) {
                    if (!dateStr) return '';
                    const date = new Date(dateStr);
                    return date.toLocaleString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            };
        }
    </script>
@endsection