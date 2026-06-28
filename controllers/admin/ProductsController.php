<?php
namespace Controllers\Admin;

use Models\Product\Product;
use Models\Product\ProductCategory;
use Models\Product\ProductVariant;
use Core\CloudinaryService;
use PDO;

class ProductsController extends AdminBaseController
{
    private $productModel;
    private $categoryModel;
    private $variantModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->categoryModel = new ProductCategory();
        $this->variantModel = new ProductVariant();
    }

    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $products = $this->productModel->getAllAdmin();

        $this->view('admin/pages/products/index', [
            'title' => 'Quản lý Sản phẩm - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'products' => $products
        ]);
    }

    // Hiển thị form thêm sản phẩm
    public function create()
    {
        $categories = $this->categoryModel->getAllActive();

        $this->view('admin/pages/products/create', [
            'title' => 'Thêm sản phẩm mới - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'categories' => $categories
        ]);
    }

    // Xử lý lưu sản phẩm mới
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $categoryId = $_POST['category_id'] ?? '';
            $description = $_POST['description'] ?? '';
            $status = $_POST['status'] ?? 'active';
            $featured = $_POST['featured'] ?? 'no';

            // 1. Tải hình ảnh lên Cloudinary
            $thumbnailUrl = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Đẩy vào thư mục gearx/products
                $uploadedUrl = CloudinaryService::upload($_FILES['image']['tmp_name'], 'gearx/products');
                if ($uploadedUrl) {
                    $thumbnailUrl = $uploadedUrl;
                }
            }

            // 2. Thêm vào bảng products
            $productId = 'prod_' . bin2hex(random_bytes(6));
            
            $sqlProduct = "INSERT INTO products (_id, title, product_category_id, description, price, thumbnail, status, featured, deleted) 
                           VALUES (:id, :title, :category_id, :description, :price, :thumbnail, :status, :featured, 0)";
            
            $stmt = $this->productModel->getDbConnection()->prepare($sqlProduct);
            $success = $stmt->execute([
                ':id' => $productId,
                ':title' => $title,
                ':category_id' => $categoryId,
                ':description' => $description,
                ':price' => $price,
                ':thumbnail' => $thumbnailUrl,
                ':status' => $status,
                ':featured' => $featured
            ]);

            if ($success) {
                // 3. Thêm các biến thể tương ứng
                $variants = $_POST['variants'] ?? [];
                $sqlVariant = "INSERT INTO product_variants (_id, product_id, color, size, stock, sku) 
                               VALUES (:id, :product_id, :color, :size, :stock, :sku)";
                $stmtVariant = $this->productModel->getDbConnection()->prepare($sqlVariant);

                foreach ($variants as $v) {
                    if (!empty($v['color']) && !empty($v['size'])) {
                        $variantId = 'var_' . bin2hex(random_bytes(6));
                        $stmtVariant->execute([
                            ':id' => $variantId,
                            ':product_id' => $productId,
                            ':color' => $v['color'],
                            ':size' => $v['size'],
                            ':stock' => (int)($v['stock'] ?? 0),
                            ':sku' => $v['sku'] ?? ('SKU_' . bin2hex(random_bytes(4)))
                        ]);
                    }
                }
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Thêm sản phẩm mới thành công!'
                ];
            } else {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'message' => 'Lỗi: Không thể lưu sản phẩm!'
                ];
            }
        }

        header('Location: ' . url('admin/products'));
        exit;
    }

    // Hiển thị form sửa sản phẩm
    public function edit($id)
    {
        $product = $this->productModel->getById($id);
        if (!$product) {
            header('Location: ' . url('admin/products'));
            exit;
        }

        $variants = $this->variantModel->getByProductId($id);
        $categories = $this->categoryModel->getAllActive();

        $this->view('admin/pages/products/edit', [
            'title' => 'Chỉnh sửa sản phẩm - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'product' => $product,
            'variants' => $variants,
            'categories' => $categories
        ]);
    }

    // Xử lý cập nhật sản phẩm
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $categoryId = $_POST['category_id'] ?? '';
            $description = $_POST['description'] ?? '';
            $status = $_POST['status'] ?? 'active';
            $featured = $_POST['featured'] ?? 'no';

            // Lấy thông tin sản phẩm cũ để xử lý ảnh
            $oldProduct = $this->productModel->getById($id);
            $thumbnailUrl = $oldProduct['thumbnail'] ?? null;

            // Nếu có tải lên ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadedUrl = CloudinaryService::upload($_FILES['image']['tmp_name'], 'gearx/products');
                if ($uploadedUrl) {
                    $thumbnailUrl = $uploadedUrl;
                    // Xóa ảnh cũ trên Cloudinary để dọn rác
                    if (!empty($oldProduct['thumbnail'])) {
                        $publicId = $this->getCloudinaryPublicId($oldProduct['thumbnail']);
                        if ($publicId) {
                            CloudinaryService::delete($publicId);
                        }
                    }
                }
            }

            // Cập nhật bảng products
            $sqlProduct = "UPDATE products SET title = :title, product_category_id = :category_id, description = :description, 
                           price = :price, thumbnail = :thumbnail, status = :status, featured = :featured WHERE _id = :id";
            $stmt = $this->productModel->getDbConnection()->prepare($sqlProduct);
            $updateSuccess = $stmt->execute([
                ':id' => $id,
                ':title' => $title,
                ':category_id' => $categoryId,
                ':description' => $description,
                ':price' => $price,
                ':thumbnail' => $thumbnailUrl,
                ':status' => $status,
                ':featured' => $featured
            ]);

            if ($updateSuccess) {
                // Cập nhật biến thể (Xóa toàn bộ biến thể cũ và chèn mới để đơn giản & đồng bộ)
                $sqlDeleteVariants = "DELETE FROM product_variants WHERE product_id = :product_id";
                $stmtDelete = $this->productModel->getDbConnection()->prepare($sqlDeleteVariants);
                $stmtDelete->execute([':product_id' => $id]);

                $variants = $_POST['variants'] ?? [];
                $sqlVariant = "INSERT INTO product_variants (_id, product_id, color, size, stock, sku) 
                               VALUES (:id, :product_id, :color, :size, :stock, :sku)";
                $stmtVariant = $this->productModel->getDbConnection()->prepare($sqlVariant);

                foreach ($variants as $v) {
                    if (!empty($v['color']) && !empty($v['size'])) {
                        $variantId = $v['_id'] ?? ('var_' . bin2hex(random_bytes(6)));
                        $stmtVariant->execute([
                            ':id' => $variantId,
                            ':product_id' => $id,
                            ':color' => $v['color'],
                            ':size' => $v['size'],
                            ':stock' => (int)($v['stock'] ?? 0),
                            ':sku' => $v['sku'] ?? ('SKU_' . bin2hex(random_bytes(4)))
                        ]);
                    }
                }

                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Cập nhật sản phẩm thành công!'
                ];
            } else {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'message' => 'Lỗi: Không thể cập nhật sản phẩm!'
                ];
            }
        }

        header('Location: ' . url('admin/products'));
        exit;
    }

    // Xử lý xóa mềm sản phẩm
    public function delete($id)
    {
        $sql = "UPDATE products SET deleted = 1 WHERE _id = :id";
        $stmt = $this->productModel->getDbConnection()->prepare($sql);
        $success = $stmt->execute([':id' => $id]);

        if ($success) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => 'Đã xóa sản phẩm thành công!'
            ];
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Lỗi: Không thể xóa sản phẩm!'
            ];
        }

        header('Location: ' . url('admin/products'));
        exit;
    }

    // Trích xuất Cloudinary Public ID từ URL ảnh
    private function getCloudinaryPublicId($url)
    {
        // Ví dụ: https://res.cloudinary.com/dfzgowb54/image/upload/v1782456695/gearx/q4ugscpqxrubwduxmqjw.jpg
        // Trả về: gearx/q4ugscpqxrubwduxmqjw
        $pattern = '/\/upload\/(?:v\d+\/)?([^\.]+)/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
