document.addEventListener('DOMContentLoaded', function () {
    // --- 1. Gallery Image Switcher ---
    const mainImage = document.querySelector('.product-detail .main-image img');
    const thumbnails = document.querySelectorAll('.product-detail .thumbnail-list img');

    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function () {
                // Remove active class from all thumbnails
                thumbnails.forEach(t => t.classList.remove('active'));
                // Add active class to clicked thumbnail
                this.classList.add('active');
                // Update main image source
                mainImage.src = this.src;
            });
        });
    }

    // --- 2. Color & Size Selection with Form Integration ---
    const colorOptions = document.querySelectorAll('.option-group .colors .color');
    const sizeOptions = document.querySelectorAll('.option-group .sizes button');
    const form = document.querySelector('.product-info form');
    const hiddenVariantInput = document.getElementById('hidden-variant-id');
    const btnAddToCart = document.getElementById('btn-add-to-cart');
    const btnBuyNow = document.getElementById('btn-buy-now');

    // Mảng biến thể được truyền từ PHP qua thẻ script
    const variants = window.PRODUCT_VARIANTS || [];

    function updateSelectedVariant() {
        if (!hiddenVariantInput || variants.length === 0) return;

        const activeColorEl = document.querySelector('.option-group .colors .color.active');
        const activeSizeEl = document.querySelector('.option-group .sizes button.active');

        const selectedColor = activeColorEl ? activeColorEl.getAttribute('data-color') : '';
        const selectedSize = activeSizeEl ? activeSizeEl.getAttribute('data-size') : '';

        // Tìm biến thể khớp với màu và size đã chọn
        const matchedVariant = variants.find(v => 
            v.color.toLowerCase() === selectedColor.toLowerCase() && 
            v.size.toLowerCase() === selectedSize.toLowerCase()
        );

        if (matchedVariant) {
            hiddenVariantInput.value = matchedVariant._id;
            
            // Kiểm tra tồn kho (stock)
            const stock = parseInt(matchedVariant.stock || 0);
            if (stock > 0) {
                // Còn hàng
                if (btnAddToCart) {
                    btnAddToCart.disabled = false;
                    btnAddToCart.textContent = 'THÊM VÀO GIỎ HÀNG';
                }
                if (btnBuyNow) {
                    btnBuyNow.disabled = false;
                    btnBuyNow.textContent = 'MUA NGAY';
                }
            } else {
                // Hết hàng
                if (btnAddToCart) {
                    btnAddToCart.disabled = true;
                    btnAddToCart.textContent = 'HẾT HÀNG';
                }
                if (btnBuyNow) {
                    btnBuyNow.disabled = true;
                    btnBuyNow.textContent = 'HẾT HÀNG';
                }
            }
        } else {
            // Không có tổ hợp biến thể này
            hiddenVariantInput.value = '';
            if (btnAddToCart) {
                btnAddToCart.disabled = true;
                btnAddToCart.textContent = 'TẠM HẾT HÀNG';
            }
            if (btnBuyNow) {
                btnBuyNow.disabled = true;
                btnBuyNow.textContent = 'TẠM HẾT HÀNG';
            }
        }
    }

    // Gán sự kiện click cho các nút chọn màu
    if (colorOptions.length > 0) {
        colorOptions.forEach(colorBtn => {
            colorBtn.addEventListener('click', function () {
                colorOptions.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                updateSelectedVariant();
            });
        });
    }

    // Gán sự kiện click cho các nút chọn size
    if (sizeOptions.length > 0) {
        sizeOptions.forEach(sizeBtn => {
            sizeBtn.addEventListener('click', function () {
                sizeOptions.forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                updateSelectedVariant();
            });
        });
    }

    // Khởi chạy kiểm tra biến thể lần đầu khi tải trang
    updateSelectedVariant();

    // --- 3. Tabs Switcher ---
    const tabButtons = document.querySelectorAll('.product-tabs .tabs-header button');
    const tabContents = document.querySelectorAll('.product-tabs .tabs-content .tab-panel');

    if (tabButtons.length > 0) {
        tabButtons.forEach((button, index) => {
            button.addEventListener('click', function () {
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                // If there are corresponding tab panels, toggle them
                if (tabContents.length > 0) {
                    tabContents.forEach(content => content.classList.remove('active'));
                    if (tabContents[index]) {
                        tabContents[index].classList.add('active');
                    }
                }
            });
        });
    }

    // --- 4. Buy Now Button Handler ---
    if (btnBuyNow && form) {
        btnBuyNow.addEventListener('click', function (e) {
            e.preventDefault();
            if (this.disabled) return;

            // Tạo input ẩn để đánh dấu hành động "mua ngay"
            let buyNowInput = form.querySelector('input[name="buy_now"]');
            if (!buyNowInput) {
                buyNowInput = document.createElement('input');
                buyNowInput.type = 'hidden';
                buyNowInput.name = 'buy_now';
                buyNowInput.value = '1';
                form.appendChild(buyNowInput);
            }
            form.submit();
        });
    }
});
