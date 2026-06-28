<?php
namespace Controllers\Admin;

use Models\User;

class CustomersController extends AdminBaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    // Hiển thị danh sách khách hàng
    public function index()
    {
        $customers = $this->userModel->getAllAdmin();

        $this->view('admin/pages/customers/index', [
            'title' => 'Quản lý Khách hàng - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'customers' => $customers
        ]);
    }

    // Kích hoạt hoặc vô hiệu hóa tài khoản khách hàng
    public function toggle($id)
    {
        $user = $this->userModel->getById($id);
        if ($user) {
            $newStatus = $user['is_verified'] ? 0 : 1;
            $success = $this->userModel->toggleVerification($id, $newStatus);

            if ($success) {
                $statusMessage = $newStatus ? 'Đã kích hoạt tài khoản khách hàng!' : 'Đã khóa tài khoản khách hàng!';
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => $statusMessage
                ];
            } else {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'message' => 'Lỗi: Không thể cập nhật trạng thái tài khoản!'
                ];
            }
        }

        header('Location: ' . url('admin/customers'));
        exit;
    }

    // Xóa mềm tài khoản khách hàng
    public function delete($id)
    {
        $success = $this->userModel->deleteUser($id);

        if ($success) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Đã xóa tài khoản khách hàng!'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Lỗi: Không thể xóa tài khoản khách hàng!'
            ];
        }

        header('Location: ' . url('admin/customers'));
        exit;
    }
}
