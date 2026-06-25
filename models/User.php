<?php
namespace Models;

use Core\Model;
use PDO;

class User extends Model
{
    protected $table = 'users';

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

    // Lấy thông tin tài khoản hoạt động theo Email, Số điện thoại hoặc Tên đăng nhập
    public function getByLoginKey($key)
    {
        $sql = "SELECT * FROM {$this->table} WHERE (email = :key OR phone = :key OR fullname = :key) AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới tài khoản (Yêu cầu hash mật khẩu trước khi gọi)
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (_id, fullname, email, password, address, phone) 
                VALUES (:_id, :fullname, :email, :password, :address, :phone)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':_id', $data['_id']);
        $stmt->bindParam(':fullname', $data['fullname']);
        $stmt->bindParam(':email', $data['email']);
        
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashedPassword);
        
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':phone', $data['phone']);
        
        return $stmt->execute();
    }
}
