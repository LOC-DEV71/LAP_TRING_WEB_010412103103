document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('cart-modal');
    if (!modal) return;

    const btnClose = document.getElementById('btn-close-modal');
    const btnConfirm = document.getElementById('btn-confirm-add-cart');
    const imgEl = document.getElementById('modal-product-img');
    const titleEl = document.getElementById('modal-product-title');
    const priceEl = document.getElementById('modal-product-price');
    const colorsContainer = document.getElementById('modal-colors');
    const sizesContainer = document.getElementById('modal-sizes');

    let currentVariants = [];
    let selectedColor = null;
    let selectedSize = null;

    // Helper: format currency
    const formatCurrency = (number) => {
        return new Intl.NumberFormat('vi-VN').format(number) + 'đ';
    };

    // Close modal
    const closeModal = () => {
        modal.classList.remove('active');
        selectedColor = null;
        selectedSize = null;
    };

    btnClose.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Render options
    const renderOptions = () => {
        // Lấy danh sách màu và size unique
        const colors = [...new Set(currentVariants.map(v => v.color))].filter(Boolean);
        const sizes = [...new Set(currentVariants.map(v => v.size))].filter(Boolean);

        // Render Colors
        colorsContainer.innerHTML = '';
        if (colors.length > 0) {
            if (!selectedColor) selectedColor = colors[0];
            colors.forEach(color => {
                const btn = document.createElement('button');
                btn.className = `modal-opt-btn ${color === selectedColor ? 'active' : ''}`;
                btn.textContent = color;
                btn.addEventListener('click', () => {
                    selectedColor = color;
                    renderOptions(); // Re-render to update active classes
                });
                colorsContainer.appendChild(btn);
            });
        } else {
            colorsContainer.innerHTML = '<span style="font-size: 14px; color: #888;">Không có màu</span>';
            selectedColor = null;
        }

        // Render Sizes
        sizesContainer.innerHTML = '';
        if (sizes.length > 0) {
            if (!selectedSize) selectedSize = sizes[0];
            sizes.forEach(size => {
                const btn = document.createElement('button');
                btn.className = `modal-opt-btn ${size === selectedSize ? 'active' : ''}`;
                btn.textContent = size;
                btn.addEventListener('click', () => {
                    selectedSize = size;
                    renderOptions(); // Re-render
                });
                sizesContainer.appendChild(btn);
            });
        } else {
            sizesContainer.innerHTML = '<span style="font-size: 14px; color: #888;">Freesize</span>';
            selectedSize = null;
        }
    };

    // Global function to open modal
    window.openCartModal = async (productId) => {
        // Show loading state
        titleEl.textContent = 'Đang tải...';
        priceEl.textContent = '...';
        imgEl.src = '/public/assets/images/placeholder.jpg';
        colorsContainer.innerHTML = '';
        sizesContainer.innerHTML = '';
        modal.classList.add('active');

        try {
            // Get root URL based on base href or assume it from location
            const baseFolder = window.location.pathname.split('/')[1] === 'GearX' ? '/GearX' : ''; // Handle if project is in a subfolder or root
            const apiUrl = `/products/apiGetDetails?id=${productId}`;
            // Let's rely on the PHP url() output from the caller, but here we construct it
            // Actually, we can use the caller to pass the api URL, or use a relative path if routing allows.
            // A better way is for PHP to define a global JS var, but we'll try relative first.

            // Since we use MVC routing, the root might be / or /subdir/
            // The safest is to rely on a fetch from the current origin. 
            // In our MVC setup, /products/apiGetDetails should work if URL rewriting is at root. 
            // Wait, we can get the base URL from the document or pass it from PHP.
            // Let's assume the router is handling relative paths gracefully, or we'll fetch relative to root.
            const urlPrefix = window.location.pathname.includes('/GearX/') ? '/GearX' : '';
            const fetchUrl = urlPrefix + `/products/apiGetDetails?id=${productId}`;

            const response = await fetch(fetchUrl);
            const data = await response.json();

            if (data.success) {
                const p = data.product;
                currentVariants = data.variants;

                titleEl.textContent = p.title;
                priceEl.textContent = formatCurrency(p.price);
                
                if (p.thumbnail && p.thumbnail.startsWith('http')) {
                    imgEl.src = p.thumbnail;
                } else {
                    imgEl.src = urlPrefix + '/public/assets/images/' + (p.thumbnail || 'placeholder.jpg');
                }

                // Initialize selection
                selectedColor = null;
                selectedSize = null;
                renderOptions();
            } else {
                alert(data.message || 'Lỗi lấy thông tin sản phẩm');
                closeModal();
            }
        } catch (error) {
            console.error(error);
            alert('Lỗi kết nối server');
            closeModal();
        }
    };

    // Confirm button click
    btnConfirm.addEventListener('click', async () => {
        // Find matching variant
        let variantToAdd = null;
        if (currentVariants.length > 0) {
            // Find variant matching selected color and size
            variantToAdd = currentVariants.find(v => 
                (selectedColor ? v.color === selectedColor : true) && 
                (selectedSize ? v.size === selectedSize : true)
            );
        }

        const urlPrefix = window.location.pathname.includes('/GearX/') ? '/GearX' : '';
        const apiUrl = urlPrefix + '/cart/apiAdd';

        const payload = {
            quantity: 1
        };

        if (variantToAdd) {
            payload.variant_id = variantToAdd._id;
        } else if (currentVariants.length > 0) {
            payload.variant_id = currentVariants[0]._id; // fallback to first
        } else {
            // Should not happen, but fallback to product ID? 
            // But we don't have product ID here easily unless we store it.
            // Let's store it.
        }

        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            if (data.success) {
                if (typeof showToast === 'function') {
                    showToast(data.message, 'success');
                } else {
                    alert(data.message);
                }
                closeModal();
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message, 'error');
                } else {
                    alert(data.message);
                }
            }
        } catch (error) {
            console.error(error);
            if (typeof showToast === 'function') {
                showToast('Lỗi thêm giỏ hàng', 'error');
            } else {
                alert('Lỗi thêm giỏ hàng');
            }
        }
    });
});
