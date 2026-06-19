<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="<?= asset('css/client/Home/home.css') ?>">
</head>
<body>
    <h1>Chào mừng đến với dự án GearX 123!</h1>
    <p class="success">Giao diện (View) đã được tải thành công từ thư mục Client Pages.</p>
    
    <h2>Danh sách sản phẩm mới:</h2>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <strong><?= htmlspecialchars($product['name']) ?></strong> - 
                <?= number_format($product['price'], 0, ',', '.') ?> VNĐ
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
