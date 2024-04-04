<?php

namespace app\components;
use PDO;
class Database
{
		public static function connect(): PDO
		{
				$host = 'localhost';
				$db = 'usmankxr_book';
				$user = 'usmankxr_book';
				$pass = 'Usman75!';
				$charset = 'utf8';

				$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
				$options = [
					PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false
				];

				try {
						$pdo = new PDO($dsn, $user, $pass, $options);
				} catch (\PDOException $e) {
						throw new \PDOException($e->getMessage(), (int)$e->getCode());
				}

				return $pdo;
		}

}
