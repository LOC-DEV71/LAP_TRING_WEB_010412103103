/**
 * GearX Admin - Core JavaScript
 */

// Hàm mở Modal chung bằng ID
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('open');
        if (modalId === 'csvImportModal') {
            initCsvDragDrop();
        }
    }
}

// Hàm đóng Modal chung bằng ID
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('open');
    }
}

// Khởi tạo kéo thả và chọn tệp CSV dùng chung
function initCsvDragDrop() {
    const dragZone = document.getElementById('csv-drag-zone');
    const fileInput = document.getElementById('csv_file');
    const placeholder = document.getElementById('csv-placeholder');
    const fileInfo = document.getElementById('csv-file-info');
    const fileName = document.getElementById('csv-file-name');
    const fileSize = document.getElementById('csv-file-size');

    if (!dragZone || !fileInput || dragZone.dataset.initialized === 'true') return;
    dragZone.dataset.initialized = 'true';

    // Click vào vùng kéo thả để kích hoạt ô chọn file ẩn
    dragZone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function() {
        handleFileSelect(this.files[0]);
    });

    // Các hiệu ứng kéo tệp qua vùng thả
    dragZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dragZone.style.borderColor = 'var(--primary-color)';
        dragZone.style.background = 'rgba(26, 115, 232, 0.04)';
    });

    dragZone.addEventListener('dragleave', function() {
        dragZone.style.borderColor = 'var(--border-color)';
        dragZone.style.background = 'transparent';
    });

    dragZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dragZone.style.borderColor = 'var(--border-color)';
        dragZone.style.background = 'transparent';
        
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelect(e.dataTransfer.files[0]);
        }
    });

    function handleFileSelect(file) {
        if (!file) return;
        
        if (!file.name.endsWith('.csv')) {
            showToast("Vui lòng tải lên tệp định dạng .csv!", "error");
            fileInput.value = '';
            placeholder.style.display = 'block';
            fileInfo.style.display = 'none';
            return;
        }

        // Cập nhật tên và kích thước tệp hiển thị lên giao diện
        fileName.textContent = file.name;
        fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
        
        placeholder.style.display = 'none';
        fileInfo.style.display = 'block';
    }
}

// Tự động chạy khi toàn bộ DOM đã sẵn sàng
document.addEventListener('DOMContentLoaded', function() {
    // 1. Kiểm tra tham số URL để tự động mở Modal Nhập CSV
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('import') === 'true') {
        openModal('csvImportModal');
    }

    // 2. Đóng Modal khi nhấn ra ngoài hoặc click vào nút đóng (Event Delegation tương thích hoàn hảo với SPA)
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            event.target.classList.remove('open');
        }

        const closeBtn = event.target.closest('.close-btn') || event.target.closest('[data-dismiss="modal"]');
        if (closeBtn) {
            const modal = closeBtn.closest('.modal-overlay');
            if (modal) {
                modal.classList.remove('open');
            }
        }
    });

    // Khởi tạo custom dropdowns lần đầu
    if (window.initCustomDropdowns) {
        window.initCustomDropdowns();
    }
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
    // Nếu sự kiện đã bị ngăn chặn bởi logic khác (ví dụ: confirm xóa) thì bỏ qua
    if (e.defaultPrevented) return;

    const link = e.target.closest('a');
    
    // Chỉ xử lý các liên kết hợp lệ, cùng domain, không phải nút đăng xuất, không chứa hành động xóa, và không mở tab mới
    if (link && link.href && 
        !link.classList.contains('btn-logout') && 
        !link.classList.contains('no-spa') &&
        !link.href.includes('/delete/') &&
        link.hostname === window.location.hostname && 
        !link.getAttribute('target') &&
        !link.getAttribute('download')) {
        
        const path = link.getAttribute('href');
        if (path && !path.startsWith('#') && !path.startsWith('javascript:')) {
            e.preventDefault();
            const url = link.href;
 
            // Tải trang mới bằng AJAX
            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error("HTTP error " + response.status);
                    return response.text();
                })
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
 
                        // Thực thi các đoạn script có trong trang mới
                        const scripts = newMain.querySelectorAll('script');
                        scripts.forEach(oldScript => {
                            const newScript = document.createElement('script');
                            newScript.text = oldScript.text;
                            document.body.appendChild(newScript).parentNode.removeChild(newScript);
                        });

                        // Khởi tạo lại custom dropdowns sau khi thay đổi DOM
                        if (window.initCustomDropdowns) {
                            window.initCustomDropdowns();
                        }
                    } else {
                        // Fallback nếu cấu trúc trang không khớp hoặc trang lỗi
                        window.location.href = url;
                    }
                })
                .catch(err => {
                    console.warn("SPA fetch failed, falling back to normal navigation:", err);
                    window.location.href = url;
                });
        }
    }
});

