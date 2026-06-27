<?php
namespace Models;

use Core\Model;
use PDO;

class ProductCategory extends Model
{
    protected $table = 'product_categories';

    public function getAllActive()
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE status = 'active' AND deleted = FALSE ORDER BY position ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy danh sách danh mục: " . $e->getMessage());
            return [];
        }
    }

    public function getBySlug($slug)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE slug = :slug";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':slug' => $slug]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy danh mục theo slug: " . $e->getMessage());
            return null;
        }
    }
}
