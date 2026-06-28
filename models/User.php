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

    // Lấy thông tin tài khoản hoạt động theo Tên người dùng (fullname)
    public function getByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE fullname = :username AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
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

    // Cập nhật reset token và thời gian hết hạn
    public function updateResetToken($email, $token, $expiresAt)
    {
        $sql = "UPDATE {$this->table} SET reset_token = :token, reset_token_expires = :expires WHERE email = :email AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires', $expiresAt);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    // Tìm kiếm tài khoản hoạt động theo token khôi phục
    public function getByResetToken($token)
    {
        $sql = "SELECT * FROM {$this->table} WHERE reset_token = :token AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật mật khẩu mới và xóa sạch token khôi phục
    public function updatePasswordAndClearToken($userId, $hashedPassword)
    {
        $sql = "UPDATE {$this->table} SET password = :password, reset_token = NULL, reset_token_expires = NULL WHERE _id = :id AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    // Cập nhật thông tin cá nhân
    public function updateProfile($id, $fullname, $phone, $address)
    {
        $sql = "UPDATE {$this->table} SET fullname = :fullname, phone = :phone, address = :address WHERE _id = :id AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Cập nhật token xác thực tài khoản
    public function updateVerificationToken($id, $token)
    {
        $sql = "UPDATE {$this->table} SET verification_token = :token WHERE _id = :id AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Lấy thông tin tài khoản qua token xác thực
    public function getByVerificationToken($token)
    {
        $sql = "SELECT * FROM {$this->table} WHERE verification_token = :token AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Xác thực tài khoản thành công
    public function verifyUser($id)
    {
        $sql = "UPDATE {$this->table} SET is_verified = 1, verification_token = NULL WHERE _id = :id AND deleted = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

