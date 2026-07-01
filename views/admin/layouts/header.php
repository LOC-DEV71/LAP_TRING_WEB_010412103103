<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($title ?? 'Bảng Điều Khiển Quản Trị') ?></title>
    <!-- Google Fonts & Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- File CSS3 Quản Trị Duy Nhất -->
    <link rel="stylesheet" href="<?= asset('css/admin/admin.css') ?>?v=<?= time() ?>"/>
    <!-- Toast Notifications Styles -->
    <link rel="stylesheet" href="<?= asset('css/admin/toast.css') ?>?v=<?= time() ?>"/>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<!-- Container Toast Thông báo -->
<div id="toast-container" class="toast-container"></div>

<div class="admin-layout">
