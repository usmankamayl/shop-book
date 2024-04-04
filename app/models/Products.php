<?php

namespace app\models;
use app\components\Database;

class Products
{
		public static function all(): bool|array
		{
				$pdo = Database::connect();
				$stmt = $pdo->query('select * from products');

				return $stmt->fetchAll();
		}

		public static function one($id)
		{
				$pdo = Database::connect();
				$stmt = $pdo->prepare('select * from products where `id` = :id');
				$stmt->execute(['id' => $id]);

				return $stmt->fetch();
		}

}
