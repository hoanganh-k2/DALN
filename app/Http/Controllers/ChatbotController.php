<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }
    public function index()
    {
        return view('chatbot');
    }
    public function sendMessage(Request $request)
    {
        $userMessage = trim($request->input('message'));

        if (empty($userMessage)) {
            return response()->json(['message' => 'Vui lòng nhập tin nhắn.']);
        }

        // 🎯 Bối cảnh chatbot quản lý khách sạn
        $context = "Bạn là Phenikaa Hotel AI, trợ lý ảo của hệ thống quản lý khách sạn Phenikaa Hotel.
Nhiệm vụ của bạn là hỗ trợ khách hàng và nhân viên:
- Hỗ trợ đặt phòng, tra cứu phòng trống, báo giá, giờ nhận/trả phòng.
- Giới thiệu dịch vụ: nhà hàng, hồ bơi, spa, gym, giặt ủi, đưa đón sân bay.
- Giải thích chính sách hủy phòng, hoàn tiền, khuyến mãi.
- Giúp nhân viên kiểm tra thông tin khách đặt, bảo trì, và quản lý dịch vụ.
Quy tắc phản hồi:
1. Luôn trả lời lịch sự, ngắn gọn, đúng trọng tâm.
2. Câu trả lời ví dụ:
   - 'Phòng còn trống không?' → Gợi ý ví dụ và đề nghị liên hệ lễ tân.
   - 'Giờ check-in/check-out?' → Check-in 14:00, Check-out 12:00.
   - 'Giá phòng?' → Standard 800.000đ, Deluxe 1.200.000đ .
   - 'Có hồ bơi/spa/ăn sáng không?' → Có, hoạt động 6h00–21h00.
   - 'Chính sách hủy phòng?' → Hủy trước 24h kể từ ngày đặt sẽ không mất phí.
   - 'Vị trí khách sạn?' → 123 Đường Biển Xanh, Q.1, TP.HCM.
   - 'Đưa đón sân bay?' → Có, cần đặt trước 24h.
3. Nếu câu hỏi vượt khả năng → đề xuất liên hệ lễ tân qua số điện thoại 012-345-6789.
4. Luôn sử dụng tiếng Việt.
5. Chỉ trả lời các câu hỏi liên quan khách sạn và du lịch.
6. Khi bắt đầu Giới thiệu lần đầu khi bắt đầu cuộc trò chuyện 'Xin chào! Tôi là Phenikaa Hotel AI trợ lý ảo của khách sạn Phenikaa.
Tôi có thể giúp bạn đặt phòng, xem giá và tìm hiểu dịch vụ.'.";
        try {
            // 🚀 Gửi request đến Gemini API
            $response = Http::withoutVerifying()->timeout(50)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $this->apiKey,
                ])
                ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
                    'contents' => [
                        [
                            'parts' => [['text' => $context . "\n\nUser: " . $userMessage]]
                        ]

                    ],
                ]);

            $data = $response->json();
            Log::info('Gemini Hotel AI response: ', $data);

            // 🧠 Lấy phản hồi từ API
            $botResponse = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$botResponse) {
                return response()->json([
                    'message' => 'Xin lỗi, tôi chưa hiểu yêu cầu của bạn. Vui lòng thử lại.',
                    'error' => $data,
                ]);
            }

            return response()->json(['message' => $botResponse]);
        } catch (\Exception $e) {
            Log::error('Hotel Chatbot Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Hệ thống đang bận, vui lòng thử lại sau.',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
