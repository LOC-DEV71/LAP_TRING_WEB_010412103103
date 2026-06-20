<?php
namespace Models;

use Core\Model;
use PDO;

class OrderItem extends Model
{
    protected $table = 'order_items';

    // Lấy tất cả các món đồ thuộc về một đơn hàng cụ thể
    public function getByOrderId($orderId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE order_id = :order_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết món đồ kèm theo Tên, Hình ảnh và Size/Màu để hiển thị trong hóa đơn
    public function getFullDetailsByOrderId($orderId)
    {
        $sql = "SELECT oi.*, pv.color, pv.size, pv.sku, p.title, p.thumbnail 
                FROM {$this->table} oi
                JOIN product_variants pv ON oi.product_variant_id = pv._id
                JOIN products p ON pv.product_id = p._id
                WHERE oi.order_id = :order_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm một món đồ vào hóa đơn
    public function addItem($orderId, $productVariantId, $quantity, $price)
    {
        $sql = "INSERT INTO {$this->table} (order_id, product_variant_id, quantity, price) 
                VALUES (:order_id, :product_variant_id, :quantity, :price)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':product_variant_id', $productVariantId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }
}
