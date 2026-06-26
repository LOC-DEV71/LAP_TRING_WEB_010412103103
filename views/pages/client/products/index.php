<?php 
require_once __DIR__ . '/../../../layouts/client/header/header.php'; 

// Helper function to map product names to category slugs for JS filtering
if (!function_exists('getProductCategorySlug')) {
    function getProductCategorySlug($name) {
        $nameLower = mb_strtolower($name, 'UTF-8');
        if (strpos($nameLower, 'thun') !== false || strpos($nameLower, 'polo') !== false) return 'ao-thun';
        if (strpos($nameLower, 'sơ mi') !== false) return 'ao-so-mi';
        if (strpos($nameLower, 'khoác') !== false || strpos($nameLower, 'bomber') !== false) return 'ao-khoac';
        if (strpos($nameLower, 'short') !== false) return 'quan-short';
        if (strpos($nameLower, 'quần') !== false || strpos($nameLower, 'jeans') !== false || strpos($nameLower, 'kaki') !== false || strpos($nameLower, 'jogger') !== false) return 'quan';
        return 'ao-thun'; // default
    }
}

// Helper to assign mock/default sizes consistently based on product name
if (!function_exists('getProductSizes')) {
    function getProductSizes($name) {
        $nameLower = mb_strtolower($name, 'UTF-8');
        if (strpos($nameLower, 'nam') !== false || strpos($nameLower, 'oversize') !== false) {
            return 'M,L,XL,XXL';
        }
        return 'S,M,L,XL';
    }
}

// Helper to assign mock/default colors consistently based on product name
if (!function_exists('getProductColors')) {
    function getProductColors($name) {
        $nameLower = mb_strtolower($name, 'UTF-8');
        $colors = [];
        if (strpos($nameLower, 'basic') !== false) {
            $colors = ['black', 'white', 'gray'];
        } elseif (strpos($nameLower, 'sơ mi') !== false) {
            $colors = ['white', 'blue', 'beige'];
        } elseif (strpos($nameLower, 'khoác') !== false || strpos($nameLower, 'bomber') !== false) {
            $colors = ['green', 'black', 'gray'];
        } elseif (strpos($nameLower, 'quần') !== false) {
            $colors = ['blue', 'black', 'beige', 'gray'];
        } else {
            $colors = ['black', 'white', 'blue'];
        }
        return implode(',', $colors);
    }
}
?>
<link rel="stylesheet" href="<?= asset('css/client/Products/product.css') ?>">

<!-- Banner -->
<section class="product-banner">
    <div class="product-banner-content">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="<?= url('') ?>">Trang chủ</a>
            <span>&gt;</span>
            <span><?= htmlspecialchars($categoryName ?? 'Nam') ?></span>
        </div>

        <h1><?= htmlspecialchars($bannerTitle ?? 'THỜI TRANG NAM') ?></h1>
        <p><?= htmlspecialchars($bannerDesc ?? 'Khám phá các thiết kế mới nhất dành cho phái mạnh') ?></p>
    </div>

    <div class="product-banner-image">
        <img src="<?= asset('assets/images/banner1.jpg') ?>" alt="">
    </div>
</section>

