<?php
namespace Models;

use Core\Model;
use PDO;

class ProductImage extends Model
{
    protected $table = 'product_images';

    // Lấy toàn bộ ảnh của một sản phẩm
    public function getByProductId($productId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