// Xử lý khi người dùng nhấn nút Back/Forward của trình duyệt
window.addEventListener('popstate', function() {
    window.location.reload();
});

// SPA Form Router: Gửi form qua AJAX để không tải lại trang (Giữ nguyên ảnh nền)
document.addEventListener('submit', function(e) {
    const form = e.target;
    
    // Chỉ xử lý các form nội bộ và không có class loại trừ 'no-spa'
    if (form.action && 
        form.action.startsWith(window.location.origin) && 
        !form.classList.contains('no-spa')) {
        
        e.preventDefault();
        const url = form.action;
        const method = form.method || 'POST';
        const formData = new FormData(form);
        
        fetch(url, {
            method: method,
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error("HTTP error " + response.status);
            // Nếu PHP xử lý xong và thực hiện redirect (Header Location), fetch sẽ tự động theo dõi redirect đó
            if (response.redirected) {
                return fetch(response.url).then(res => {
                    if (!res.ok) throw new Error("HTTP error " + res.status);
                    return res.text();
                }).then(html => ({ html, url: response.url }));
            }
            return response.text().then(html => ({ html, url: response.url }));
        })
        .then(({ html, url }) => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            const newMain = doc.querySelector('.admin-main');
            const currentMain = document.querySelector('.admin-main');
            
            if (newMain && currentMain) {
                // Thay thế nội dung vùng chính
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

                // Thực thi các đoạn script có trong trang mới
                const scripts = newMain.querySelectorAll('script');
                scripts.forEach(oldScript => {
                    const newScript = document.createElement('script');
                    newScript.text = oldScript.text;
                    document.body.appendChild(newScript).parentNode.removeChild(newScript);
                });

                // Khởi tạo lại custom dropdowns sau khi thay đổi DOM
                if (window.initCustomDropdowns) {
                    window.initCustomDropdowns();
                }
            } else {
                // Gửi form truyền thống nếu cấu trúc DOM mới lỗi
                form.classList.add('no-spa');
                form.submit();
            }
        })
        .catch(err => {
            console.error('Lỗi gửi form SPA:', err);
            // Dự phòng: Submit truyền thống nếu gặp lỗi mạng
            form.submit();
        });
    }
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

// Khởi tạo tính năng Custom Dropdown cho Admin
function initCustomDropdowns() {
    const dropdowns = document.querySelectorAll('.admin-custom-dropdown');
    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const options = dropdown.querySelectorAll('.dropdown-options li');
        const input = dropdown.querySelector('input[type="hidden"]');
        const selectedVal = dropdown.querySelector('.selected-value');

        if (!trigger) return;

        // Xóa event listener cũ bằng cách clone node (tránh bị lặp sự kiện khi gọi lại nhiều lần)
        const newTrigger = trigger.cloneNode(true);
        trigger.parentNode.replaceChild(newTrigger, trigger);

        // Mở/đóng dropdown khi click
        newTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdowns.forEach(d => {
                if (d !== dropdown) d.classList.remove('open');
            });
            dropdown.classList.toggle('open');
        });

        // Click chọn option
        options.forEach(opt => {
            // Clone option để tránh trùng lặp sự kiện
            const newOpt = opt.cloneNode(true);
            opt.parentNode.replaceChild(newOpt, opt);

            newOpt.addEventListener('click', function(e) {
                e.stopPropagation();
                if (this.classList.contains('disabled') || this.hasAttribute('disabled') || this.getAttribute('data-value') === '') {
                    return;
                }
                const value = this.getAttribute('data-value');
                const text = this.textContent;

                if (input) {
                    input.value = value;
                    // Kích hoạt sự kiện change cho input
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                }
                
                // Lấy phần tử selected-value hiện tại trong DOM (tránh dùng tham chiếu cũ đã bị cloneNode thay thế)
                const currentSelectedVal = dropdown.querySelector('.selected-value');
                if (currentSelectedVal) {
                    currentSelectedVal.textContent = text;
                }

                options.forEach(o => o.classList.remove('active'));
                // Tìm lại li trong DOM mới để gán class active
                const parentUl = newOpt.parentNode;
                parentUl.querySelectorAll('li').forEach(li => {
                    if (li.getAttribute('data-value') === value) {
                        li.classList.add('active');
                    } else {
                        li.classList.remove('active');
                    }
                });

                dropdown.classList.remove('open');
            });
        });
    });
}

// Đóng toàn bộ dropdown khi click ra ngoài
document.addEventListener('click', function() {
    document.querySelectorAll('.admin-custom-dropdown').forEach(d => d.classList.remove('open'));
});

window.initCustomDropdowns = initCustomDropdowns;
