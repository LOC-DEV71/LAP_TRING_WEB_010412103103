<?php
namespace Models;

use Core\Model;
use PDO;

class Navbar extends Model
{
    protected $table = 'navbars';

    // Lấy danh sách các menu đang hiển thị (được active và chưa bị xóa) sắp xếp theo thứ tự hiển thị
    public function getActiveMenus()
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'active' AND deleted = FALSE ORDER BY position ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả các menu (chưa bị xóa)
    public function getAllMenus()
    {
        $sql = "SELECT * FROM {$this->table} WHERE deleted = FALSE ORDER BY position ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết menu theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE _id = :id AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới menu
    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (_id, title, link, position, status) 
                VALUES (:id, :title, :link, :position, :status)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => 'nav_' . bin2hex(random_bytes(6)),
            ':title' => $data['title'],
            ':link' => $data['link'],
            ':position' => (int)($data['position'] ?? 0),
            ':status' => $data['status'] ?? 'active'
        ]);
    }

    // Cập nhật menu
    public function updateMenu($id, $data)
    {
        $sql = "UPDATE {$this->table} SET title = :title, link = :link, position = :position, status = :status WHERE _id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':link' => $data['link'],
            ':position' => (int)$data['position'],
            ':status' => $data['status']
        ]);
    }

    // Xóa mềm menu
    public function deleteMenu($id)
    {
        $sql = "UPDATE {$this->table} SET deleted = TRUE WHERE _id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
