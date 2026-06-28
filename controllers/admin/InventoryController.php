<?php
namespace Controllers\Admin;

use Models\Product\ProductVariant;

class InventoryController extends AdminBaseController
{
    private $variantModel;

    public function __construct()
    {
        parent::__construct();
        $this->variantModel = new ProductVariant();
    }

    // Hiển thị bảng điều phối tồn kho
    public function index()
    {
        $variants = $this->variantModel->getAllAdmin();

        $this->view('admin/pages/inventory/index', [
            'title' => 'Quản lý Tồn kho - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'variants' => $variants
        ]);
    }

    // Xử lý cập nhật tồn kho qua AJAX (gọi từ admin.js)
    public function updateStock()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Đọc payload JSON gửi lên
            $input = json_decode(file_get_contents('php://input'), true);
            $variantId = $input['variant_id'] ?? '';
            $stock = $input['stock'] ?? null;

            if (!empty($variantId) && $stock !== null && $stock >= 0) {
                $success = $this->variantModel->updateStock($variantId, $stock);
                if ($success) {
                    echo json_encode(['success' => true, 'message' => 'Cập nhật tồn kho thành công!']);
                    exit;
                }
            }
        }

        echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ hoặc lỗi DB!']);
        exit;
    }

    // Xử lý xóa biến thể
    public function delete($id)
    {
        $success = $this->variantModel->deleteVariant($id);

        if ($success) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Đã xóa biến thể thành công!'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Lỗi: Không thể xóa biến thể!'
            ];
        }

        header('Location: ' . url('admin/inventory'));
        exit;
    }
}
