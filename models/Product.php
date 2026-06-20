<?php
namespace Models;

use Core\Model;
use PDO;

class Product extends Model
{
    protected $table = 'products';

    // Lấy tất cả sản phẩm đang active và chưa bị xóa
    public function getAllActive()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' AND deleted = FALSE ORDER BY createdAt DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết sản phẩm theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE _id = :id AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm nổi bật
    public function getFeatured()
    {
        $sql = "SELECT * FROM {$this->table} WHERE featured = 'yes' AND status = 'active' AND deleted = FALSE LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
