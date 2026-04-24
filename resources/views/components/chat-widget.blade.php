<div x-data="chatWidget()" 
     x-init="initChat()"
     class="fixed bottom-6 right-6 z-[999] font-sans">
    
    <!-- Bubble Button -->
    <button @click="isOpen = !isOpen; if(isOpen && unreadCount > 0) unreadCount = 0;" 
            class="w-16 h-16 bg-sepia-600 rounded-full shadow-2xl flex items-center justify-center text-white hover:bg-sepia-700 transition transform hover:scale-110 relative">
        <svg x-show="!isOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        <svg x-show="isOpen" style="display: none;" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        <!-- Unread Badge -->
        <span x-show="!isOpen && unreadCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white animate-bounce" x-text="unreadCount"></span>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-90"
         class="absolute bottom-20 right-0 w-80 md:w-96 bg-white rounded-3xl shadow-2xl overflow-hidden border border-earth-100 flex flex-col h-[500px]">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-sepia-600 to-earth-800 p-4 text-white flex justify-between items-center shadow-md z-10">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center border border-white/50 backdrop-blur-sm">
                        <span class="text-xl" x-text="mode === 'bot' ? '🤖' : '👩‍💼'"></span>
                    </div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-earth-800"></div>
                </div>
                <div>
                    <h3 class="font-bold text-sm tracking-wide" x-text="mode === 'bot' ? 'AI Tư Vấn (Rynna)' : 'Nhân viên Rynna'">AI Rynna Support</h3>
                    <p class="text-[10px] text-earth-100 opacity-80" x-text="mode === 'bot' ? 'Trả lời tự động tích thì' : 'Đang hỗ trợ bạn trực tiếp'"></p>
                </div>
            </div>
            <button @click="isOpen = false" class="text-white hover:text-red-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 p-4 bg-beige-50 overflow-y-auto space-y-4">
            <template x-for="msg in messages" :key="msg.id">
                <!-- Message Bubble -->
                <div :class="msg.sender === 'user' ? 'flex flex-row-reverse space-x-reverse space-x-2' : 'flex space-x-2'">
                    <!-- Avatar -->
                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center relative mt-1"
                         :class="msg.sender === 'user' ? 'bg-earth-200 text-earth-800' : (msg.sender === 'bot' ? 'bg-earth-800 text-white' : 'bg-sepia-500 text-white')">
                        <span class="text-sm" x-text="msg.sender === 'user' ? '👤' : (msg.sender === 'bot' ? '🤖' : '👩‍💼')"></span>
                    </div>
                    
                    <!-- Bubble Content -->
                    <div class="max-w-[75%] rounded-2xl px-4 py-2 text-sm leading-relaxed shadow-sm whitespace-pre-wrap"
                         :class="msg.sender === 'user' ? 'bg-earth-800 text-white rounded-tr-none' : 'bg-white text-earth-800 border border-beige-100 rounded-tl-none'"
                         x-text="msg.message">
                    </div>
                </div>
            </template>
            <div id="chat-anchor"></div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-beige-100 flex items-center space-x-2">
            <input type="text" x-model="newMessage" @keydown.enter="sendMessage()" 
                   placeholder="Nhập tin nhắn của bạn..." 
                   class="flex-1 border-0 bg-beige-50 rounded-full px-4 py-2 text-sm focus:ring-1 focus:ring-sepia-400 placeholder-earth-300">
            <button @click="sendMessage()" :disabled="!newMessage.trim() || isSending"
                    class="w-10 h-10 bg-sepia-500 hover:bg-sepia-600 rounded-full flex items-center justify-center text-white transition disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0">
                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
            </button>
        </div>
    </div>
</div>

<script>
function chatWidget() {
    return {
        isOpen: false,
        @auth
            sessionId: localStorage.getItem('rynna_chat_session') || '',
        @else
            sessionId: '', // Guest: không dùng localStorage, tự động tạo phiên mới khi F5
        @endauth
        mode: 'bot',
        messages: [],
        newMessage: '',
        isSending: false,
        pollInterval: null,
        unreadCount: 0,

        initChat() {
            this.fetchMessages();
            // Start polling every 3 seconds
            this.pollInterval = setInterval(() => {
                this.fetchMessages(true);
            }, 3000);
        },

        scrollToBottom() {
            setTimeout(() => {
                const container = document.getElementById('chat-messages');
                if(container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 100);
        },

        fetchMessages(isPolling = false) {
            fetch(`{{ url('/') }}/api/chat/messages?session_id=${this.sessionId}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.session && data.session.session_id !== this.sessionId) {
                    this.sessionId = data.session.session_id;
                    @auth
                        localStorage.setItem('rynna_chat_session', this.sessionId);
                    @endauth
                }
                
                if (data.session) {
                    this.mode = data.session.mode;
                }

                if (data.messages && data.messages.length > this.messages.length) {
                    const newCount = data.messages.length - this.messages.length;
                    
                    // If polling and closed and the new message represents bot/admin
                    if (isPolling && !this.isOpen && this.messages.length > 0) {
                        const latestSender = data.messages[data.messages.length-1].sender;
                        if (latestSender !== 'user') {
                            this.unreadCount += newCount;
                        }
                    }
                    
                    this.messages = data.messages;
                    if(this.isOpen) this.scrollToBottom();
                }
            })
            .catch(err => console.error(err));
        },

        sendMessage() {
            if (!this.newMessage.trim() || this.isSending) return;
            
            const msgObj = {
                id: 'temp_' + Date.now(),
                sender: 'user',
                message: this.newMessage
            };
            this.messages.push(msgObj);
            this.scrollToBottom();
            
            const txt = this.newMessage;
            this.newMessage = '';
            this.isSending = true;

            fetch(`{{ url('/') }}/api/chat/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    session_id: this.sessionId,
                    message: txt
                })
            })
            .then(res => res.json())
            .then(data => {
                this.isSending = false;
                this.fetchMessages(); // Trigger immediate fetch to get DB saved msg and bot reply
            })
            .catch(err => {
                console.error(err);
                this.isSending = false;
            });
        }
    }
}
</script>
