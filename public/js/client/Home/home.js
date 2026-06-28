document.addEventListener('DOMContentLoaded', () => {
    const wishlistButtons = document.querySelectorAll('.wishlist');
    wishlistButtons.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = btn.getAttribute('data-id');
            const icon = btn.querySelector('.material-symbols-outlined');

            try {
                // Sử dụng APP_CONFIG được định nghĩa ở view PHP
                const apiUrl = APP_CONFIG.toggleLikeUrl;
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ product_id: productId })
                });

                if (response.status === 401) {
                    if (typeof showToast === 'function') showToast("Vui lòng đăng nhập để yêu thích sản phẩm.", 'error');
                    setTimeout(() => { window.location.href = APP_CONFIG.loginUrl; }, 1500);
                    return;
                }

                const textResponse = await response.text();
                let result;
                try {
                    result = JSON.parse(textResponse);
                } catch (e) {
                    console.error("Non-JSON response:", textResponse);
                    if (typeof showToast === 'function') showToast("Vui lòng đăng nhập để thao tác.", 'error');
                    setTimeout(() => { window.location.href = APP_CONFIG.loginUrl; }, 1500);
                    return;
                }

                if (result.success) {
                    if (result.liked) {
                        btn.classList.add('liked');
                        icon.style.fontVariationSettings = "'FILL' 1";
                    } else {
                        btn.classList.remove('liked');
                        icon.style.fontVariationSettings = "'FILL' 0";
                    }
                    if (typeof showToast === 'function') showToast(result.message, 'success');
                } else {
                    if (typeof showToast === 'function') showToast(result.message || "Đã có lỗi xảy ra", 'error');
                }
            } catch (err) {
                console.error('Error toggling like:', err);
                if (typeof showToast === 'function') showToast("Vui lòng đăng nhập để yêu thích sản phẩm.", 'error');
                setTimeout(() => { window.location.href = APP_CONFIG.loginUrl; }, 1500);
            }
        });
    });

    // Add to cart API Integration -> Now opens Modal
    const addToCartButtons = document.querySelectorAll('.btn-add-cart');
    addToCartButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const productId = btn.getAttribute('data-id');
            if (typeof window.openCartModal === 'function') {
                window.openCartModal(productId);
            }
        });
    });
});
