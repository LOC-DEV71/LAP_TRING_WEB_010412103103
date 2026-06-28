document.addEventListener('DOMContentLoaded', function () {
    // --- 1. Gallery Image Switcher ---
    const mainImage = document.querySelector('.product-detail .main-image img');
    const thumbnails = document.querySelectorAll('.product-detail .thumbnail-list img');

    if (mainImage && thumbnails.length > 0) {
        // Set first thumbnail as active by default
        thumbnails[0].classList.add('active');

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

    if (form) {
        // Create hidden inputs for color and size if they don't exist
        let colorInput = form.querySelector('input[name="color"]');
        if (!colorInput) {
            colorInput = document.createElement('input');
            colorInput.type = 'hidden';
            colorInput.name = 'color';
            form.appendChild(colorInput);
        }

        let sizeInput = form.querySelector('input[name="size"]');
        if (!sizeInput) {
            sizeInput = document.createElement('input');
            sizeInput.type = 'hidden';
            sizeInput.name = 'size';
            form.appendChild(sizeInput);
        }

        // Handle Color Selection
        if (colorOptions.length > 0) {
            // Set first color as active if none is active
            const activeColor = document.querySelector('.option-group .colors .color.active') || colorOptions[0];
            activeColor.classList.add('active');
            colorInput.value = activeColor.dataset.color || activeColor.classList[1] || '';

            colorOptions.forEach(colorBtn => {
                colorBtn.addEventListener('click', function () {
                    colorOptions.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    // Get color value from data-color attribute or the second class name
                    const colorValue = this.dataset.color || this.classList[1] || '';
                    colorInput.value = colorValue;
                });
            });
        }

        // Handle Size Selection
        if (sizeOptions.length > 0) {
            const activeSize = document.querySelector('.option-group .sizes button.active') || sizeOptions[0];
            activeSize.classList.add('active');
            sizeInput.value = activeSize.dataset.size || activeSize.textContent.trim();

            sizeOptions.forEach(sizeBtn => {
                sizeBtn.addEventListener('click', function () {
                    sizeOptions.forEach(s => s.classList.remove('active'));
                    this.classList.add('active');
                    const sizeValue = this.dataset.size || this.textContent.trim();
                    sizeInput.value = sizeValue;
                });
            });
        }
    }

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
    const buyNowBtn = document.querySelector('.btn-buy');
    if (buyNowBtn && form) {
        buyNowBtn.addEventListener('click', function (e) {
            e.preventDefault();
            // Create a temporary hidden input to indicate "buy_now" action
            let buyNowInput = form.querySelector('input[name="buy_now"]');
            if (!buyNowInput) {
                buyNowInput = document.createElement('input');
                buyNowInput.type = 'hidden';
                buyNowInput.name = 'buy_now';
                buyNowInput.value = '1';
                form.appendChild(buyNowInput);
            }
            // Submit the form
            form.submit();
        });
    }
});
