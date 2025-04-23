<div x-data="chatWindow()" x-cloak>

    <!-- Chat Window -->
    <div x-show="open" x-transition
        class="fixed flex flex-col bottom-24 right-4 w-80 md:w-[350px] h-[70svh] rounded-2xl bg-white overflow-hidden z-40 shadow-[0_3px_6px_rgba(0,0,0,0.12),3px_0_6px_rgba(0,0,0,0.06),-3px_0_6px_rgba(0,0,0,0.06)]">
        <div class="bg-red-700 text-white p-3 font-bold text-center">
            Admin
        </div>

        <div class="p-3 flex flex-1 flex-col gap-2 overflow-y-auto" x-ref="messagesContainer">
            <template x-for="(message, index) in messages" :key="index">
                <div :class="{
                    'self-end max-w-[70%] bg-red-500 text-white p-2 rounded-xl rounded-br-none': message.sender === 'Pelanggan',
                    'self-start max-w-[70%] bg-gray-200 text-black p-2 rounded-xl rounded-bl-none': message.sender === 'Admin'
                }" x-text="message.content">
                </div>
            </template>
            
            <div x-show="loading" class="self-center text-gray-500">
                Memuat pesan...
            </div>
        </div>

        <div class="mx-3 mb-3 px-4 py-2 flex items-center gap-2 rounded-full shadow-[0_2px_6px_rgba(0,0,0,0.15),0_-2px_4px_rgba(0,0,0,0.05)]">
            <input x-model="newMessage" @keyup.enter="sendMessage" type="text" placeholder="Ketik Pesan..." class="w-full focus:outline-none">
            <button @click="sendMessage" class="text-red-500" :disabled="sending">
                <template x-if="!sending">
                    <i class="bx bxs-send text-xl"></i>
                </template>
                <template x-if="sending">
                    <i class="bx bx-loader-alt text-xl animate-spin"></i>
                </template>
            </button>
        </div>
    </div>

    <!-- Chat Bubble Button -->
    <button @click="toggleChat"
        class="fixed z-50 bottom-4 right-4 w-16 h-16 bg-gradient-to-r from-red-700 to-red-500 text-white rounded-full flex items-center justify-center">
        <template x-if="!open">
            <i class="fa-regular fa-comment-dots text-2xl"></i>
        </template>
        <template x-if="open">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </template>
    </button>

</div>

<script>
function chatWindow() {
    return {
        open: false,
        messages: [],
        newMessage: '',
        sessionId: localStorage.getItem('chat_session_id') || null,
        loading: false,
        sending: false,
        
        toggleChat() {
            this.open = !this.open;
            if (this.open && this.sessionId) {
                this.loadMessages();
            }
        },
        
        loadMessages() {
            if (!this.sessionId) return;
            
            this.loading = true;
            $.ajax({
                url: `/api/chat-by-session/${this.sessionId}`,
                method: 'GET',
                contentType: 'application/json',
                success: (data) => {
                    if (data.data) {
                        this.messages = data.data;
                        this.$nextTick(() => {
                            this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                        });
                    }
                },
                error: (xhr, status, error) => {
                    // Jika session tidak valid, hapus dari localStorage
                    localStorage.removeItem('chat_session_id');
                    this.sessionId = null;
                },
                complete: () => {
                    this.loading = false;
                }
            });
        },

        initRealtime() {
            if (!this.sessionId) return;
            
            const channel = pusher.subscribe(`chat.session.${this.sessionId}`);
            
            channel.bind('new.message', (data) => {
                if (data.chat.sender !== 'Pelanggan') {
                    this.messages.push({
                        sender: data.chat.sender,
                        content: data.chat.content,
                        created_at: data.chat.created_at
                    });
                    
                    this.$nextTick(() => {
                        this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                    });
                }
            });
        },
        
        sendMessage() {
            if (!this.newMessage.trim()) return;
            
            this.sending = true;
            const csrfToken = $('meta[name="csrf-token"]').attr('content')
            
            $.ajax({
                url: '/api/chat',
                method: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: JSON.stringify({
                    sender: 'Pelanggan',
                    content: this.newMessage,
                    id_chat_sessions: this.sessionId
                }),
                success: (data) => {
                    // Update session ID jika baru dibuat
                    if (data.session_id && !this.sessionId) {
                        this.sessionId = data.session_id;
                        localStorage.setItem('chat_session_id', data.session_id);
                        this.initRealtime();
                    }
                    
                    // Tambahkan pesan baru ke daftar pesan
                    this.messages.push({
                        sender: 'Pelanggan',
                        content: this.newMessage
                    });
                    
                    // Kosongkan input
                    this.newMessage = '';
                    
                    // Scroll ke bawah
                    this.$nextTick(() => {
                        this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
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
        }
    }
}
</script>