<?php
namespace Models\Product;

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

    // Lấy danh sách màu và size duy nhất của nhiều sản phẩm cùng lúc
    public function getColorsAndSizesByProductIds($productIds)
    {
        if (empty($productIds)) return [];
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $sql = "SELECT product_id, GROUP_CONCAT(DISTINCT color) as colors, GROUP_CONCAT(DISTINCT size) as sizes 
                FROM {$this->table} 
                WHERE product_id IN ($placeholders) 
                GROUP BY product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($productIds);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy số lượng biến thể có tồn kho thấp (dưới ngưỡng threshold)
    public function getLowStockCount($threshold = 10)
    {
        $sql = "SELECT COUNT(pv._id) 
                FROM {$this->table} pv 
                JOIN products p ON pv.product_id = p._id 
                WHERE pv.stock < :threshold AND p.deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':threshold', (int)$threshold, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    // Lấy toàn bộ danh sách biến thể sản phẩm cho trang Tồn kho Admin
    public function getAllAdmin()
    {
        $sql = "SELECT pv.*, p.title as product_title 
                FROM {$this->table} pv 
                JOIN products p ON pv.product_id = p._id 
                WHERE p.deleted = FALSE 
                ORDER BY p.createdAt DESC, pv.sku ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật nhanh số lượng kho của biến thể
    public function updateStock($id, $stock)
    {
        $sql = "UPDATE {$this->table} SET stock = :stock WHERE _id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':stock' => (int)$stock
        ]);
    }

    // Xóa biến thể theo ID
    public function deleteVariant($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE _id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
