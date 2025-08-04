<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;

/**
 * Класс для отправки сообщений в WhatsApp через Green API.
 */
class WhatsAppSender
{
    private string $apiUrl;
    private string $instanceId;
    private string $apiToken;
    private string $defaultGroup;

    /**
     * Инициализирует объект с настройками Green API.
     *
     * @throws \Exception Если отсутствуют обязательные переменные окружения.
     */
    public function __construct()
    {
        $this->instanceId = env('GREEN_API_ID', '1105295497');
        $this->apiToken = env('GREEN_API_TOKEN', '6b1930d911d546458e81adb57fecbc495b4d99b01c254166b6');
        $this->defaultGroup = env('WHATSAPP_GROUP_ID', '120363419130378884') . '@g.us';

        if (!$this->instanceId || !$this->apiToken || !$this->defaultGroup) {
            throw new \Exception('Отсутствует конфигурация для WhatsApp.');
        }

        $this->apiUrl = 'https://1105.api.green-api.com';
    }

    /**
     * Отправляет сообщение в WhatsApp (в группу по умолчанию или указанный чат).
     *
     * @param string $message Текст сообщения
     * @param string|null $chatId ID чата, если не указан — используется группа по умолчанию
     * @return bool Успешность отправки
     */
    public function send(string $message, ?string $chatId = null): bool
    {
        $targetChatId = $chatId ?: $this->defaultGroup;
        $url = "{$this->apiUrl}/waInstance{$this->instanceId}/sendMessage/{$this->apiToken}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($url, [
                'chatId' => $targetChatId,
                'message' => $message
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}