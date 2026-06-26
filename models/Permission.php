<?php
namespace Models;

use Core\Model;
use PDO;

class Permission extends Model
{
    protected $table = 'permissions';

    // Lấy thông tin permission theo key
    public function getByKey($key)
    {
        $sql = "SELECT * FROM {$this->table} WHERE `key` = :key";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Lấy toàn bộ danh sách permissions
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
