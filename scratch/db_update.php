<?php
require_once __DIR__ . '/../core/helpers.php';
loadEnv(__DIR__ . '/../.env');
require_once __DIR__ . '/../config/database.php';

try {
    /*
    Tác dụng của file db_update.php này:

    Kiểm tra bảng users:
        - Xem trong bảng đã có 2 cột này chưa:
            - is_verified (Trạng thái đã xác thực hay chưa).
            - verification_token (Mã token ngẫu nhiên gửi qua email).
    Cập nhật cấu trúc (nếu thiếu):
        Nếu chưa có, nó tự động chạy lệnh ALTER TABLE để thêm 2 cột này vào bảng users.
    */
        
    // Check if is_verified and verification_token exist
    $stmt = $conn->query("SHOW COLUMNS FROM users");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Current columns: " . implode(', ', $columns) . "\n";

    if (!in_array('is_verified', $columns)) {
        $conn->exec("ALTER TABLE users ADD COLUMN is_verified TINYINT(1) DEFAULT 0");
        echo "Added column 'is_verified'.\n";
    } else {
        echo "Column 'is_verified' already exists.\n";
    }

    if (!in_array('verification_token', $columns)) {
        $conn->exec("ALTER TABLE users ADD COLUMN verification_token VARCHAR(255) NULL");
        echo "Added column 'verification_token'.\n";
    } else {
        echo "Column 'verification_token' already exists.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
