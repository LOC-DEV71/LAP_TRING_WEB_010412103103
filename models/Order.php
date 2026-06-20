<?php
namespace Models;

use Core\Model;
use PDO;

class Order extends Model
{
    protected $table = 'orders';

    // Lấy toàn bộ lịch sử đơn hàng của một khách hàng (Mới nhất xếp trên)
    public function getAllByUserId($userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY createdAt DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin chi tiết một đơn hàng theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE _id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo đơn hàng mới (Khi khách bấm thanh toán)
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (_id, user_id, total_price, payment_method, shipping_address, phone, note) 
                VALUES (:_id, :user_id, :total_price, :payment_method, :shipping_address, :phone, :note)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':_id', $data['_id']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':total_price', $data['total_price']);
        $stmt->bindParam(':payment_method', $data['payment_method']);
        $stmt->bindParam(':shipping_address', $data['shipping_address']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':note', $data['note']);
        
        return $stmt->execute();
    }

    // Cập nhật trạng thái đơn hàng (Dùng cho Admin hoặc khi giao hàng xong)
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE {$this->table} SET status = :status WHERE _id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
