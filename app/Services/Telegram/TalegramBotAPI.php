<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class TalegramBotAPI
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chat_id, string $text): void
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chat_id,
                'text' => $text
            ]);

            if (!$response->successful()) {
                Log::error('Telegram API error', [
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Telegram sendMessage failed', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
