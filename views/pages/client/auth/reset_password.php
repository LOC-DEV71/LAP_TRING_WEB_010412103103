<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($title ?? 'Đặt Lại Mật Khẩu') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Raleway:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="<?= asset('css/client/auth.css') ?>" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= asset('css/toast.css') ?>">
    <script src="<?= asset('js/toast.js') ?>"></script>
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
                    </div>
                    
                    <div class="input-group">
                        <input required type="password" name="confirm_password" id="confirm-password" placeholder=" "/>
                        <label for="confirm-password">Xác nhận mật khẩu mới</label>
                    </div>
                    
                    <button class="btn" type="submit">Đặt lại mật khẩu</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const passwordInput = document.getElementById('reset-password');
                    const confirmInput = document.getElementById('confirm-password');

                    if (!passwordInput.value.trim()) {
                        e.preventDefault();
                        showToast('Vui lòng nhập mật khẩu mới!', 'error');
                        passwordInput.focus();
                        return;
                    }

                    if (passwordInput.value.length < 6) {
                        e.preventDefault();
                        showToast('Mật khẩu phải có độ dài tối thiểu từ 6 ký tự!', 'error');
                        passwordInput.focus();
                        return;
                    }

                    if (passwordInput.value !== confirmInput.value) {
                        e.preventDefault();
                        showToast('Xác nhận mật khẩu mới không khớp!', 'error');
                        confirmInput.focus();
                        return;
                    }
                });
            }

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
