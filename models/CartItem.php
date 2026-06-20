<?php
namespace Models;

use Core\Model;
use PDO;

class CartItem extends Model
{
    protected $table = 'cart_items';

    // Lấy tất cả các món đồ trong giỏ hàng (Kèm theo thông tin biến thể sản phẩm nếu cần)
    public function getByCartId($cartId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE cart_id = :cart_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết các món đồ kèm theo thông tin từ bảng product_variants và products (Dùng JOIN)
    public function getFullDetailsByCartId($cartId)
    {
        $sql = "SELECT ci.*, pv.color, pv.size, pv.sku, p.title, p.price, p.thumbnail 
                FROM {$this->table} ci
                JOIN product_variants pv ON ci.product_variant_id = pv._id
                JOIN products p ON pv.product_id = p._id
                WHERE ci.cart_id = :cart_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm một món đồ vào giỏ hàng
    public function addItem($cartId, $productVariantId, $quantity)
    {
        $sql = "INSERT INTO {$this->table} (cart_id, product_variant_id, quantity) 
                VALUES (:cart_id, :product_variant_id, :quantity)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_variant_id', $productVariantId);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    // Cập nhật số lượng của một món đồ trong giỏ
    public function updateQuantity($id, $quantity)
    {
        $sql = "UPDATE {$this->table} SET quantity = :quantity WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Xóa một món đồ khỏi giỏ
    public function removeItem($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Xóa sạch giỏ hàng (khi thanh toán xong)
    public function clearCart($cartId)
    {
        $sql = "DELETE FROM {$this->table} WHERE cart_id = :cart_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cart_id', $cartId);
        return $stmt->execute();
    }
}
