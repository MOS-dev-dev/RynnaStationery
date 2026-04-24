<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $sessions = ChatSession::with(['messages' => function($q) {
            $q->latest();
        }])->orderBy('updated_at', 'desc')->get();
        
        return view('admin.chat.index', compact('sessions'));
    }

    public function show($id)
    {
        $session = ChatSession::with('messages')->findOrFail($id);
        
        // Đánh dấu tin nhắn user đã đọc khi admin mở
        $session->messages()->where('sender', 'user')->update(['is_read' => true]);

        return response()->json([
            'session' => $session,
            'messages' => $session->messages()->orderBy('created_at', 'asc')->get()
        ]);
    }

    public function sendMessage(Request $request, $id)
    {
        $session = ChatSession::findOrFail($id);
        $session->messages()->create([
            'sender' => 'admin',
            'message' => $request->message
        ]);
        
        // Ép đổi mode thành human khi admin nhắn
        if ($session->mode === 'bot') {
            $session->mode = 'human';
        }
        
        $session->touch();
        $session->save();
        
        return response()->json(['success' => true, 'mode' => $session->mode]);
    }

    public function toggleMode(Request $request, $id)
    {
        $session = ChatSession::findOrFail($id);
        $session->mode = $session->mode === 'bot' ? 'human' : 'bot';
        $session->save();
        
        return response()->json(['success' => true, 'mode' => $session->mode]);
    }
}
