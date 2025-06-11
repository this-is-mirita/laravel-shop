<?php

namespace App\Logging\Telegram;

use App\Services\Telegram\TalegramBotAPI;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chat_id;
    protected string $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        parent::__construct($level);

        $this->chat_id = (int) $config['chat_id'];
        $this->token = $config['token'];
    }
    protected function getLevelIcon(string $level): string
    {
        $icons = [
            'DEBUG' => '🐛',
            'INFO' => 'ℹ️',
            'NOTICE' => '📝',
            'WARNING' => '⚠️',
            'ERROR' => '❌',
            'CRITICAL' => '🔥',
            'ALERT' => '🚨',
            'EMERGENCY' => '💥',
        ];

        return $icons[$level] ?? '📌';
    }
    protected function write(LogRecord $record): void
    {
        $data = $record->toArray();
        //dd($data);
        $icon = $this->getLevelIcon($data['level_name']);

        $message = "{$icon} {$data['level_name']}: {$data['message']}\n";
        $message .= "⏰ " . $data['datetime']->format('Y-m-d H:i:s') . "\n";

        if (!empty($data['context'])) {
            $message .= "📌 Контекст:\n" . json_encode($data['context'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        app(TalegramBotAPI::class)->sendMessage(
            $this->token,
            $this->chat_id,
            $message
        );

    }
}
