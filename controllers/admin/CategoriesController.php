<?php
namespace Controllers\Admin;

use Models\Product\ProductCategory;

class CategoriesController extends AdminBaseController
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new ProductCategory();
    }

    // Hiển thị danh sách danh mục
    public function index()
    {
        $categories = $this->categoryModel->getAllAdmin();

        $this->view('admin/pages/categories/index', [
            'title' => 'Quản lý Danh mục - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'categories' => $categories
        ]);
    }

    // Thêm mới danh mục
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $status = $_POST['status'] ?? 'active';
            $position = $_POST['position'] ?? 0;

            if (!empty($title)) {
                $data = [
                    'title' => $title,
                    'slug' => slug($title),
                    'position' => $position,
                    'status' => $status
                ];
                $success = $this->categoryModel->insert($data);

                if ($success) {
                    $_SESSION['toast'] = [
                        'type' => 'success',
                        'message' => 'Đã thêm danh mục mới thành công!'
                    ];
                } else {
                    $_SESSION['toast'] = [
                        'type' => 'error',
                        'message' => 'Lỗi: Không thể thêm danh mục!'
                    ];
                }
            }
        }

        header('Location: ' . url('admin/categories'));
        exit;
    }

    // Cập nhật danh mục
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $status = $_POST['status'] ?? 'active';
            $position = $_POST['position'] ?? 0;

            if (!empty($title)) {
                $data = [
                    'title' => $title,
                    'slug' => slug($title),
                    'position' => $position,
                    'status' => $status
                ];
                $success = $this->categoryModel->updateCategory($id, $data);

                if ($success) {
                    $_SESSION['toast'] = [
                        'type' => 'success',
                        'message' => 'Cập nhật danh mục thành công!'
                    ];
                } else {
                    $_SESSION['toast'] = [
                        'type' => 'error',
                        'message' => 'Lỗi: Không thể cập nhật danh mục!'
                    ];
                }
            }
        }

        header('Location: ' . url('admin/categories'));
        exit;
    }

    // Xóa mềm danh mục
    public function delete($id)
    {
        $success = $this->categoryModel->deleteCategory($id);

        if ($success) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Đã xóa danh mục thành công!'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Lỗi: Không thể xóa danh mục!'
            ];
        }

        header('Location: ' . url('admin/categories'));
        exit;
    }
}
