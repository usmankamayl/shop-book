<?php

namespace app\models;

use app\components\Database;
class Orders
{
		public static function add($data): bool|string
        {

				$pdo = Database::connect();
				$stmt = $pdo->prepare("insert into orders (
						 `product_id`,
						 `product_name`,          
						 `product_price`,          
						 `product_count`,          
						 `created_at`,          
						 `phone`        
						) values (
							:product_id,        
							:product_name,        
							:product_price,        
							:product_count,        
							:created_at,        
							:phone        
						)
        ");

				$stmt->execute($data);
                return $pdo->lastInsertId();
		}

        public static function toggleStatus($id): int
        {

            $pdo = Database::connect();

            $stmt = $pdo->prepare('select `status` from orders where id = :id');
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();

            if ($row) {
                $status = $row['status'] ? 0 : 1;
                $stmt = $pdo->prepare('update orders set `status` = :status, `modified_at` = :modified_at where `id` = :id');
                $stmt->execute([
                    'status' => $status,
                    'id' => $id,
                    'modified_at' => date('Y-m-d H:i:s'),
                ]);
            }

            return $status;
        }

    public static function delete($id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('delete from orders where id = :id');
        $stmt->execute(['id' => $id]);
    }

    public static function one($id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('select * from orders where id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

}
