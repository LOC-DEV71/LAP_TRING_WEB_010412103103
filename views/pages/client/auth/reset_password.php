<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($title ?? 'Đặt Lại Mật Khẩu') ?></title>
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
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        input {
            user-select: text !important;
            -webkit-user-select: text !important;
            -moz-user-select: text !important;
            -ms-user-select: text !important;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            z-index: 0;
        }

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

        .header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #ffffff;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            margin-bottom: 8px;
        }

        .header p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 300;
            letter-spacing: 0.5px;
            line-height: 1.5;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.6s ease forwards;
            position: relative;
            z-index: 2;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

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

        .input-group input:-webkit-autofill {
            -webkit-text-fill-color: #1a1a1a !important;
        }
        
        .input-group input:-webkit-autofill ~ label {
            top: 6px !important;
            left: 10px !important;
            font-size: 0.75rem !important;
            color: #1a1a1a !important;
            font-weight: 600 !important;
        }

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
            margin-top: 8px;
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
        .header h1,
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
            .header h1 {
                font-size: 1.25rem;
                letter-spacing: 1.5px;
                margin-bottom: 6px;
            }
            .header p {
                font-size: 0.8rem;
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
