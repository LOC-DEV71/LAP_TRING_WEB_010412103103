<?php
namespace Models;

use Core\Model;
use PDO;

class Like extends Model
{
    protected $table = 'likes'; // MySQL không khuyến khích đặt tên bảng trùng với từ khóa LIKE, nên dùng 'likes' (số nhiều)

    // Thêm một lượt thích mới
    public function add($clientId, $productId)
    {
        $id = 'like_' . uniqid();
        $sql = "INSERT INTO {$this->table} (_id, user_id, product_id, created_at) 
                VALUES (:id, :user_id, :product_id, CURRENT_TIMESTAMP)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':user_id' => $clientId,
            ':product_id' => $productId
        ]);
    }

    // Bỏ thích (Xóa)
    public function remove($clientId, $productId)
    {
        $sql = "DELETE FROM {$this->table} WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $clientId,
            ':product_id' => $productId
        ]);
    }

    // Kiểm tra xem User đã thích Product chưa
    public function checkLiked($clientId, $productId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id AND product_id = :product_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $clientId,
            ':product_id' => $productId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy số lượng like của một Product
    public function getLikeCountByProduct($productId)
    {
        $sql = "SELECT COUNT(*) as total_likes FROM {$this->table} WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['total_likes'] : 0;
    }

    // Lấy danh sách Product mà User đã like
    public function getLikedProductsByClient($clientId)
    {
        $sql = "SELECT product_id FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $clientId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // Trả về mảng các product_id
    }
}
