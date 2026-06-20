<?php
namespace Models;

use Core\Model;
use PDO;

class Cart extends Model
{
    protected $table = 'carts';

    // Lấy giỏ hàng của một User (Mỗi user thường chỉ có 1 giỏ hàng active)
    public function getByUserId($userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo giỏ hàng mới cho User
    public function create($id, $userId)
    {
        $sql = "INSERT INTO {$this->table} (_id, user_id) VALUES (:_id, :user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':_id', $id);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    // Áp dụng hoặc xóa mã giảm giá cho giỏ hàng
    public function updateVoucher($cartId, $voucherId)
    {
        $sql = "UPDATE {$this->table} SET voucher_id = :voucher_id WHERE _id = :_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':voucher_id', $voucherId);
        $stmt->bindParam(':_id', $cartId);
        return $stmt->execute();
    }
}
