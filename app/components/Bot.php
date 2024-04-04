<?php

namespace app\components;

use app\models\Orders;

class Bot
{
    public static function processMessage($message)
    {
        if (preg_match('~^/([a-z]+)(?:[\s_]+(.+))?$~', $message['text'], $matches)) {
            $command = $matches[1];
            if (isset($matches[2])) {
                $params = preg_split('~[\s_]+~', $matches[2]);
            } else {
                $params = [];
            }

            switch ($command) {
                case 'order':
                    if (!$params) {
                        Telegram::sendMessage('Необходимо указать ID заказа');
                        return;
                    }
                    $order = Orders::one($params[0]);
                    if (!$order) {
                        Telegram::sendMessage('Заказ с таким ID не существует');
                        return;
                    }
                    $message = 'Заказ #' . $order['id'] . PHP_EOL .
                        'Товар #' . $order['product_id'] . ' ' . $order['product_name'] . PHP_EOL .
                        'Количество: ' . $order['product_count'] . PHP_EOL .
                        'Цена ' . $order['product_price'] . PHP_EOL .
                        'Сумма ' . $order['product_count'] * $order['product_price'] .PHP_EOL .
                        'Создан ' . $order['created_at'] .PHP_EOL .
                        'Изменен ' . $order['modified_at'];
                    $keyboard = Bot::getOrderKeyBoard($order['id'], $order['status']);
                    Telegram::sendMessage($message, $keyboard);
                    break;
            }
        }
    }

    public static function processCallback($callback_query)
    {
        $message_id = $callback_query['message']['message_id'];
        $data = json_decode($callback_query['data'], true);

        Telegram::answerCallbackQuery($callback_query['id']);

        if (!isset($message_id, $data['command'])) {
            exit();
        }

        switch ($data['command']) {
            case 'toggle_order_status':
                $status = Orders::toggleStatus($data['id']);
                $keyboard = static::getOrderKeyBoard($data['id'], $status);
                Telegram::editMessageKeyboard($message_id, $keyboard);
                break;

            case 'delete_order':
                $message = 'Удалить заказ #' . $data['id'] . '?';
                $keyboard = static::getDeleteOrderKeyBoard($data['id']);
                Telegram::sendMessage($message, $keyboard);
                break;

            case 'delete_order_cancel':
                Telegram::deleteMessage($message_id);
                break;

            case 'delete_order_confirm':
                Orders::delete($data['id']);
                Telegram::deleteMessage($message_id);
                $message = 'Заказ #' . $data['id'] . ' удвлен';
                Telegram::sendMessage($message);
                break;
        }
    }

    public static function getOrderKeyBoard($order_id, $status)
    {
        $status_str = $status ? 'Выполнен' : 'Новый';
        return [
            [
                ['text' => $status_str, 'callback_data' => json_encode(['command' => 'toggle_order_status', 'id' => $order_id])],
                ['text' => 'Удалить', 'callback_data' => json_encode(['command' => 'delete_order', 'id' => $order_id])]
            ]
        ];
    }

    public static function getDeleteOrderKeyBoard($order_id)
    {
        return [
            [
                ['text' => 'Да', 'callback_data' => json_encode(['command' => 'delete_order_confirm', 'id' => $order_id])],
                ['text' => 'Отмена', 'callback_data' => json_encode(['command' => 'delete_order_cancel'])]
            ]
        ];
    }

}