<!-- Catalog -->
<section class="catalog">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h3>Bộ lọc</h3>

        <!-- Danh mục -->
        <div class="filter-group">
            <h4>Danh mục</h4>
            <ul id="category-filter">
                <li data-category="ao-thun">Áo thun</li>
                <li data-category="ao-so-mi">Áo sơ mi</li>
                <li data-category="ao-khoac">Áo khoác</li>
                <li data-category="quan">Quần</li>
                <li data-category="quan-short">Quần short</li>
            </ul>
        </div>

        <!-- Kích cỡ -->
        <div class="filter-group" id="size-filter">
            <h4>Kích cỡ</h4>

            <label><input type="checkbox" value="S"> S</label>
            <label><input type="checkbox" value="M"> M</label>
            <label><input type="checkbox" value="L"> L</label>
            <label><input type="checkbox" value="XL"> XL</label>
            <label><input type="checkbox" value="XXL"> XXL</label>
        </div>

        <!-- Màu sắc -->
        <div class="filter-group">
            <h4>Màu sắc</h4>

            <div class="color-list" id="color-filter">
                <span class="color black" data-color="black"></span>
                <span class="color white" data-color="white"></span>
                <span class="color gray" data-color="gray"></span>
                <span class="color beige" data-color="beige"></span>
                <span class="color blue" data-color="blue"></span>
                <span class="color green" data-color="green"></span>
            </div>
        </div>

        <!-- Khoảng giá -->
        <div class="filter-group">
            <h4>Khoảng giá</h4>

            <input type="range" min="199000" max="699000" id="price-range" value="699000">

            <div class="price-range">
                <span>199.000đ</span>
                <span id="price-value">699.000đ</span>
            </div>
        </div>

        <button class="clear-filter" id="btn-clear-filter">
            XÓA BỘ LỌC
        </button>
    </aside>

    <!-- Nội dung -->
    <div class="catalog-content">

        <!-- Thanh trên -->
        <div class="catalog-top">
            <p>Hiển thị <?= !empty($products) ? count($products) : 9 ?> sản phẩm</p>

            <select id="sort-selector">
                <option value="newest">Mới nhất</option>
                <option value="price-asc">Giá tăng dần</option>
                <option value="price-desc">Giá giảm dần</option>
            </select>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card" 
                         data-category="<?= getProductCategorySlug($product['title'] ?? '') ?>" 
                         data-price="<?= (int)($product['price'] ?? 0) ?>" 
                         data-sizes="<?= getProductSizes($product['title'] ?? '') ?>" 
                         data-colors="<?= getProductColors($product['title'] ?? '') ?>">
                        <?php $isLiked = in_array($product['_id'], $likedProducts ?? []); ?>
                        <button class="wishlist <?= $isLiked ? 'liked' : '' ?>" data-id="<?= $product['_id'] ?>">
                            <span class="material-symbols-outlined" style="<?= $isLiked ? "font-variation-settings: 'FILL' 1;" : "" ?>">favorite</span>
                        </button>
                        <img src="<?= strpos($product['thumbnail'] ?? '', 'http') === 0 ? htmlspecialchars($product['thumbnail']) : asset(htmlspecialchars($product['thumbnail'] ?? 'assets/images/placeholder.jpg')) ?>" alt="<?= htmlspecialchars($product['title'] ?? '') ?>">

                        <div class="product-info">
                            <h3><?= htmlspecialchars($product['title'] ?? '') ?></h3>
                            <p class="price"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</p>

                            <div class="product-colors" style="margin-bottom: 10px;">
                                <span class="black"></span>
                                <span class="white"></span>
                                <span class="gray"></span>
                            </div>

                            <div class="product-actions" style="margin: 0;">
                                <button class="btn-buy-now" data-id="<?= $product['_id'] ?>">MUA NGAY</button>
                                <button class="btn-add-cart" data-id="<?= $product['_id'] ?>"><span class="material-symbols-outlined">shopping_cart</span></button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Phân trang -->
        <div class="pagination">
            <a class="active" href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">&gt;</a>
        </div>

    </div>

</section>



