<?php
namespace Models;

use Core\Model;
use PDO;

class Product extends Model
{
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
        try {
            // Tự động tạo bảng products nếu chưa tồn tại trong cơ sở dữ liệu
            $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
                _id VARCHAR(255) PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                price DECIMAL(15, 2) NOT NULL,
                image VARCHAR(255) DEFAULT NULL,
                status VARCHAR(50) DEFAULT 'active',
                deleted BOOLEAN DEFAULT FALSE,
                featured VARCHAR(50) DEFAULT 'no',
                createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->db->exec($sql);
        } catch (\Exception $e) {
            error_log("Lỗi khởi tạo bảng products: " . $e->getMessage());
        }
    }

    // Lấy tất cả sản phẩm đang active và chưa bị xóa
    public function getAllActive()
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE status = 'active' AND deleted = FALSE ORDER BY createdAt DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy danh sách sản phẩm: " . $e->getMessage());
            return [];
        }
    }

    // Lấy chi tiết sản phẩm theo ID
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE _id = :id AND deleted = FALSE";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy chi tiết sản phẩm {$id}: " . $e->getMessage());
            return false;
        }
    }

    // Lấy sản phẩm nổi bật
    public function getFeatured()
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE featured = 'yes' AND status = 'active' AND deleted = FALSE LIMIT 10";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy danh sách sản phẩm nổi bật: " . $e->getMessage());
            return [];
        }
    }

    // Lấy sản phẩm theo category slug
    public function getByCategorySlug($slug)
    {
        try {
            // Join với bảng product_categories qua product_category_id
            $sql = "SELECT p.* FROM {$this->table} p
                    JOIN product_categories c ON p.product_category_id = c._id
                    WHERE c.slug = :slug AND p.status = 'active' AND p.deleted = FALSE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':slug' => $slug]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy sản phẩm theo danh mục: " . $e->getMessage());
            return [];
        }
    }
}
