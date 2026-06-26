<?php
namespace Models;

use Core\Model;
use PDO;

class Order extends Model
{
    protected $table = 'orders';

    public function __construct()
    {
        parent::__construct();
        try {
            // Tự động tạo bảng orders nếu chưa tồn tại trong cơ sở dữ liệu
            $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
                _id VARCHAR(255) PRIMARY KEY,
                user_id VARCHAR(255) NOT NULL,
                total_price DECIMAL(15, 2) NOT NULL,
                payment_method VARCHAR(255) NOT NULL,
                shipping_address TEXT NOT NULL,
                phone VARCHAR(50) NOT NULL,
                note TEXT DEFAULT NULL,
                status VARCHAR(50) DEFAULT 'pending',
                createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->db->exec($sql);
        } catch (\Exception $e) {
            // Ghi nhận lỗi nhưng không làm sập ứng dụng
            error_log("Lỗi khởi tạo bảng orders: " . $e->getMessage());
        }
    }

    // Lấy toàn bộ lịch sử đơn hàng của một khách hàng (Mới nhất xếp trên)
    public function getAllByUserId($userId)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY createdAt DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy đơn hàng của user {$userId}: " . $e->getMessage());
            return [];
        }
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
