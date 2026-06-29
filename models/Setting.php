<?php
namespace Models;

use Core\Model;
use PDO;

class Setting extends Model
{
    protected $table = 'settings';

    // Lấy tất cả cài đặt dưới dạng mảng key-value
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['key']] = $setting['value'];
        }
        return $result;
    }

    // Lấy giá trị theo key
    public function get($key, $default = null)
    {
        $sql = "SELECT value FROM {$this->table} WHERE `key` = :key";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':key' => $key]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['value'] : $default;
    }

    // Cập nhật hoặc thêm mới cài đặt
    public function set($key, $value, $description = '')
    {
        $sql = "INSERT INTO {$this->table} (`key`, `value`, `description`) 
                VALUES (:key, :value, :description)
                ON DUPLICATE KEY UPDATE `value` = :value, `description` = :description";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':key' => $key,
            ':value' => $value,
            ':description' => $description
        ]);
    }
}
