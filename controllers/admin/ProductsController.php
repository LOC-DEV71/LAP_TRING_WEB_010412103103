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
            'products' => $products,
            'csv_import_title' => 'Nhập Sản Phẩm Bằng CSV',
            'csv_import_action' => url('admin/products/importCsv'),
            'csv_import_template_url' => asset('templates/product_import_template.csv'),
            'csv_import_desc' => 'Chọn hoặc kéo thả tệp CSV chứa danh sách sản phẩm để nhập dữ liệu hàng loạt.'
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
            $price_sale = $_POST['price_sale'] ?? null;
            if ($price_sale === '') {
                $price_sale = null;
            } else {
                $price_sale = (float)$price_sale;
            }
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
            
            $sqlProduct = "INSERT INTO products (_id, title, product_category_id, description, price, price_sale, thumbnail, status, featured, deleted) 
                           VALUES (:id, :title, :category_id, :description, :price, :price_sale, :thumbnail, :status, :featured, 0)";
            
            $stmt = $this->productModel->getDbConnection()->prepare($sqlProduct);
            $success = $stmt->execute([
                ':id' => $productId,
                ':title' => $title,
                ':category_id' => $categoryId,
                ':description' => $description,
                ':price' => $price,
                ':price_sale' => $price_sale,
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
            $price_sale = $_POST['price_sale'] ?? null;
            if ($price_sale === '') {
                $price_sale = null;
            } else {
                $price_sale = (float)$price_sale;
            }
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
                           price = :price, price_sale = :price_sale, thumbnail = :thumbnail, status = :status, featured = :featured WHERE _id = :id";
            $stmt = $this->productModel->getDbConnection()->prepare($sqlProduct);
            $updateSuccess = $stmt->execute([
                ':id' => $id,
                ':title' => $title,
                ':category_id' => $categoryId,
                ':description' => $description,
                ':price' => $price,
                ':price_sale' => $price_sale,
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
    /**
    * Xử lý nhập CSV cho sản phẩm mới
    */
    public function importCsv()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['csv_file']['tmp_name'];

            $db = $this->productModel->getDbConnection();
            $db->beginTransaction();
            $success = 0;
            $failed = 0;
            try {
                $handle = fopen($file, 'r');
                $headers = fgetcsv($handle);
                $lowerHeaders = array_map('strtolower', $headers);
                // Required columns for product import
                $required = ['sku','title','price','category_id','status'];
                if (array_diff($required, $lowerHeaders)) {
                    $_SESSION['toast'] = [
                        'type' => 'error',
                        'message' => 'CSV missing required columns (sku, title, price, category_id, status).'
                    ];
                    fclose($handle);
                    header('Location: ' . url('admin/products'));
                    exit;
                }
                // Use all columns from the file as expected keys
                $expected = $lowerHeaders;
                while (($row = fgetcsv($handle)) !== false) {
                    // Skip rows with mismatched column count
                    if (count($row) !== count($expected)) {
                        $failed++;
                        continue;
                    }
                    $data = array_combine($expected, $row);
                    // Kiểm tra danh mục, tạo nếu chưa có
                    $catStmt = $db->prepare("SELECT _id FROM product_categories WHERE _id = :id");
                    $catStmt->execute([':id' => $data['category_id']]);
                    if (!$catStmt->fetch(PDO::FETCH_ASSOC)) {
                        $catInsert = $db->prepare("INSERT INTO product_categories (_id, title, slug, description, thumbnail, position, status, deleted) VALUES (:id, :title, :slug, '', '', 0, 'active', 0)");
                        $catInsert->execute([
                            ':id' => $data['category_id'],
                            ':title' => 'Category ' . $data['category_id'],
                            ':slug' => strtolower(preg_replace('/\s+/', '-', 'Category ' . $data['category_id']))
                        ]);
                    }
                    // Thêm sản phẩm
                    $productId = 'prod_' . bin2hex(random_bytes(6));
                    $prodInsert = $db->prepare("INSERT INTO products (_id, title, product_category_id, description, price, price_sale, thumbnail, status, featured, deleted) VALUES (:id, :title, :catId, :desc, :price, null, :thumb, :status, :featured, 0)");
                    $prodInsert->execute([
                        ':id' => $productId,
                        ':title' => $data['title'],
                        ':catId' => $data['category_id'],
                        ':desc' => $data['description'] ?? '',
                        ':price' => $data['price'] ?? 0,
                        ':thumb' => $data['image_url'] ?? '',
                        ':status' => $data['status'] ?? 'active',
                        ':featured' => $data['featured'] ?? 'no'
                    ]);
                    $success++;
                }
                $db->commit();
                $_SESSION['toast'] = ['type' => 'success', 'message' => "Đã nhập CSV: Thành công $success bản ghi" . ($failed > 0 ? ", Thất bại $failed" : "")];
            } catch (\Exception $e) {
                $db->rollBack();
                $_SESSION['toast'] = ['type' => 'error', 'message' => 'Lỗi khi nhập CSV: ' . $e->getMessage()];
            }
            fclose($handle);
        } else {
            $_SESSION['toast'] = ['type' => 'error', 'message' => 'Không có tệp CSV hợp lệ'];
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? url('admin/products');
        header('Location: ' . $referer);
        exit;
    }
}
