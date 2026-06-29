<?php
namespace Controllers\Admin;

use Models\Product\ProductVariant;
use PDO;

class InventoryController extends AdminBaseController
{
    private $variantModel;

    public function __construct()
    {
        parent::__construct();
        $this->variantModel = new ProductVariant();
        // Tự động khởi tạo (hoặc tái tạo) bảng inventory_transactions
        try {
            $db = $this->variantModel->getDbConnection();
            $sql = "CREATE TABLE IF NOT EXISTS inventory_transactions (
                _id VARCHAR(50) PRIMARY KEY,
                variant_id VARCHAR(50) NOT NULL,
                sku VARCHAR(100) NOT NULL,
                change_qty INT NOT NULL,
                type VARCHAR(20) NOT NULL,
                reason TEXT NULL,
                created_by VARCHAR(100) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            )";
            $db->exec($sql);
        } catch (\Exception $e) {
            // Ignore errors in dev environment
        }
    }

    // Hiển thị bảng điều phối tồn kho và nhật ký giao dịch
    public function index()
    {
        $variants = $this->variantModel->getAllAdmin();

        // Tải lịch sử giao dịch kho hàng
        $transactions = [];
        try {
            $sqlTrans = "SELECT t.*, v.color, v.size, p.title as product_title 
                         FROM inventory_transactions t 
                         LEFT JOIN product_variants v ON t.variant_id = v._id 
                         LEFT JOIN products p ON v.product_id = p._id 
                         ORDER BY t.created_at DESC 
                         LIMIT 100";
            $stmt = $this->variantModel->getDbConnection()->query($sqlTrans);
            $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // Bỏ qua nếu có lỗi tải bảng giao dịch
        }

        $this->view('admin/pages/inventory/index', [
            'title' => 'Quản lý Tồn kho - GearX Admin',
            'adminUser' => $_SESSION['admin_user'] ?? [],
            'variants' => $variants,
            'transactions' => $transactions,
            'csv_import_title' => 'Nhập Kho Hàng Loạt Bằng CSV',
            'csv_import_action' => url('admin/inventory/importCsv'),
            'csv_import_template_url' => asset('templates/inventory_import_template.csv'),
            'csv_import_desc' => 'Chọn hoặc kéo thả tệp CSV chứa danh sách biến thể cần bổ sung hoặc xuất kho nhanh.'
        ]);
    }

    // Xử lý cập nhật tồn kho qua AJAX và ghi nhận nhật ký giao dịch
    public function updateStock()
    {
        // Ensure JSON response and clean any previous output
        header('Content-Type: application/json');
        if (ob_get_length()) {
            ob_clean();
        }

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
                exit;
            }

            $input = json_decode(file_get_contents('php://input'), true);
            $variantId = $input['variant_id'] ?? '';
            $stock = $input['stock'] ?? null;

            if (empty($variantId) || $stock === null || $stock < 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
                exit;
            }

            $db = $this->variantModel->getDbConnection();

            // 1. Lấy thông tin tồn kho hiện tại để tính chênh lệch
            $sqlCurrent = "SELECT stock, sku FROM product_variants WHERE _id = :id";
            $stmtCurrent = $db->prepare($sqlCurrent);
            $stmtCurrent->execute([':id' => $variantId]);
            $currentVar = $stmtCurrent->fetch(PDO::FETCH_ASSOC);
            $currentStock = $currentVar ? (int)$currentVar['stock'] : 0;
            $sku = $currentVar ? $currentVar['sku'] : 'N/A';

            // 2. Cập nhật tồn kho
            $success = $this->variantModel->updateStock($variantId, $stock);

            if ($success) {
                // 3. Ghi nhận giao dịch kho loại 'set' (điều chỉnh thủ công)
                $diff = $stock - $currentStock;
                if ($diff !== 0) {
                    $transId = 'trans_' . bin2hex(random_bytes(6));
                    $adminName = $_SESSION['admin_user']['fullname'] ?? 'Quản trị viên';
                    $sqlLog = "INSERT INTO inventory_transactions (_id, variant_id, sku, change_qty, type, reason, created_by, created_at) 
                                   VALUES (:id, :variant_id, :sku, :change_qty, 'set', :reason, :created_by, NOW())";
                    $stmtLog = $db->prepare($sqlLog);
                    $stmtLog->execute([
                        ':id' => $transId,
                        ':variant_id' => $variantId,
                        ':sku' => $sku,
                        ':change_qty' => $diff,
                        ':reason' => 'Điều chỉnh trực tiếp tại bảng điều phối',
                        ':created_by' => $adminName
                    ]);
                }
                echo json_encode(['success' => true, 'message' => 'Cập nhật tồn kho thành công!']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Cập nhật DB thất bại!']);
                exit;
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
            exit;
        }
    }

    // Xử lý cập nhật hàng loạt qua tệp CSV
    public function importCsv()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['csv_file']['tmp_name'];
            $handle = fopen($file, 'r');
            
            // Đọc dòng tiêu đề và kiểm tra cấu trúc cột để tránh nhập nhầm tệp
            $headers = fgetcsv($handle);
            if (!$headers || strtolower(trim($headers[0] ?? '')) !== 'sku' || strtolower(trim($headers[1] ?? '')) !== 'change_qty') {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'message' => 'Tệp CSV không đúng định dạng! Vui lòng sử dụng đúng tệp mẫu có cột "sku" và "change_qty".'
                ];
                fclose($handle);
                header('Location: ' . url('admin/inventory'));
                exit;
            }
            
            $successCount = 0;
            $errorCount = 0;
            $adminName = $_SESSION['admin_user']['fullname'] ?? 'Quản trị viên';
            $db = $this->variantModel->getDbConnection();
            
            $db->beginTransaction();
            try {
                while (($row = fgetcsv($handle)) !== false) {
                    $sku = trim($row[0] ?? '');
                    $changeQty = isset($row[1]) ? (int)$row[1] : 0;
                    $type = trim($row[2] ?? 'import');
                    $reason = trim($row[3] ?? '');

                    if (empty($sku) || $changeQty === 0) {
                        continue;
                    }

                    // 1. Tìm biến thể theo SKU
                    $sqlVar = "SELECT _id, stock FROM product_variants WHERE sku = :sku";
                    $stmtVar = $db->prepare($sqlVar);
                    $stmtVar->execute([':sku' => $sku]);
                    $variant = $stmtVar->fetch(PDO::FETCH_ASSOC);

                    if ($variant) {
                        $variantId = $variant['_id'];
                        $currentStock = (int)$variant['stock'];
                        
                        // 2. Tính toán tồn kho mới
                        $newStock = $currentStock + $changeQty;
                        if ($newStock < 0) {
                            $newStock = 0; // Đảm bảo tồn kho không bị âm
                        }

                        // 3. Cập nhật tồn kho
                        $sqlUpdate = "UPDATE product_variants SET stock = :stock WHERE _id = :id";
                        $stmtUpdate = $db->prepare($sqlUpdate);
                        $stmtUpdate->execute([':stock' => $newStock, ':id' => $variantId]);

                        // 4. Ghi nhận giao dịch kho
                        $transId = 'trans_' . bin2hex(random_bytes(6));
                        $sqlLog = "INSERT INTO inventory_transactions (_id, variant_id, sku, change_qty, type, reason, created_by, created_at) 
                                   VALUES (:id, :variant_id, :sku, :change_qty, :type, :reason, :created_by, NOW())";
                        $stmtLog = $db->prepare($sqlLog);
                        $stmtLog->execute([
                            ':id' => $transId,
                            ':variant_id' => $variantId,
                            ':sku' => $sku,
                            ':change_qty' => $changeQty,
                            ':type' => $type,
                            ':reason' => $reason ?: 'Nhập hàng loạt bằng tệp CSV',
                            ':created_by' => $adminName
                        ]);

                        $successCount++;
                    } else {
                        $errorCount++;
                    }
                }
                $db->commit();
                
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => "Đã xử lý xong tệp CSV: Thành công {$successCount} biến thể" . ($errorCount > 0 ? ", Thất bại {$errorCount} biến thể (không tìm thấy SKU)" : "")
                ];
            } catch (\Exception $e) {
                $db->rollBack();
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'message' => 'Lỗi xử lý tệp CSV: ' . $e->getMessage()
                ];
            }
            
            fclose($handle);
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => 'Không tìm thấy tệp CSV tải lên hoặc tệp bị lỗi!'
            ];
        }

        // Tự động quay lại trang trước đó (Sản phẩm hoặc Tồn kho) thay vì cố định trang Tồn kho
        $referer = $_SERVER['HTTP_REFERER'] ?? url('admin/inventory');
        header('Location: ' . $referer);
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
