<?php
namespace Models\Product;

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

    // Lấy nhiều sản phẩm theo mảng ID
    public function getByIds(array $ids)
    {
        if (empty($ids)) return [];
        try {
            $placeholders = str_repeat('?,', count($ids) - 1) . '?';
            $sql = "SELECT * FROM {$this->table} WHERE _id IN ($placeholders) AND deleted = FALSE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($ids);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy danh sách sản phẩm theo IDs: " . $e->getMessage());
            return [];
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
            error_log("Lỗi lấy sản phẩm theo danh mục {$slug}: " . $e->getMessage());
            return [];
        }
    }

    // Lấy tổng số lượng sản phẩm đang hoạt động
    public function getTotalCount()
    {
        try {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE deleted = FALSE";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (\Exception $e) {
            error_log("Lỗi đếm tổng sản phẩm: " . $e->getMessage());
            return 0;
        }
    }

    // Lấy danh sách sản phẩm mới nhất
    public function getRecentProducts($limit = 5)
    {
        try {
            $sql = "SELECT p.*, c.title as category_name 
                    FROM {$this->table} p 
                    LEFT JOIN product_categories c ON p.product_category_id = c._id 
                    WHERE p.deleted = FALSE 
                    ORDER BY p.createdAt DESC 
                    LIMIT :limit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy sản phẩm gần đây: " . $e->getMessage());
            return [];
        }
    }

    // Lấy tất cả sản phẩm chưa bị xóa (bao gồm cả active và inactive) cho Admin
    public function getAllAdmin()
    {
        try {
            $sql = "SELECT p.*, c.title as category_name 
                    FROM {$this->table} p 
                    LEFT JOIN product_categories c ON p.product_category_id = c._id 
                    WHERE p.deleted = FALSE 
                    ORDER BY p.createdAt DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy toàn bộ sản phẩm Admin: " . $e->getMessage());
            return [];
        }
    }
}
