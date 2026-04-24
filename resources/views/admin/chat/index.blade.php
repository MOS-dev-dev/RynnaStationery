<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý Hỗ trợ Trực tuyến (Chat)') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="adminChat()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex border border-gray-200" style="height: 70vh;">
                <!-- Sidebar: Danh sách phiên chat -->
                <div class="w-1/3 border-r border-gray-200 bg-gray-50 flex flex-col">
                    <div class="p-4 border-b border-gray-200 bg-white">
                        <h3 class="font-bold text-gray-700">Khách hàng đang Online</h3>
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        @foreach($sessions as $session)
                            <div @click="loadSession('{{ $session->id }}')" 
                                 class="p-4 border-b border-gray-200 cursor-pointer hover:bg-sepia-50 transition"
                                 :class="activeSessionId === {{ $session->id }} ? 'bg-sepia-100 border-l-4 border-sepia-600' : 'bg-white'">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="font-bold text-sm text-gray-800">Khách #{{ substr($session->session_id, -5) }}</span>
                                    <span class="text-[10px] uppercase font-bold px-2 py-1 rounded"
                                          class="{{ $session->mode === 'bot' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' }}">
                                        {{ $session->mode === 'bot' ? 'AI Support' : 'Live' }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ $session->messages->first()->message ?? 'Phiên chat mới khởi tạo...' }}
                                </p>
                                @php
                                    $unread = $session->messages->where('sender', 'user')->where('is_read', false)->count();
                                @endphp
                                @if($unread > 0)
                                    <span class="inline-block mt-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unread }} tin mới</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Main Chat Area -->
                <div class="w-2/3 flex flex-col bg-white">
                    <template x-if="!activeSessionId">
                        <div class="flex-1 flex items-center justify-center text-gray-400">
                            <p>Chọn một khách hàng bên trái để bắt đầu hỗ trợ</p>
                        </div>
                    </template>
                    
                    <template x-if="activeSessionId">
                        <div class="flex-1 flex flex-col h-full">
                            <!-- Header -->
                            <div class="p-4 border-b border-gray-200 bg-white flex justify-between items-center shadow-sm z-10">
                                <div>
                                    <h3 class="font-bold text-gray-800">Phiên hỗ trợ #<span x-text="activeSessionId"></span></h3>
                                    <p class="text-xs text-gray-500">Chế độ hiện tại: <span class="font-bold uppercase" x-text="activeMode" :class="activeMode === 'bot' ? 'text-blue-600' : 'text-green-600'"></span></p>
                                </div>
                                <div>
                                    <button @click="toggleMode()" class="px-4 py-2 text-sm font-bold border rounded-md transition"
                                            :class="activeMode === 'bot' ? 'bg-blue-50 text-blue-600 border-blue-200 hover:bg-blue-100' : 'bg-green-50 text-green-600 border-green-200 hover:bg-green-100'">
                                        <span x-text="activeMode === 'bot' ? 'TIẾP QUẢN (Vô hiệu hoá AI)' : 'BẬT LẠI AI'"></span>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Messages -->
                            <div id="admin-chat-messages" class="flex-1 p-6 bg-gray-50 overflow-y-auto space-y-4">
                                <template x-for="msg in messages" :key="msg.id">
                                    <div :class="msg.sender !== 'user' ? 'flex flex-row-reverse space-x-reverse space-x-2' : 'flex space-x-2'">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs"
                                             :class="msg.sender === 'user' ? 'bg-gray-300 text-gray-700' : (msg.sender === 'bot' ? 'bg-blue-600 text-white' : 'bg-green-600 text-white')">
                                            <span x-text="msg.sender === 'user' ? 'KH' : (msg.sender === 'bot' ? 'AI' : 'AD')"></span>
                                        </div>
                                        
                                        <!-- Bubble -->
                                        <div class="max-w-[70%] rounded-2xl px-4 py-3 text-sm leading-relaxed whitespace-pre-wrap shadow-sm"
                                             :class="msg.sender !== 'user' ? (msg.sender === 'bot' ? 'bg-blue-50 text-blue-900 rounded-tr-none border border-blue-100' : 'bg-green-600 text-white rounded-tr-none') : 'bg-white text-gray-800 border border-gray-200 rounded-tl-none'">
                                            <span x-text="msg.message"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Input Bar -->
                            <div class="p-4 bg-white border-t border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <input type="text" x-model="newMessage" @keydown.enter="sendMessage()" 
                                           placeholder="Nhập tin nhắn để trả lời khách hàng..." 
                                           class="flex-1 border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:ring-green-500 focus:border-green-500">
                                    <button @click="sendMessage()" :disabled="!newMessage.trim() || isSending"
                                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-bold disabled:opacity-50 transition flex items-center">
                                        GỬI
                                    </button>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 italic">*Khi admin nhắn tin, Trợ lý ảo AI sẽ tự động ngừng can thiệp vào cuộc hội thoại này.</p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script>
    function adminChat() {
        return {
            activeSessionId: null,
            activeMode: '',
            messages: [],
            newMessage: '',
            isSending: false,
            pollInterval: null,

            init() {
                // Poll the currently opened conversation
                this.pollInterval = setInterval(() => {
                    if (this.activeSessionId) {
                        this.fetchMessages();
                    } else {
                        // Refresh page occasionally to get new sessions
                        // window.location.reload(); 
                    }
                }, 3000);
            },

            loadSession(id) {
                this.activeSessionId = id;
                this.fetchMessages(true);
            },

            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('admin-chat-messages');
                    if(container) container.scrollTop = container.scrollHeight;
                }, 100);
            },

            fetchMessages(isInitial = false) {
                fetch(`{{ url('/') }}/admin/chat/${this.activeSessionId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.session) {
                        this.activeMode = data.session.mode;
                    }
                    if (data.messages && data.messages.length > this.messages.length) {
                        this.messages = data.messages;
                        this.scrollToBottom();
                        
                        // If it's an initial load, clear the red badge on the left side by reloading the page safely
                        // However, we just manipulate the DOM here or ignore it until hard refresh to keep it simple
                    } else if (isInitial) {
                        this.messages = data.messages;
                        this.scrollToBottom();
                    }
                })
                .catch(err => console.error(err));
            },

            sendMessage() {
                if (!this.newMessage.trim() || this.isSending) return;
                
                const txt = this.newMessage;
                this.newMessage = '';
                this.isSending = true;

                // Optimistic UI
                this.messages.push({
                    id: 'temp',
                    sender: 'admin',
                    message: txt
                });
                this.scrollToBottom();

                fetch(`{{ url('/') }}/admin/chat/${this.activeSessionId}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: txt })
                })
                .then(res => res.json())
                .then(data => {
                    this.isSending = false;
                    if(data.mode) this.activeMode = data.mode;
                    this.fetchMessages();
                })
                .catch(() => { this.isSending = false; });
            },

            toggleMode() {
                fetch(`{{ url('/') }}/admin/chat/${this.activeSessionId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.activeMode = data.mode;
                });
            }
        }
    }
    </script>
</x-app-layout>
