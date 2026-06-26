<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($title ?? 'Quên Mật Khẩu') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Raleway:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="<?= asset('css/client/auth.css') ?>" rel="stylesheet"/>
    <script>
        function showToast(message, type = 'error') {
            let container = document.querySelector('.toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
            }

            const maxToasts = 5;
            const currentToasts = container.querySelectorAll('.toast');
            if (currentToasts.length >= maxToasts) {
                currentToasts[0].remove();
            }

            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            const iconName = type === 'success' ? 'check_circle' : 'error';
            toast.innerHTML = `
                <span class="material-symbols-outlined toast-icon">${iconName}</span>
                <span style="font-weight: 400; line-height: 1.4;">${message}</span>
            `;

            container.appendChild(toast);

            setTimeout(() => toast.classList.add('show'), 10);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 4000);
        }
    </script>
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

            <div class="form-container">
                <form action="<?= url('auth/forgotPassword') ?>" method="POST" novalidate>
                    <div class="input-group">
                        <input required type="email" name="email" id="forgot-email" placeholder=" " value="<?= htmlspecialchars($old_email ?? '') ?>"/>
                        <label for="forgot-email">Địa chỉ Email của bạn</label>
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
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const emailInput = document.getElementById('forgot-email');

                    if (!emailInput.value.trim()) {
                        e.preventDefault();
                        showToast('Vui lòng nhập địa chỉ Email!', 'error');
                        emailInput.focus();
                        return;
                    }

                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(emailInput.value.trim())) {
                        e.preventDefault();
                        showToast('Định dạng Email không hợp lệ!', 'error');
                        emailInput.focus();
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

            // Tự động kích hoạt Toast khi thành công
            <?php if (isset($_SESSION['forgot_success'])): ?>
                showToast("<?= addslashes($_SESSION['forgot_success']) ?>", 'success');
                <?php unset($_SESSION['forgot_success']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
