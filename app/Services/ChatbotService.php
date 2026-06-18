<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    protected string $apiKey;
    protected string $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY'));
    }

    /**
     * Send message to Gemini AI and get response
     */
    public function sendMessage(string $message, array $context = []): string
    {
        if (!$this->apiKey) {
            return $this->getFallbackResponse($message);
        }

        try {
            $response = Http::post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $this->buildPrompt($message, $context)
                            ]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $this->parseResponse($data);
            }

            Log::error('Gemini API error', ['status' => $response->status(), 'body' => $response->body()]);
            return $this->getFallbackResponse($message);

        } catch (\Exception $e) {
            Log::error('Gemini API exception', ['message' => $e->getMessage()]);
            return $this->getFallbackResponse($message);
        }
    }

    /**
     * Build prompt with context for pet shop assistant
     */
    private function buildPrompt(string $message, array $context = []): string
    {
        $systemPrompt = "Bạn là trợ lý ảo của Rynna Pet Shop - cửa hàng chuyên cung cấp phụ kiện thú cưng. 
        Hãy trả lời thân thiện, nhiệt tình và chuyên nghiệp. 
        Sản phẩm chính: thức ăn, đồ chơi, vòng cổ, chuồng, sữa tắm cho chó mèo.
        Chính sách: Freeship đơn từ 500k, bảo hành 30 ngày, đổi trả trong 7 ngày.
        Giờ làm việc: 8:00 - 21:00 tất cả các ngày trong tuần.";

        $contextInfo = '';
        if (!empty($context['products'])) {
            $contextInfo .= "\nSản phẩm liên quan:\n";
            foreach ($context['products'] as $product) {
                $contextInfo .= "- {$product['name']}: " . number_format($product['price']) . "đ\n";
            }
        }

        if (!empty($context['cart_total'])) {
            $contextInfo .= "\nTổng giỏ hàng: " . number_format($context['cart_total']) . "đ";
        }

        return "{$systemPrompt}\n{$contextInfo}\n\nKhách hàng hỏi: {$message}\n\nHãy trả lời ngắn gọn (tối đa 150 từ), hữu ích và khuyến khích mua hàng.";
    }

    /**
     * Parse Gemini API response
     */
    private function parseResponse(array $data): string
    {
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return $data['candidates'][0]['content']['parts'][0]['text'];
        }

        return "Xin lỗi, tôi chưa hiểu câu hỏi của bạn. Bạn có thể hỏi về sản phẩm, giá cả, hoặc chính sách của Rynna Pet Shop.";
    }

    /**
     * Fallback response when AI is unavailable
     */
    private function getFallbackResponse(string $message): string
    {
        $message = strtolower($message);
        
        if (str_contains($message, 'giá') || str_contains($message, 'bao nhiêu')) {
            return "Giá sản phẩm tại Rynna Pet Shop rất cạnh tranh! Bạn vui lòng xem chi tiết trên từng sản phẩm hoặc để lại số điện thoại, chúng tôi sẽ tư vấn cụ thể ạ.";
        }
        
        if (str_contains($message, 'ship') || str_contains($message, 'giao hàng') || str_contains($message, 'phí vận chuyển')) {
            return "Rynna Pet Shop freeship cho đơn hàng từ 500.000đ. Phí ship nội thành Hà Nội là 30k, ngoại thành 45k. Đơn hàng được giao trong 2-3 ngày làm việc ạ.";
        }
        
        if (str_contains($message, 'đổi trả') || str_contains($message, 'bảo hành')) {
            return "Chúng tôi hỗ trợ đổi trả trong 7 ngày và bảo hành 30 ngày cho tất cả sản phẩm. Sản phẩm phải còn nguyên tem mác và chưa qua sử dụng ạ.";
        }
        
        if (str_contains($message, 'mở cửa') || str_contains($message, 'giờ làm')) {
            return "Rynna Pet Shop mở cửa từ 8:00 - 21:00 tất cả các ngày trong tuần. Ghé thăm cửa hàng hoặc đặt hàng online đều được hỗ trợ nhiệt tình ạ!";
        }

        return "Cảm ơn bạn đã quan tâm đến Rynna Pet Shop! Để được tư vấn chi tiết hơn, vui lòng để lại thông tin hoặc gọi hotline 09xx.xxx.xxx. Chúng tôi luôn sẵn sàng hỗ trợ! 🐾";
    }

    /**
     * Get suggested products based on query
     */
    public function getSuggestedProducts(string $query): array
    {
        // This would integrate with ProductService in a real implementation
        return [];
    }
}
