<?php
namespace Models\Product;

use Core\Model;
use PDO;

class ProductCategory extends Model
{
    protected $table = 'product_categories';

    // Lấy danh sách danh mục hoạt động
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

    // Lấy toàn bộ danh mục (bao gồm cả ẩn, chưa bị xóa) cho Admin
    public function getAllAdmin()
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE deleted = FALSE ORDER BY position ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Lỗi lấy toàn bộ danh mục Admin: " . $e->getMessage());
            return [];
        }
    }

    // Lấy danh mục theo slug
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

    // Thêm danh mục mới
    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (_id, title, slug, position, status, deleted) 
                VALUES (:id, :title, :slug, :position, :status, 0)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => 'cat_' . bin2hex(random_bytes(6)),
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':position' => (int)($data['position'] ?? 0),
            ':status' => $data['status'] ?? 'active'
        ]);
    }

    // Cập nhật danh mục
    public function updateCategory($id, $data)
    {
        $sql = "UPDATE {$this->table} SET title = :title, slug = :slug, position = :position, status = :status WHERE _id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':slug' => $data['slug'],
            ':position' => (int)$data['position'],
            ':status' => $data['status']
        ]);
    }

    // Xóa mềm danh mục
    public function deleteCategory($id)
    {
        $sql = "UPDATE {$this->table} SET deleted = TRUE WHERE _id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
