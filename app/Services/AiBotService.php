<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiBotService
{
    public function getResponse($message)
    {
        $apiKey = env('GEMINI_API_KEY');

        // Bẫy lỗi: Nắm bắt khoảnh khắc Dev lười chưa gắn Key
        if (empty($apiKey)) {
            return $this->fallbackResponse($message, true);
        }

        // Bơm hồn: Lôi toàn bộ data kho hàng vào não AI
        // Giới hạn 20 sản phẩm để tránh quá tải Token Prompt
        $products = Product::where('stock', '>', 0)->take(20)->get();
        
        $productListing = "Danh sách hàng hóa Cửa hàng đang có sẵn:\n";
        foreach ($products as $p) {
            $price = number_format($p->sale_price ?? $p->price) . " VNĐ";
            $productListing .= "- " . $p->name . " (Giá: {$price}).\n";
        }

        $systemPrompt = "BỐI CẢNH (HƯỚNG DẪN DÀNH CHO AI):\n" .
                        "Bạn là Nhân viên bán hàng siêu cấp dễ thương của 'Rynna Pet Shop' (Cửa hàng chuyên cung cấp thực phẩm, phụ kiện cao cấp cho Thú cưng như Chó, Mèo).\n" .
                        "Luôn xưng 'em' và gọi khách là 'anh/chị', trả lời cục kỳ lễ phép, thân thiện và HAY THẢ EMOJI chó mèo (🐶🐱✨💕).\n" .
                        "Câu trả lời nên vô cùng Ngắn Gọn (1-3 câu), tập trung vào vấn đề.\n" .
                        $productListing . "\n" .
                        "Nhiệm vụ: Hãy tư vấn và trả lời câu hỏi của khách hàng dưới đây dựa rợp các đồ đang có bán ở kho.\n\n" .
                        "KHACH_HANG_NOI: " . $message;

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey;

        try {
            $response = Http::post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    // Extracting the pure text answer from Gemini
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
            }
            
            // Xử lý khi API trả về rác hoặc quá tải
            Log::error('Gemini API Error: ' . $response->body());
            return $this->fallbackResponse($message);

        } catch (\Exception $e) {
            Log::error('AI Bot Exception: ' . $e->getMessage());
            return $this->fallbackResponse($message);
        }
    }

    /**
     * Chế độ tự hành (Offline Auto-pilot) khi Google Gemini bị đứt cáp
     */
    private function fallbackResponse($message, $missingKey = false)
    {
        $message = mb_strtolower($message, 'UTF-8');

        // Yêu cầu gặp nhân viên
        if (strpos($message, 'nhân viên') !== false || strpos($message, 'người') !== false || strpos($message, 'admin') !== false) {
            return "Hệ thống đã nhận yêu cầu. Cửa sổ chat đã được kích hoạt chế độ Nhân viên (Real-time). Lát nữa Admin bên mình sẽ trực tiếp trả lời bạn nha!";
        }

        // Tìm kiếm sản phẩm cơ bản bằng Keyword dập khuôn
        $keywords = ['pate', 'hạt', 'thức ăn', 'chó', 'mèo', 'đồ chơi', 'xương', 'cát'];
        $foundKeyword = null;

        foreach ($keywords as $kw) {
            if (strpos($message, $kw) !== false) {
                $foundKeyword = $kw;
                break;
            }
        }

        if ($foundKeyword) {
            // Lục Data lấy 3 sản phẩm match với Keyword
            $products = Product::where('name', 'LIKE', '%' . $foundKeyword . '%')
                               ->orWhere('description', 'LIKE', '%' . $foundKeyword . '%')
                               ->take(3)
                               ->get();

            if ($products->count() > 0) {
                $reply = "Dạ chào anh/chị, em thấy mình đang quan tâm đến các sản phẩm 🐶🐱 liên quan đến '{$foundKeyword}'. Bên em đang bán các món cực Hot này ạ:\n\n";
                foreach ($products as $p) {
                    $price = number_format($p->sale_price ?? $p->price) . "đ";
                    $reply .= "✨ " . $p->name . " - Chỉ " . $price . "\n";
                }
                $reply .= "\nAnh/chị có ưng món nào hông, hay cần em xách anh nhân viên ra tư vấn trực tiếp thì nhắn 'Cho tôi nhân viên' nhé!";
                return $reply;
            }
        }
        
        // Hỏi giá cơ bản
        if (strpos($message, 'giá') !== false || strpos($message, 'bao nhiêu') !== false || strpos($message, 'tiền') !== false) {
             return "Dạ các sản phẩm bên em đều có giá công khai cực kỳ hạt dẻ được ghim trên cửa hàng ạ. Nếu anh/chị muốn tra giá cụ thể món nào, cứ gõ tên món đó (VD: 'Pate mèo', 'Hạt cho chó') em sẽ lấy bảng giá ngay cho ạ! 🐈";
        }

        // Xin chào
        if (strpos($message, 'chào') !== false || strpos($message, 'hi') !== false || strpos($message, 'hello') !== false || strpos($message, 'ê') !== false) {
             return "Dạ Rynna Pet Shop xin chào anh/chị! 🐶🐱\nEm là Trợ lí Ảo sơ cua (Do mạng vệ tinh API tổng đang quá tải). Anh chị cần tìm đồ ăn, pate, hay xương gặm cho bé cưng nào ạ?";
        }

        $reason = $missingKey ? "(Do chưa liên kết API Key Google)" : "(Do đường truyền vệ tinh Google quá tải)";
        
        return "Dạ hiện tại Cỗ máy AI siêu mượt của nhà em đang tạm phải ngủ trưa {$reason} 💤\nNhưng không sao, anh/chị nhắn 'Cho tôi nhân viên' hoặc gửi thẳng câu hỏi ở đây, lát nữa các sếp nhà em sẽ vào báo giá và tư vấn tận tình ạ! 💕";
    }
}
