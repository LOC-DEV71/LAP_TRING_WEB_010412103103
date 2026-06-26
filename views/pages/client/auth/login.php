<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Fashion Login &amp; Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Raleway:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Raleway', sans-serif;
        }

        body {
            background: url('https://images.unsplash.com/photo-1705675451868-014a161e591b?q=80&w=735&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            color: #ffffff;
            /* Chặn bôi đen toàn trang (bao gồm Ctrl+A) */
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        /* Vẫn cho phép chọn/sửa chữ bình thường bên trong các ô nhập liệu */
        input {
            user-select: text !important;
            -webkit-user-select: text !important;
            -moz-user-select: text !important;
            -ms-user-select: text !important;
        }

        /* Subtle overlay to enhance the 'frost' feel */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            z-index: 0;
        }

        /* Brand Corner Logos using absolute/fixed CSS3 */
        .brand-corner-top {
            position: fixed;
            top: 32px;
            left: 32px;
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 0.3em;
            font-size: 0.875rem;
            opacity: 0.8;
            z-index: 20;
            pointer-events: none;
        }

        .brand-corner-bottom {
            position: fixed;
            bottom: 32px;
            right: 32px;
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 0.3em;
            font-size: 0.875rem;
            opacity: 0.8;
            z-index: 20;
            pointer-events: none;
        }

        .wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Glassmorphism Panel - Liquid Glass Variant */
        .glass-panel {
            width: 440px;
            padding: 48px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.02) 100%);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-top-color: rgba(255, 255, 255, 0.4);
            border-left-color: rgba(255, 255, 255, 0.3);
            border-radius: 40px;
            box-shadow: 
                0 30px 60px -15px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3),
                inset 0 0 20px rgba(255, 255, 255, 0.05);
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }
        
        .glass-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(255,255,255,0.1) 0%, transparent 60%);
            transform: rotate(30deg);
            pointer-events: none;
        }

        /* Hidden radio buttons for tab switching */
        input[type="radio"] {
            display: none;
        }

        .tabs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tabs label {
            width: 50%;
            text-align: center;
            font-size: 1rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1;
            letter-spacing: 1px;
            padding: 12px 0; 
            display: block;  
            text-transform: uppercase;
        }

        /* Tab highlights using Indigo */
        #login-toggle:checked ~ .tabs .login-tab,
        #register-toggle:checked ~ .tabs .register-tab {
            color: #ffffff;
            font-weight: 500;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
        }

        .tabs::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 10%;
            width: 30%;
            height: 2px;
            background: #ffffff;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            border-radius: 2px;
        }

        #login-toggle:checked ~ .tabs::after {
            left: 10%;
        }

        #register-toggle:checked ~ .tabs::after {
            left: 60%;
        }

        /* Form transition */
        .form-container {
            display: none;
            flex-direction: column;
            animation: fadeIn 0.6s ease forwards;
            position: relative;
            z-index: 2;
        }

        #login-toggle:checked ~ .login-form {
            display: flex;
        }

        #register-toggle:checked ~ .register-form {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Elegant Input Styling */
        .input-group {
            position: relative;
            margin-bottom: 32px;
        }

        .input-group input {
            width: 100%;
            padding: 24px 10px 8px 10px;
            background: rgba(255, 255, 255, 0.03);
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            outline: none;
            color: #ffffff;
            font-size: 1rem;
            border-radius: 8px 8px 0 0;
            transition: all 0.3s ease;
            box-sizing: border-box;
            font-weight: 300;
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-bottom-color: #ffffff;
        }

        .input-group label {
            position: absolute;
            top: 18px;
            left: 10px;
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.2s ease;
            pointer-events: none;
            font-size: 1rem;
            font-weight: 300;
        }

        .input-group input:focus ~ label,
        .input-group input:not(:placeholder-shown) ~ label,
        .input-group input:valid ~ label {
            top: 6px;
            left: 10px;
            font-size: 0.75rem;
            color: #ffffff;
            font-weight: 500;
        }

        /* Xử lý khi Chrome Autofill tự động điền thông tin (làm nền ô nhập thành màu sáng) */
        .input-group input:-webkit-autofill {
            -webkit-text-fill-color: #1a1a1a !important; /* Chữ gõ vào hiển thị màu đen tương phản */
        }
        
        .input-group input:-webkit-autofill ~ label {
            top: 6px !important;
            left: 10px !important;
            font-size: 0.75rem !important;
            color: #1a1a1a !important; /* Nhãn (label) đổi sang màu đen để nổi bật trên nền trắng của autofill */
            font-weight: 600 !important;
        }

        /* Checkbox & Links */
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            margin-bottom: 32px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 300;
        }

        .options label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .options input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            appearance: none;
            -webkit-appearance: none;
            position: relative;
            cursor: pointer;
        }
        
        .options input[type="checkbox"]:checked {
            background: rgba(255, 255, 255, 0.8);
        }
        
        .options input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            color: #1a1a1a;
            font-size: 12px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
        }

        .options a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s;
        }

        .options a:hover {
            color: #ffffff;
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }

        /* Minimal Button */
        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.05) 100%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-top-color: rgba(255, 255, 255, 0.5);
            border-left-color: rgba(255, 255, 255, 0.4);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 1px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.2);
            position: relative;
            z-index: 2;
            text-transform: uppercase;
        }

        .btn:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.1) 100%);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .spacer {
            margin-bottom: 16px;
        }

        /* CAPTCHA Styling */
        .captcha-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
        }

        .captcha-image-wrapper {
            flex-shrink: 0;
            height: 45px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .captcha-image-wrapper:hover {
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            transform: scale(1.02);
        }

        .captcha-img {
            display: block;
            height: 100%;
            width: auto;
        }

        /* Toast Notification System */
        .toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 320px;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 12px;
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 16px 20px;
            border-radius: 16px;
            color: #ffffff;
            font-size: 0.875rem;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.25);
            transform: translateX(120%);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast.error {
            background: linear-gradient(135deg, rgba(186, 26, 26, 0.25) 0%, rgba(186, 26, 26, 0.08) 100%);
            border: 1px solid rgba(186, 26, 26, 0.45);
            border-top-color: rgba(255, 255, 255, 0.25);
            border-left-color: rgba(255, 255, 255, 0.25);
        }

        .toast.success {
            background: linear-gradient(135deg, rgba(70, 72, 212, 0.25) 0%, rgba(70, 72, 212, 0.08) 100%);
            border: 1px solid rgba(70, 72, 212, 0.45);
            border-top-color: rgba(255, 255, 255, 0.25);
            border-left-color: rgba(255, 255, 255, 0.25);
        }

        .toast-icon {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .btn,
        .tabs label,
        .brand-corner-top,
        .brand-corner-bottom {
            font-family: 'Inter', sans-serif;
        }

        @media (max-width: 768px) {
            .brand-corner-top,
            .brand-corner-bottom {
                display: none;
            }
        }

        @media (max-width: 480px) {
            body {
                overflow-y: auto;
            }
            .wrapper {
                height: auto;
                min-height: 100vh;
                padding: 40px 0;
                align-items: flex-start;
                display: flex;
            }
            .glass-panel {
                width: 92%;
                padding: 32px 20px;
                border-radius: 24px;
                margin: auto;
            }
            .tabs label {
                font-size: 0.95rem;
                padding: 10px 0;
            }
            .input-group input {
                font-size: 0.9rem;
                padding: 20px 8px 6px 8px;
            }
            .input-group label {
                font-size: 0.9rem;
                top: 14px;
                left: 8px;
            }
            .input-group input:focus ~ label,
            .input-group input:not(:placeholder-shown) ~ label,
            .input-group input:valid ~ label {
                font-size: 0.7rem;
                top: 4px;
                left: 8px;
            }
            .input-group input:-webkit-autofill ~ label {
                font-size: 0.7rem !important;
                top: 4px !important;
                left: 8px !important;
            }
            .options {
                font-size: 0.78rem;
                margin-bottom: 24px;
            }
            .btn {
                font-size: 0.9rem;
                padding: 14px;
            }
            .toast-container {
                right: 16px;
                left: 16px;
                top: 16px;
                max-width: none;
            }
        }
    </style>
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
                            <span style="color: #ffdad6; font-size: 0.75rem; display: block; margin-top: 4px;"><?= htmlspecialchars($errors['login_key']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="input-group">
                        <input required type="password" name="password" id="login-password" placeholder=" "/>
                        <label for="login-password">Mật khẩu</label>
                        <?php if (!empty($errors['password']) && ($active_tab ?? 'login') === 'login'): ?>
                            <span style="color: #ffdad6; font-size: 0.75rem; display: block; margin-top: 4px;"><?= htmlspecialchars($errors['password']) ?></span>
                        <?php endif; ?>
                    </div>
                    <!-- Anti-spam CAPTCHA -->
                    <?php if (!empty($show_captcha)): ?>
                    <div class="captcha-row">
                        <div class="input-group" style="margin-bottom: 0; flex-grow: 1;">
                            <input required type="text" name="captcha" id="login-captcha" placeholder=" " autocomplete="off"/>
                            <label for="login-captcha">Mã xác thực</label>
                            <?php if (!empty($errors['captcha']) && ($active_tab ?? 'login') === 'login'): ?>
                                <span style="color: #ffdad6; font-size: 0.75rem; display: block; margin-top: 4px;"><?= htmlspecialchars($errors['captcha']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="captcha-image-wrapper" title="Nhấp vào để đổi mã xác thực">
                            <img src="<?= asset('captcha.php') ?>" alt="CAPTCHA" class="captcha-img" onclick="this.src='<?= asset('captcha.php') ?>?'+Math.random()"/>
                        </div>
                    </div>
                    <?php endif; ?>
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
                            <span style="color: #ffdad6; font-size: 0.75rem; display: block; margin-top: 4px;"><?= htmlspecialchars($errors['email']) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="input-group">
                        <input required type="password" name="password" id="register-password" placeholder=" "/>
                        <label for="register-password">Mật khẩu</label>
                        <?php if (!empty($errors['password']) && ($active_tab ?? 'login') === 'register'): ?>
                            <span style="color: #ffdad6; font-size: 0.75rem; display: block; margin-top: 4px;"><?= htmlspecialchars($errors['password']) ?></span>
                        <?php endif; ?>
                    </div>
                    <!-- Anti-spam CAPTCHA -->
                    <div class="captcha-row">
                        <div class="input-group" style="margin-bottom: 0; flex-grow: 1;">
                            <input required type="text" name="captcha" id="register-captcha" placeholder=" " autocomplete="off"/>
                            <label for="register-captcha">Mã xác thực</label>
                            <?php if (!empty($errors['captcha']) && ($active_tab ?? 'login') === 'register'): ?>
                                <span style="color: #ffdad6; font-size: 0.75rem; display: block; margin-top: 4px;"><?= htmlspecialchars($errors['captcha']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="captcha-image-wrapper" title="Nhấp vào để đổi mã xác thực">
                            <img src="<?= asset('captcha.php') ?>" alt="CAPTCHA" class="captcha-img" onclick="this.src='<?= asset('captcha.php') ?>?'+Math.random()"/>
                        </div>
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

                    const captchaInput = document.getElementById('login-captcha');
                    if (captchaInput && !captchaInput.value.trim()) {
                        e.preventDefault();
                        showToast('Vui lòng nhập mã xác thực CAPTCHA!', 'error');
                        captchaInput.focus();
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

                    const captchaInput = document.getElementById('register-captcha');
                    if (!captchaInput.value.trim()) {
                        e.preventDefault();
                        showToast('Vui lòng nhập mã xác thực CAPTCHA!', 'error');
                        captchaInput.focus();
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
