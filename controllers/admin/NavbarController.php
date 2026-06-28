<?php
namespace Controllers\Admin;

use Models\Navbar;

class NavbarController extends AdminBaseController
{
    private $navbarModel;

    public function __construct()
    {
        parent::__construct();
        $this->navbarModel = new Navbar();
    }

    // Hiển thị danh sách menu điều hướng
    public function index()
    {
        $menus = $this->navbarModel->getAllMenus();
        
        $this->view('admin/pages/navbar/index', [
            'title' => 'Quản lý Navbar - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'menus' => $menus
        ]);
    }

    // Xử lý thêm mới menu
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'link' => $_POST['link'] ?? '',
                'position' => $_POST['position'] ?? 0,
                'status' => $_POST['status'] ?? 'active'
            ];

            if (!empty($data['title']) && !empty($data['link'])) {
                $this->navbarModel->insert($data);
            }
        }
        header('Location: ' . url('admin/navbar'));
        exit;
    }

    // Xử lý cập nhật menu
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'link' => $_POST['link'] ?? '',
                'position' => $_POST['position'] ?? 0,
                'status' => $_POST['status'] ?? 'active'
            ];

            if (!empty($data['title']) && !empty($data['link'])) {
                $this->navbarModel->updateMenu($id, $data);
            }
        }
        header('Location: ' . url('admin/navbar'));
        exit;
    }

    // Xử lý xóa menu
    public function delete($id)
    {
        $this->navbarModel->deleteMenu($id);
        header('Location: ' . url('admin/navbar'));
        exit;
    }
}
