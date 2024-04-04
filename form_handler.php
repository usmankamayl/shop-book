<?php

require_once __DIR__ . "/vendor/autoload.php";

use app\components\Bot;
use app\components\Telegram;
use app\models\Products;
use app\models\Orders;



if (!isset($_POST['product_id'], $_POST['product_count'], $_POST['phone'])) {
		echo json_encode(['error' => 'Не все поля правильно записаны']);
		exit();
}


$product = Products::one($_POST['product_id']);



if (!$product) {
		echo json_encode(['error' => 'Такого товара нет']);
		exit();
}

$order = [
		'product_id' => $product['id'],
		'product_name' => $product['name'],
		'product_price' => $product['price'],
		'product_count' => $_POST['product_count'],
		'created_at' => date('Y-m-d H:i:s'),
		'phone' => $_POST['phone']
];

$order_id = Orders::add($order);

$message = 'Новый заказ #' . $order_id . PHP_EOL .
    'Товар #' . $order['product_id'] . ' ' . $order['product_name'] . PHP_EOL .
    'Количество: ' . $order['product_count'] . PHP_EOL .
    'Цена ' . $order['product_price'] . PHP_EOL .
    'Сумма ' . $order['product_count'] * $order['product_price'];

$keyboard = Bot::getOrderKeyBoard($order_id, 0);

Telegram::sendMessage($message, $keyboard);

echo json_encode(['success' => 1]);
