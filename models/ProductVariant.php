<?php
namespace Models;

use Core\Model;
use PDO;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    // Lấy danh sách biến thể của một sản phẩm
    public function getByProductId($productId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy một biến thể chi tiết bằng ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE _id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
