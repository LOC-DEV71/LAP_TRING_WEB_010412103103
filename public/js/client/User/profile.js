document.addEventListener('DOMContentLoaded', function() {
    // Edit Profile Modal Toggling
    const editBtn = document.getElementById('btn-edit-profile');
    const modal = document.getElementById('edit-profile-modal');
    const closeBtns = modal ? modal.querySelectorAll('.btn-close-modal, .btn-cancel') : [];
    const overlay = modal ? modal.querySelector('.modal-overlay') : null;

    if (editBtn && modal) {
        editBtn.addEventListener('click', function() {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        const closeModal = function() {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        };

        closeBtns.forEach(btn => btn.addEventListener('click', closeModal));
        if (overlay) {
            overlay.addEventListener('click', closeModal);
        }
    }

    // Handle unliking from profile page
    const wishlistButtons = document.querySelectorAll('.wishlist');
    wishlistButtons.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = btn.getAttribute('data-id');
            
            try {
                const apiUrl = window.PROFILE_CONFIG ? window.PROFILE_CONFIG.toggleLikeUrl : '/products/toggleLike';
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ product_id: productId })
                });

                if (response.status === 401) {
                    showToast("Vui lòng đăng nhập để thao tác.", 'error');
                    return;
                }

                const textResponse = await response.text();
                let result;
                try { result = JSON.parse(textResponse); } catch (e) { return; }

                if (result.success) {
                    if (!result.liked) {
                        // Xóa thẻ sản phẩm khỏi giao diện
                        const card = btn.closest('.product-item-card');
                        if (card) card.remove();
                        
                        // Cập nhật số lượng
                        const countEl = document.getElementById('favorite-count');
                        if (countEl) {
                            countEl.textContent = Math.max(0, parseInt(countEl.textContent) - 1);
                        }
                        showToast("Đã xóa khỏi danh sách yêu thích.", 'success');
                    }
                } else {
                    showToast(result.message || "Lỗi xử lý", 'error');
                }
            } catch (err) {
            }
        });
    });

    // Handle sending verification email with loading state and spam prevention
    const verifyBtn = document.querySelector('.btn-verify-email');
    if (verifyBtn) {
        console.log("Verification button detected on page.");

        // Khôi phục trạng thái từ localStorage
        let attempts = parseInt(localStorage.getItem('email_verify_attempts') || '0');
        let cooldownEnd = parseInt(localStorage.getItem('email_verify_cooldown') || '0');

        const updateButtonState = () => {
            const now = Date.now();
            if (cooldownEnd > now) {
                const secondsLeft = Math.ceil((cooldownEnd - now) / 1000);
                verifyBtn.classList.remove('loading');
                verifyBtn.classList.add('cooldown');
                verifyBtn.style.opacity = '0.7';
                verifyBtn.innerHTML = `<span class="material-symbols-outlined">hourglass_empty</span> Gửi lại sau (${secondsLeft}s)`;
                
                // Cập nhật lại mỗi giây
                setTimeout(updateButtonState, 1000);
            } else {
                // Hết thời gian chờ, reset trạng thái
                if (cooldownEnd > 0) {
                    localStorage.removeItem('email_verify_cooldown');
                    localStorage.setItem('email_verify_attempts', '0');
                    attempts = 0;
                    cooldownEnd = 0;
                }
                verifyBtn.classList.remove('loading', 'cooldown');
                verifyBtn.style.opacity = '1';
                verifyBtn.innerHTML = `<span class="material-symbols-outlined">mail</span> Xác thực thông tin`;
            }
        };

        // Chạy kiểm tra cooldown ban đầu
        updateButtonState();

        verifyBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            
            // Chặn click nếu đang loading hoặc trong cooldown
            if (verifyBtn.classList.contains('loading') || verifyBtn.classList.contains('cooldown')) {
                const now = Date.now();
                if (cooldownEnd > now) {
                    const secondsLeft = Math.ceil((cooldownEnd - now) / 1000);
                    showToast(`Vui lòng đợi ${secondsLeft} giây trước khi gửi lại.`, "warning");
                }
                return;
            }

            const targetUrl = verifyBtn.getAttribute('href');
            
            // Tăng lượt gửi
            attempts += 1;
            localStorage.setItem('email_verify_attempts', attempts.toString());
            console.log(`Verification attempt: ${attempts}/2`);

            // Thêm class loading và đổi trạng thái nút
            verifyBtn.classList.add('loading');
            verifyBtn.innerHTML = `<span class="material-symbols-outlined">sync</span> Đang gửi...`;
            
            showToast("Đang gửi email xác thực. Vui lòng chờ...", "waiting");
            
            // Trì hoãn gửi request 100ms để trình duyệt kịp render giao diện xoay vòng ngay lập tức
            setTimeout(async () => {
                try {
                    const response = await fetch(targetUrl);
                    verifyBtn.classList.remove('loading');
                    
                    if (response.ok) {
                        showToast("Đã gửi email xác thực thành công! Vui lòng kiểm tra hộp thư.", "success");
                        
                        if (attempts >= 2) {
                            // Đạt giới hạn 2 lần, kích hoạt cooldown 60 giây
                            cooldownEnd = Date.now() + 60000;
                            localStorage.setItem('email_verify_cooldown', cooldownEnd.toString());
                            showToast("Bạn đã gửi 2 lần. Vui lòng đợi 60 giây để gửi lại.", "warning");
                            updateButtonState();
                        } else {
                            // Lần 1 thành công, nút quay lại bình thường
                            verifyBtn.innerHTML = `<span class="material-symbols-outlined">mail</span> Xác thực thông tin`;
                        }
                    } else {
                        // Trừ lại lượt nếu gửi thất bại từ phía server
                        attempts = Math.max(0, attempts - 1);
                        localStorage.setItem('email_verify_attempts', attempts.toString());
                        verifyBtn.innerHTML = `<span class="material-symbols-outlined">mail</span> Xác thực thông tin`;
                        showToast("Không thể gửi email xác thực. Vui lòng thử lại.", "error");
                    }
                } catch (err) {
                    console.error("Verification error encountered:", err);
                    attempts = Math.max(0, attempts - 1);
                    localStorage.setItem('email_verify_attempts', attempts.toString());
                    verifyBtn.classList.remove('loading');
                    verifyBtn.innerHTML = `<span class="material-symbols-outlined">mail</span> Xác thực thông tin`;
                    showToast("Có lỗi xảy ra khi gửi yêu cầu.", "error");
                }
        });
    }

    // Order Details Modal Toggling & AJAX Fetching
    const orderRows = document.querySelectorAll('.order-row');
    const orderModal = document.getElementById('order-details-modal');
    const closeOrderBtn = document.getElementById('btn-close-order-modal');
    const orderOverlay = orderModal ? orderModal.querySelector('.modal-overlay') : null;

    if (orderModal) {
        const closeOrderModal = function() {
            orderModal.style.display = 'none';
            document.body.style.overflow = '';
        };

        if (closeOrderBtn) closeOrderBtn.addEventListener('click', closeOrderModal);
        if (orderOverlay) orderOverlay.addEventListener('click', closeOrderModal);

        orderRows.forEach(row => {
            row.addEventListener('click', async function() {
                const orderId = this.getAttribute('data-order-id');
                if (!orderId) return;

                // Show loading toast
                showToast("Đang tải chi tiết đơn hàng...", "waiting");

                try {
                    const response = await fetch(`/user/orderDetails?id=${orderId}`);
                    const result = await response.json();

                    if (result.success) {
                        const order = result.order;
                        const items = result.items;

                        // Fill info
                        document.getElementById('detail-order-id').textContent = `#${order._id}`;
                        
                        // Format Date
                        const dateObj = new Date(order.createdAt);
                        const formattedDate = `${dateObj.getDate().toString().padStart(2, '0')}/${(dateObj.getMonth() + 1).toString().padStart(2, '0')}/${dateObj.getFullYear()}`;
                        document.getElementById('detail-order-date').textContent = formattedDate;
                        
                        document.getElementById('detail-order-payment').textContent = order.payment_method === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : order.payment_method;
                        document.getElementById('detail-order-phone').textContent = order.phone;
                        document.getElementById('detail-order-address').textContent = order.shipping_address;

                        // Status Badge
                        const statusEl = document.getElementById('detail-order-status');
                        statusEl.className = 'order-status-badge'; // reset
                        if (order.status === 'completed') {
                            statusEl.textContent = 'Hoàn thành';
                            statusEl.classList.add('status-completed');
                        } else if (order.status === 'shipping') {
                            statusEl.textContent = 'Đang giao';
                            statusEl.classList.add('status-shipping');
                        } else if (order.status === 'cancelled') {
                            statusEl.textContent = 'Đã hủy';
                            statusEl.classList.add('status-completed'); // or other class
                        } else {
                            statusEl.textContent = 'Chờ xử lý';
                            statusEl.classList.add('status-shipping');
                        }

                        // Note
                        const noteContainer = document.getElementById('detail-order-note-container');
                        if (order.note && order.note.trim() !== '') {
                            document.getElementById('detail-order-note').textContent = order.note;
                            noteContainer.style.display = 'block';
                        } else {
                            noteContainer.style.display = 'none';
                        }

                        // Total Price
                        const formatter = new Intl.NumberFormat('vi-VN');
                        document.getElementById('detail-order-total').textContent = `${formatter.format(order.total_price)}đ`;

                        // Items List
                        const listContainer = document.getElementById('detail-order-items-list');
                        listContainer.innerHTML = ''; // clear

                        items.forEach(item => {
                            // Xử lý đường dẫn hình ảnh chính xác
                            let imgPath = item.thumbnail || '';
                            if (imgPath && !imgPath.startsWith('http') && !imgPath.startsWith('/')) {
                                // Nếu chưa có public/ thì tự thêm vào đầu
                                if (!imgPath.startsWith('public/')) {
                                    imgPath = '/public/' + imgPath;
                                } else {
                                    imgPath = '/' + imgPath;
                                }
                            }

                            const itemHtml = `
                                <div style="display: flex; align-items: center; gap: 16px; padding: 12px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                                    <img src="${imgPath}" alt="${item.title}" style="width: 54px; height: 54px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.02);">
                                    <div style="flex-grow: 1;">
                                        <h5 style="font-weight: 500; font-size: 0.9rem; margin-bottom: 4px; color: #ffffff;">${item.title}</h5>
                                        <p style="font-size: 0.8rem; opacity: 0.6; color: #ffffff;">Phân loại: ${item.color} / ${item.size}</p>
                                    </div>
                                    <div style="text-align: right;">
                                        <p style="font-size: 0.9rem; font-weight: 500; color: #ffffff;">${formatter.format(item.price)}đ</p>
                                        <p style="font-size: 0.8rem; opacity: 0.6; color: #ffffff;">x${item.quantity}</p>
                                    </div>
                                </div>
                            `;
                            listContainer.insertAdjacentHTML('beforeend', itemHtml);
                        });

                        // Open modal
                        orderModal.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    } else {
                        showToast(result.message || "Không thể lấy thông tin đơn hàng.", "error");
                    }
                } catch (err) {
                    console.error("Error fetching order details:", err);
                    showToast("Có lỗi xảy ra khi tải dữ liệu đơn hàng.", "error");
                }
            });
        });
    }
});
