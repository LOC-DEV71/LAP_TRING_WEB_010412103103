document.addEventListener('DOMContentLoaded', function() {
    // 1. Client - Form Đăng Nhập
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

    // 2. Client - Form Đăng Ký
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

    // 3. Client - Form Quên Mật Khẩu
    const forgotEmailInput = document.getElementById('forgot-email');
    if (forgotEmailInput) {
        const forgotForm = forgotEmailInput.closest('form');
        if (forgotForm) {
            forgotForm.addEventListener('submit', function(e) {
                if (!forgotEmailInput.value.trim()) {
                    e.preventDefault();
                    showToast('Vui lòng nhập địa chỉ Email!', 'error');
                    forgotEmailInput.focus();
                    return;
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(forgotEmailInput.value.trim())) {
                    e.preventDefault();
                    showToast('Định dạng Email không hợp lệ!', 'error');
                    forgotEmailInput.focus();
                    return;
                }
            });
        }
    }

    // 4. Client - Form Đặt Lại Mật Khẩu
    const resetPasswordInput = document.getElementById('reset-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    if (resetPasswordInput && confirmPasswordInput) {
        const resetForm = resetPasswordInput.closest('form');
        if (resetForm) {
            resetForm.addEventListener('submit', function(e) {
                if (!resetPasswordInput.value.trim()) {
                    e.preventDefault();
                    showToast('Vui lòng nhập mật khẩu mới!', 'error');
                    resetPasswordInput.focus();
                    return;
                }

                if (resetPasswordInput.value.length < 6) {
                    e.preventDefault();
                    showToast('Mật khẩu phải có độ dài tối thiểu từ 6 ký tự!', 'error');
                    resetPasswordInput.focus();
                    return;
                }

                if (resetPasswordInput.value !== confirmPasswordInput.value) {
                    e.preventDefault();
                    showToast('Xác nhận mật khẩu mới không khớp!', 'error');
                    confirmPasswordInput.focus();
                    return;
                }
            });
        }
    }

    // 5. Admin - Form Đăng Nhập
    const adminEmailInput = document.getElementById('admin-email');
    const adminPasswordInput = document.getElementById('admin-password');
    if (adminEmailInput && adminPasswordInput) {
        const adminForm = adminEmailInput.closest('form');
        if (adminForm) {
            adminForm.addEventListener('submit', function(e) {
                if (!adminEmailInput.value.trim()) {
                    e.preventDefault();
                    showToast('Vui lòng điền Email Quản trị viên!', 'error');
                    adminEmailInput.focus();
                    return;
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(adminEmailInput.value.trim())) {
                    e.preventDefault();
                    showToast('Định dạng Email Quản trị viên không hợp lệ!', 'error');
                    adminEmailInput.focus();
                    return;
                }

                if (!adminPasswordInput.value.trim()) {
                    e.preventDefault();
                    showToast('Vui lòng nhập Mật khẩu!', 'error');
                    adminPasswordInput.focus();
                    return;
                }
            });
        }
    }
});
