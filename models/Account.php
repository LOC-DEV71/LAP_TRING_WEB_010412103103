<?php
namespace Models;

use Core\Model;
use PDO;

class Account extends Model
{
    protected $table = 'accounts';

    // Lấy thông tin tài khoản hoạt động theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE _id = :id AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin tài khoản hoạt động theo Email
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
