<?php

require_once __DIR__ . "/vendor/autoload.php";

use app\components\Bot;
use app\components\Telegram;

$data = Telegram::getInputData();
//if (!$data['message']['chat_id'] || $data['message']['chat_id'] !== Telegram::CHAT_ID ) {
//    exit();
//}

if (isset($data['message'])) {
    if ($data['message']['chat']['id'] !== Telegram::CHAT_ID) {
        exit();
    }

    Bot::processMessage($data['message']);

} elseif (isset($data['callback_query'])) {
    if ($data['callback_query']['message']['chat']['id'] !== Telegram::CHAT_ID) {
        exit();
    }

    Bot::processCallback($data['callback_query']);
}

file_put_contents(__DIR__ . '/logs.log', print_r($data, 1), FILE_APPEND);
