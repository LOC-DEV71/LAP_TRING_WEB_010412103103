<?php
namespace Controllers\Admin;

use Models\Setting;

class HomepageController extends AdminBaseController
{
    public function index()
    {
        $settingModel = new Setting();
        $settings = $settingModel->getAll();

        $this->view('admin/pages/homepage/index', [
            'title' => 'Cấu hình Trang chủ - Admin GearX',
            'settings' => $settings,
            'adminUser' => $_SESSION['admin_user'] ?? []
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/homepage'));
            exit;
        }

        $settingModel = new Setting();
        
        // Cập nhật các trường text
        $fields = [
            'home_hero_subtitle',
            'home_hero_title',
            'home_hero_sale',
            'home_hero_button_text',
            'home_hero_button_link',
            'home_sale_banner_title',
            'home_sale_banner_button_text',
            'home_sale_banner_button_link'
        ];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $settingModel->set($field, $_POST[$field]);
            }
        }

        // Xử lý tải ảnh lên nếu có
        if (isset($_FILES['home_hero_image']) && $_FILES['home_hero_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['home_hero_image']['tmp_name'];
            $fileName = $_FILES['home_hero_image']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = 'hero_banner_' . time() . '.' . $fileExtension;
                $uploadFileDir = __DIR__ . '/../../public/uploads/banners/';
                
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                }
                
                $destPath = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    // Lưu đường dẫn dạng tương đối
                    $settingModel->set('home_hero_image', 'uploads/banners/' . $newFileName);
                }
            }
        }

        $_SESSION['toast'] = [
            'message' => 'Cấu hình trang chủ đã được cập nhật thành công!',
            'type' => 'success'
        ];

        header('Location: ' . url('admin/homepage'));
        exit;
    }
}
