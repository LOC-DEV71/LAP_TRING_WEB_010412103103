<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($title ?? 'Đặt Lại Mật Khẩu') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Raleway:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="<?= asset('css/client/pages/auth.css') ?>?v=<?= time() ?>" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= asset('css/client/layouts/toast.css') ?>?v=<?= time() ?>">
    <script src="<?= asset('js/client/layouts/toast.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= asset('js/client/pages/auth.js') ?>?v=<?= time() ?>"></script>
</head>
<body>
    <div class="brand-corner-top">FASHION</div>
    <div class="brand-corner-bottom">FASHION</div>
    
    <div class="wrapper">
        <div class="glass-panel">
            <div class="header">
                <h1>Đặt Lại Mật Khẩu</h1>
                <p>Nhập mật khẩu mới bảo mật cho tài khoản của bạn</p>
            </div>

            <div class="form-container">
                <form action="<?= url('auth/resetPassword/' . $token) ?>" method="POST" novalidate>
                    <div class="input-group">
                        <input required type="password" name="password" id="reset-password" placeholder=" "/>
                        <label for="reset-password">Mật khẩu mới</label>
                        <span class="material-symbols-outlined toggle-password-icon">visibility_off</span>
                    </div>
                    
                    <div class="input-group">
                        <input required type="password" name="confirm_password" id="confirm-password" placeholder=" "/>
                        <label for="confirm-password">Xác nhận mật khẩu mới</label>
                        <span class="material-symbols-outlined toggle-password-icon">visibility_off</span>
                    </div>
                    
                    <button class="btn" type="submit">Đặt lại mật khẩu</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tự động kích hoạt Toast khi có lỗi từ PHP Back-end trả về
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $field => $msg): ?>
                    showToast("<?= addslashes($msg) ?>", 'error');
                <?php endforeach; ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
