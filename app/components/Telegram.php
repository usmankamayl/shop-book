<?php

namespace app\components;

class Telegram
{
    const API_TOKEN = '6470002746:AAF_7EWLMUYExFFdsAaXn1qr5Jae9HCjXAI';
    const CHAT_ID = 654038901;
    public static function getInputData()
    {
        $input = file_get_contents('php://input');
        if ($input) {
            return json_decode($input, true);
        }

        return 'Bot dont work';
    }

    public static function apiRequest($method, $params)
    {
        $url = 'https://api.telegram.org/bot' . self::API_TOKEN . '/' . $method;
        $sh = curl_init();
        curl_setopt($sh, CURLOPT_URL, $url);
        curl_setopt($sh, CURLOPT_POST, true);
        curl_setopt($sh, CURLOPT_POSTFIELDS, $params);
        curl_setopt($sh, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($sh, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($sh, CURLOPT_HEADER, false);
        curl_setopt($sh, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($sh, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($sh, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($sh);
        curl_close($sh);

        return json_decode($result, true);
    }

    public static function sendMessage($text, $keyboard=null): void
    {
        $params = [
          'chat_id' => static::CHAT_ID,
          'text' => $text
        ];

        if ($keyboard) {
            $reply_markup = [
                'inline_keyboard' => $keyboard
            ];

            $params['reply_markup'] = json_encode($reply_markup);
        }

        static::apiRequest('sendMessage', $params);
    }

    public static function editMessageKeyboard($message_id, $keyboard=null): void
    {
        $params = [
            'chat_id' => static::CHAT_ID,
            'message_id' => $message_id
        ];

        if ($keyboard) {
            $reply_markup = [
                'inline_keyboard' => $keyboard
            ];

            $params['reply_markup'] = json_encode($reply_markup);
        }

        static::apiRequest('editMessageReplyMarkup', $params);
    }

    public static function answerCallbackQuery($callback_query_id)
    {
        $params = [
            'callback_query_id' => $callback_query_id,
        ];

        static::apiRequest('answerCallbackQuery', $params);
    }

    public static function deleteMessage(mixed $message_id)
    {
        $params = [
            'chat_id' => static::CHAT_ID,
            'message_id' => $message_id
        ];
        static::apiRequest('deleteMessage', $params);
    }
}
