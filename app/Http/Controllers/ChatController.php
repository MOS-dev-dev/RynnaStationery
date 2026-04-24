<?php
namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Services\AiBotService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getMessages(Request $request)
    {
        $sessionId = $request->input('session_id');
        $session = null;
        
        if (auth()->check()) {
            // Authenticated user: always fetch their unified persistent session
            $session = ChatSession::where('user_id', auth()->id())->first();
            if (!$session) {
                $session = ChatSession::create([
                    'session_id' => uniqid('user_'.auth()->id().'_'),
                    'user_id' => auth()->id(),
                    'mode' => 'bot'
                ]);
                $session->messages()->create([
                    'sender' => 'bot',
                    'message' => "Rynna Pet Shop xin chào! Hệ thống Trợ lý ảo (AI) tự động đã sẵn sàng để tư vấn sản phẩm cho bé cưng nhà bạn 🐶🐱.\nAnh/chị cần em giúp gì ạ?"
                ]);
            }
        } else {
            // Guest user: rely on frontend's temporary sessionId
            if (!$sessionId) {
                $sessionId = uniqid('guest_');
                $session = ChatSession::create([
                    'session_id' => $sessionId,
                    'user_id' => null,
                    'mode' => 'bot'
                ]);
                $session->messages()->create([
                    'sender' => 'bot',
                    'message' => "Rynna Pet Shop xin chào! Hệ thống Trợ lý ảo (AI) tự động đã sẵn sàng để tư vấn sản phẩm cho bé cưng nhà bạn 🐶🐱.\nAnh/chị cần em giúp gì ạ?"
                ]);
            } else {
                $session = ChatSession::where('session_id', $sessionId)->first();
                if (!$session) {
                    $session = ChatSession::create([
                        'session_id' => $sessionId,
                        'user_id' => null,
                        'mode' => 'bot'
                    ]);
                }
            }
        }

        // Đánh dấu tin nhắn admin là đã đọc
        $session->messages()->where('sender', 'admin')->update(['is_read' => true]);

        $messages = $session->messages()->orderBy('created_at', 'asc')->get();
        return response()->json([
            'session' => $session,
            'messages' => $messages
        ]);
    }

    public function sendMessage(Request $request, AiBotService $bot)
    {
        $sessionId = $request->input('session_id');
        $messageText = $request->input('message');

        $session = ChatSession::where('session_id', $sessionId)->first();
        if (!$session) {
            return response()->json(['error' => 'Invalid session'], 400);
        }

        // Security check: Không cho phép Guest nhắn nhầm vào Box của User và ngược lại
        if ($session->user_id !== null && auth()->id() !== $session->user_id) {
             return response()->json(['error' => 'Unauthorized'], 403);
        }

        $session->messages()->create([
            'sender' => 'user',
            'message' => $messageText
        ]);
        $session->touch(); // Update updated_at for sorting in Admin

        if ($session->mode === 'bot') {
            if (str_contains(mb_strtolower($messageText), 'nhân viên') || str_contains(mb_strtolower($messageText), 'admin') || str_contains(mb_strtolower($messageText), 'người')) {
                $session->update(['mode' => 'human']);
                $session->messages()->create([
                    'sender' => 'bot',
                    'message' => 'Hệ thống đã nhận yêu cầu. Cửa sổ chat đã được kích hoạt chế độ Nhân viên (Real-time). Lát nữa Admin bên mình sẽ trực tiếp trả lời bạn nha!'
                ]);
            } else {
                $botResponse = $bot->getResponse($messageText);
                $session->messages()->create([
                    'sender' => 'bot',
                    'message' => $botResponse
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
