<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Fashion Login &amp; Register</title>
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

            // Giới hạn tối đa 3 thông báo hiển thị cùng lúc để tránh spam tràn màn hình
            const maxToasts = 5;
            const currentToasts = container.querySelectorAll('.toast');
            if (currentToasts.length >= maxToasts) {
                // Xóa bớt thông báo cũ nhất ngay lập tức
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

            // Trigger animation
            setTimeout(() => toast.classList.add('show'), 10);

            // Remove after 4 seconds
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
            <input <?= ($active_tab ?? 'login') === 'login' ? 'checked' : '' ?> id="login-toggle" name="form-switch" type="radio"/>
            <input <?= ($active_tab ?? 'login') === 'register' ? 'checked' : '' ?> id="register-toggle" name="form-switch" type="radio"/>
            
            <div class="tabs">
                <label class="login-tab" for="login-toggle">Đăng nhập</label>
                <label class="register-tab" for="register-toggle">Đăng ký</label>
            </div>

            <!-- Login Form -->
            <div class="form-container login-form">
                <form action="<?= url('auth/login') ?>" method="POST" novalidate>
                    <div class="input-group">
                        <input required type="text" name="login_key" id="login-key" placeholder=" " value="<?= htmlspecialchars($old_login_key ?? '') ?>"/>
                        <label for="login-key">Email, Số điện thoại hoặc Tên đăng nhập</label>
                        <?php if (!empty($errors['login_key']) && ($active_tab ?? 'login') === 'login'): ?>
                            <span style="color: #ff7878; font-size: 0.75rem; display: block; margin-top: 4px; font-weight: 500;"><?= htmlspecialchars($errors['login_key']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="input-group">
                        <input required type="password" name="password" id="login-password" placeholder=" "/>
                        <label for="login-password">Mật khẩu</label>
                        <?php if (!empty($errors['password']) && ($active_tab ?? 'login') === 'login'): ?>
                            <span style="color: #ff7878; font-size: 0.75rem; display: block; margin-top: 4px; font-weight: 500;"><?= htmlspecialchars($errors['password']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="options">
                        <label><input type="checkbox" name="remember"/> Nhớ mật khẩu</label>
                        <a href="<?= url('auth/forgotPassword') ?>" id="forgot-password">Quên mật khẩu?</a>
                    </div>
                    <button class="btn" type="submit">Đăng nhập</button>
                </form>
            </div>

            <!-- Register Form -->
            <div class="form-container register-form">
                <form action="<?= url('auth/register') ?>" method="POST" novalidate>
                    <div class="input-group">
                        <input required type="text" name="username" id="register-username" placeholder=" " value="<?= htmlspecialchars($old_username ?? '') ?>"/>
                        <label for="register-username">Tên người dùng</label>
                    </div>
                    <div class="input-group">
                        <input required type="email" name="email" id="register-email" placeholder=" " value="<?= htmlspecialchars($old_email ?? '') ?>"/>
                        <label for="register-email">Email</label>
                        <?php if (!empty($errors['email']) && ($active_tab ?? 'login') === 'register'): ?>
                            <span style="color: #ff7878; font-size: 0.75rem; display: block; margin-top: 4px; font-weight: 500;"><?= htmlspecialchars($errors['email']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="input-group">
                        <input required type="password" name="password" id="register-password" placeholder=" "/>
                        <label for="register-password">Mật khẩu</label>
                        <?php if (!empty($errors['password']) && ($active_tab ?? 'login') === 'register'): ?>
                            <span style="color: #ff7878; font-size: 0.75rem; display: block; margin-top: 4px; font-weight: 500;"><?= htmlspecialchars($errors['password']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="spacer"></div> <!-- Extra spacing before button -->
                    <button class="btn" type="submit">Đăng ký</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Kiểm tra Form Đăng Nhập trên trình duyệt
            const loginForm = document.querySelector('.login-form form');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const loginKeyInput = document.getElementById('login-key');
                    const passwordInput = document.getElementById('login-password');

                    if (!loginKeyInput.value.trim()) {
                        e.preventDefault();
                        showToast('Vui lòng điền Email, Số điện thoại hoặc Tên đăng nhập!', 'error');
                        loginKeyInput.focus();
                        return;
                    }

                    if (!passwordInput.value.trim()) {
                        e.preventDefault();
                        showToast('Vui lòng nhập Mật khẩu!', 'error');
                        passwordInput.focus();
                        return;
                    }


                });
            }

            // 2. Kiểm tra Form Đăng Ký trên trình duyệt
            const registerForm = document.querySelector('.register-form form');
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    const usernameInput = document.getElementById('register-username');
                    const emailInput = document.getElementById('register-email');
                    const passwordInput = document.getElementById('register-password');

                    if (!usernameInput.value.trim()) {
                        e.preventDefault();
                        showToast('Tên người dùng không được để trống!', 'error');
                        usernameInput.focus();
                        return;
                    }

                    if (!emailInput.value.trim()) {
                        e.preventDefault();
                        showToast('Vui lòng điền địa chỉ Email đăng ký!', 'error');
                        emailInput.focus();
                        return;
                    }

                    if (!passwordInput.value.trim()) {
                        e.preventDefault();
                        showToast('Vui lòng nhập Mật khẩu đăng ký!', 'error');
                        passwordInput.focus();
                        return;
                    }

                    
                });
            }



            // 4. Tự động kích hoạt Toast khi có lỗi từ PHP Back-end trả về
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $field => $msg): ?>
                    showToast("<?= addslashes($msg) ?>", 'error');
                <?php endforeach; ?>
            <?php endif; ?>

            // 5. Tự động kích hoạt Toast khi đăng ký tài khoản thành công
            <?php if (isset($_SESSION['register_success'])): ?>
                showToast("<?= addslashes($_SESSION['register_success']) ?>", 'success');
                <?php unset($_SESSION['register_success']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
