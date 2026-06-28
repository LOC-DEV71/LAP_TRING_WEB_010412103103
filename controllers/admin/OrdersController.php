<?php
namespace Controllers\Admin;

use Models\Order;

class OrdersController extends AdminBaseController
{
    private $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
    }

    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = $this->orderModel->getAllAdmin();

        $this->view('admin/pages/orders/index', [
            'title' => 'Quản lý Đơn hàng - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'orders' => $orders
        ]);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'pending';
            $success = $this->orderModel->updateStatus($id, $status);

            if ($success) {
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Cập nhật trạng thái đơn hàng thành công!'
                ];
            } else {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'message' => 'Lỗi: Không thể cập nhật trạng thái!'
                ];
            }
        }

        header('Location: ' . url('admin/orders'));
        exit;
    }
}
