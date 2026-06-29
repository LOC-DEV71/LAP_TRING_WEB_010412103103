<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($title ?? 'Quên Mật Khẩu') ?></title>
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
                <h1>Quên Mật Khẩu</h1>
                <p>Nhập địa chỉ Email của bạn để nhận liên kết khôi phục mật khẩu tài khoản</p>
            </div>

            <div class="auth-form-body">
                <form action="<?= url('auth/forgotPassword') ?>" method="POST" novalidate>
                    <div class="input-group">
                        <input required type="email" name="email" id="forgot-email" placeholder=" " value="<?= htmlspecialchars($old_email ?? '') ?>"/>
                        <label for="forgot-email">Địa chỉ Email của bạn</label>
                        <?php if (!empty($errors['email'])): ?>
                            <span class="error-message"><?= htmlspecialchars($errors['email']) ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="options">
                        <a href="<?= url('auth/login') ?>">
                            <span class="material-symbols-outlined" style="font-size: 1rem;">arrow_back</span>
                            Quay lại Đăng nhập
                        </a>
                    </div>
                    
                    <button class="btn" type="submit">Gửi liên kết khôi phục</button>
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

            // Tự động kích hoạt Toast khi thành công
            <?php if (isset($_SESSION['forgot_success'])): ?>
                showToast("<?= addslashes($_SESSION['forgot_success']) ?>", 'success');
                <?php unset($_SESSION['forgot_success']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