<script>
document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const categoryFilter = document.getElementById('category-filter');
    const sizeFilter = document.getElementById('size-filter');
    const colorFilter = document.getElementById('color-filter');
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');
    const btnClearFilter = document.getElementById('btn-clear-filter');
    const sortSelector = document.getElementById('sort-selector');
    const productGrid = document.querySelector('.product-grid');
    const productCards = document.querySelectorAll('.product-card');

    // Store original order of cards
    const originalCardsArray = Array.from(productCards);
    originalCardsArray.forEach((card, index) => {
        card.setAttribute('data-original-index', index);
    });

    // Create No Products Found message
    const noProductsMsg = document.createElement('div');
    noProductsMsg.className = 'no-products-message hidden';
    noProductsMsg.innerHTML = 
    `
        <h3>Không tìm thấy sản phẩm nào</h3>
        <p>Vui lòng thử điều chỉnh hoặc xóa bộ lọc để tìm kiếm các sản phẩm khác.</p>
    `;
    productGrid.appendChild(noProductsMsg);

    // Active States Tracking
    let activeCategory = null;
    let activeColors = new Set();
    let activeSizes = new Set();
    let maxPrice = parseInt(priceRange.value);

    // Format currency helper (Vietnamese Dong)
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
    }

    // Main Filtering Logic
    function applyFilters() {
        let visibleCount = 0;

        productCards.forEach(card => {
            const category = card.getAttribute('data-category');
            const price = parseInt(card.getAttribute('data-price') || 0);
            
            // Sizes (comma-separated list, e.g. "S,M,L")
            const sizesAttr = card.getAttribute('data-sizes') || '';
            const sizes = sizesAttr.split(',').filter(s => s);
            
            // Colors (comma-separated list, e.g. "black,white")
            const colorsAttr = card.getAttribute('data-colors') || '';
            const colors = colorsAttr.split(',').filter(c => c);

            // 1. Category Filter Match
            const matchCategory = !activeCategory || category === activeCategory;

            // 2. Price Filter Match
            const matchPrice = price <= maxPrice;

            // 3. Size Filter Match
            const matchSize = activeSizes.size === 0 || 
                sizes.some(size => activeSizes.has(size));

            // 4. Color Filter Match
            const matchColor = activeColors.size === 0 || 
                colors.some(color => activeColors.has(color));

            // Show or hide product card
            if (matchCategory && matchPrice && matchSize && matchColor) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Toggle "No Products Found" Message
        if (visibleCount === 0) {
            noProductsMsg.classList.remove('hidden');
        } else {
            noProductsMsg.classList.add('hidden');
        }
        
        // Update display count
        const displayCountElem = document.querySelector('.catalog-top p');
        if (displayCountElem) {
            displayCountElem.textContent = `Hiển thị ${visibleCount} sản phẩm`;
        }
    }

    // Sorting Logic
    function sortProducts() {
        if (!sortSelector) return;
        const sortBy = sortSelector.value;
        const cardsArray = Array.from(productGrid.querySelectorAll('.product-card'));
        
        cardsArray.sort((a, b) => {
            const priceA = parseInt(a.getAttribute('data-price') || 0);
            const priceB = parseInt(b.getAttribute('data-price') || 0);
            const indexA = parseInt(a.getAttribute('data-original-index') || 0);
            const indexB = parseInt(b.getAttribute('data-original-index') || 0);

            if (sortBy === 'price-asc') {
                return priceA - priceB;
            } else if (sortBy === 'price-desc') {
                return priceB - priceA;
            } else { // 'newest' / original order
                return indexA - indexB;
            }
        });

        // Append sorted cards back to grid (which rearranges them in DOM)
        cardsArray.forEach(card => {
            productGrid.appendChild(card);
        });
        
        // Ensure No Products Message stays at the end
        productGrid.appendChild(noProductsMsg);
    }

    // 1. Category Click Listeners
    if (categoryFilter) {
        categoryFilter.querySelectorAll('li').forEach(li => {
            li.addEventListener('click', () => {
                const category = li.getAttribute('data-category');
                
                // Toggle category
                if (activeCategory === category) {
                    activeCategory = null;
                    li.classList.remove('active');
                } else {
                    categoryFilter.querySelectorAll('li').forEach(item => item.classList.remove('active'));
                    activeCategory = category;
                    li.classList.add('active');
                }
                applyFilters();
            });
        });
    }

    // 2. Size Checkbox Listeners
    if (sizeFilter) {
        sizeFilter.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const size = checkbox.value;
                if (checkbox.checked) {
                    activeSizes.add(size);
                } else {
                    activeSizes.delete(size);
                }
                applyFilters();
            });
        });
    }

    // 3. Color Circle Click Listeners
    if (colorFilter) {
        colorFilter.querySelectorAll('.color').forEach(span => {
            span.addEventListener('click', () => {
                const color = span.getAttribute('data-color');
                
                if (activeColors.has(color)) {
                    activeColors.delete(color);
                    span.classList.remove('active');
                } else {
                    activeColors.add(color);
                    span.classList.add('active');
                }
                applyFilters();
            });
        });
    }

    // 4. Price Slider Input Listener
    if (priceRange) {
        priceRange.addEventListener('input', (e) => {
            maxPrice = parseInt(e.target.value);
            if (priceValue) {
                priceValue.textContent = formatCurrency(maxPrice);
            }
            applyFilters();
        });
    }

    // 5. Sort Selector Listener
    if (sortSelector) {
        sortSelector.addEventListener('change', () => {
            sortProducts();
        });
    }

    // 6. Clear Filters Button Listener
    if (btnClearFilter) {
        btnClearFilter.addEventListener('click', () => {
            // Reset active category
            activeCategory = null;
            if (categoryFilter) {
                categoryFilter.querySelectorAll('li').forEach(li => li.classList.remove('active'));
            }

            // Reset active colors
            activeColors.clear();
            if (colorFilter) {
                colorFilter.querySelectorAll('.color').forEach(span => span.classList.remove('active'));
            }

            // Reset active sizes
            activeSizes.clear();
            if (sizeFilter) {
                sizeFilter.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                    cb.checked = false;
                });
            }

            // Reset price range
            if (priceRange) {
                priceRange.value = priceRange.max;
                maxPrice = parseInt(priceRange.max);
                if (priceValue) {
                    priceValue.textContent = formatCurrency(maxPrice);
                }
            }

            // Reset sort selector
            if (sortSelector) {
                sortSelector.value = 'newest';
                sortProducts();
            }

            // Run filter
            applyFilters();
        });
    }

    // 7. Toggle Like (Wishlist) API Integration
    const wishlistButtons = document.querySelectorAll('.wishlist');
    wishlistButtons.forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const productId = btn.getAttribute('data-id');
            const icon = btn.querySelector('.material-symbols-outlined');

            try {
                // Sử dụng hàm url() của PHP để lấy đúng đường dẫn tuyệt đối
                const apiUrl = '<?= url("products/toggleLike") ?>';
                
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                // Kiểm tra mã trạng thái HTTP trước khi ép kiểu JSON
                if (response.status === 401) {
                    showToast("Vui lòng đăng nhập để yêu thích sản phẩm.", 'error');
                    setTimeout(() => {
                        window.location.href = '<?= url("auth/login") ?>';
                    }, 1500);
                    return;
                }

                const textResponse = await response.text();
                let result;
                try {
                    result = JSON.parse(textResponse);
                } catch (e) {
                    // Nếu không phải JSON (do lỗi server in ra HTML), ép buộc báo lỗi yêu cầu đăng nhập
                    console.error("Non-JSON response:", textResponse);
                    showToast("Vui lòng đăng nhập để thao tác.", 'error');
                    setTimeout(() => { window.location.href = '<?= url("auth/login") ?>'; }, 1500);
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
                    showToast(result.message, 'success');
                } else {
                    showToast(result.message || "Đã có lỗi xảy ra", 'error');
                }
            } catch (err) {
                console.error('Error toggling like:', err);
                showToast("Vui lòng đăng nhập để yêu thích sản phẩm.", 'error');
                setTimeout(() => { window.location.href = '<?= url("auth/login") ?>'; }, 1500);
            }
        });
    });

    // 8. Add to cart API Integration -> Now opens Modal
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
</script>

<?php require_once __DIR__ . '/../../../components/client/cart_modal.php'; ?>

<?php require_once __DIR__ . '/../../../layouts/client/footer.php'; ?>