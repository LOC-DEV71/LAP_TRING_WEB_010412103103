<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Fashion Login &amp; Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Raleway:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <link href="<?= asset('css/client/auth.css') ?>" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= asset('css/toast.css') ?>">
    <script src="<?= asset('js/toast.js') ?>"></script>
    <script src="<?= asset('js/auth.js') ?>"></script>
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
                        <span class="material-symbols-outlined toggle-password-icon">visibility_off</span>
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
                        <?php if (!empty($errors['username']) && ($active_tab ?? 'login') === 'register'): ?>
                            <span style="color: #ff7878; font-size: 0.75rem; display: block; margin-top: 4px; font-weight: 500;"><?= htmlspecialchars($errors['username']) ?></span>
                        <?php endif; ?>
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
                        <span class="material-symbols-outlined toggle-password-icon">visibility_off</span>
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
            // Tự động kích hoạt Toast khi có lỗi từ PHP Back-end trả về
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $field => $msg): ?>
                    showToast("<?= addslashes($msg) ?>", 'error');
                <?php endforeach; ?>
            <?php endif; ?>

            // Tự động kích hoạt Toast khi đăng ký tài khoản thành công
            <?php if (isset($_SESSION['register_success'])): ?>
                showToast("<?= addslashes($_SESSION['register_success']) ?>", 'success');
                <?php unset($_SESSION['register_success']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
