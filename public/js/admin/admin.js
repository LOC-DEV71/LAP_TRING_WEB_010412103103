/**
 * GearX Admin - Core JavaScript
 */

// Hàm mở Modal chung bằng ID
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('open');
    }
}

// Hàm đóng Modal chung bằng ID
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('open');
    }
}

// Tự động chạy khi toàn bộ DOM đã sẵn sàng
document.addEventListener('DOMContentLoaded', function() {
    // 1. Kiểm tra tham số URL để tự động mở Modal Nhập CSV
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('import') === 'true') {
        openModal('csvImportModal');
    }

    // 2. Đóng Modal khi nhấn ra ngoài khu vực nội dung Modal
    const modals = document.querySelectorAll('.modal-overlay');
    modals.forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('open');
            }
        });
    });
});

// Hàm hiển thị thông báo Toast
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    // Icon tương ứng
    const icon = type === 'success' ? 'check_circle' : 'error';
    toast.innerHTML = `
        <span class="material-symbols-outlined">${icon}</span>
        <span>${message}</span>
    `;

    container.appendChild(toast);

    // Kích hoạt animation slide-in
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);

    // Tự động xóa sau 3.5 giây
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3500);
}

// SPA Router: Chuyển trang không tải lại (Giữ nguyên ảnh nền)
document.addEventListener('click', function(e) {
    const link = e.target.closest('.menu-item');
    // Chỉ xử lý các link menu trong admin và không phải nút Đăng xuất
    if (link && link.href && !link.classList.contains('btn-logout')) {
        e.preventDefault();
        const url = link.href;

        // Tải trang mới bằng AJAX
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newMain = doc.querySelector('.admin-main');
                const currentMain = document.querySelector('.admin-main');
                
                if (newMain && currentMain) {
                    // Thay thế nội dung chính
                    currentMain.innerHTML = newMain.innerHTML;
                    
                    // Cập nhật thanh địa chỉ URL
                    history.pushState({}, '', url);
                    
                    // Cập nhật trạng thái Active trên Sidebar
                    document.querySelectorAll('.menu-item').forEach(item => {
                        item.classList.remove('active');
                        if (item.href === url) {
                            item.classList.add('active');
                        }
                    });

                    // Thực thi các đoạn script có trong trang mới (như vẽ biểu đồ, xử lý giá tiền,...)
                    const scripts = newMain.querySelectorAll('script');
                    scripts.forEach(oldScript => {
                        const newScript = document.createElement('script');
                        newScript.text = oldScript.text;
                        document.body.appendChild(newScript).parentNode.removeChild(newScript);
                    });
                }
            })
            .catch(err => {
                // Nếu lỗi mạng, tự động quay về tải trang truyền thống làm phương án dự phòng
                window.location.href = url;
            });
    }
});

// Xử lý khi người dùng nhấn nút Back/Forward của trình duyệt
window.addEventListener('popstate', function() {
    window.location.reload();
});

// --- DARK MODE LOGIC ---
// Khởi tạo theme từ localStorage
function initTheme() {
    const isDark = localStorage.getItem('theme') === 'dark';
    if (isDark) {
        document.body.classList.add('dark-mode');
        const icon = document.getElementById('theme-toggle-icon');
        if (icon) icon.textContent = 'light_mode';
    }
}

// Chạy khởi tạo ngay lập tức
initTheme();
// Chạy lại khi DOM đã nạp (phòng trường hợp nút bấm chưa xuất hiện)
document.addEventListener('DOMContentLoaded', initTheme);

function toggleTheme() {
    document.body.classList.toggle('dark-mode');
    const isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    
    const icon = document.getElementById('theme-toggle-icon');
    if (icon) {
        icon.textContent = isDark ? 'light_mode' : 'dark_mode';
    }
}
