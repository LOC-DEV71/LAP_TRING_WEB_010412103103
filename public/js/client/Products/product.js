document.addEventListener("DOMContentLoaded", () => {
  // DOM Elements
  const categoryFilter = document.getElementById("category-filter");
  const sizeFilter = document.getElementById("size-filter");
  const colorFilter = document.getElementById("color-filter");
  const priceRange = document.getElementById("price-range");
  const priceValue = document.getElementById("price-value");
  const btnClearFilter = document.getElementById("btn-clear-filter");
  const sortSelector = document.getElementById("sort-selector");
  const productGrid = document.querySelector(".product-grid");
  const productCards = document.querySelectorAll(".product-card");

  // Store original order of cards
  const originalCardsArray = Array.from(productCards);
  originalCardsArray.forEach((card, index) => {
    card.setAttribute("data-original-index", index);
  });

  // Create No Products Found message
  const noProductsMsg = document.createElement("div");
  noProductsMsg.className = "no-products-message hidden";
  noProductsMsg.innerHTML = `
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
    return new Intl.NumberFormat("vi-VN").format(amount) + "đ";
  }

  // Main Filtering Logic
  function applyFilters() {
    let visibleCount = 0;

    productCards.forEach((card) => {
      const category = card.getAttribute("data-category");
      const price = parseInt(card.getAttribute("data-price") || 0);

      // Sizes (comma-separated list, e.g. "S,M,L")
      const sizesAttr = card.getAttribute("data-sizes") || "";
      const sizes = sizesAttr.split(",").filter((s) => s);

      // Colors (comma-separated list, e.g. "black,white")
      const colorsAttr = card.getAttribute("data-colors") || "";
      const colors = colorsAttr.split(",").filter((c) => c);

      // 1. Category Filter Match
      const matchCategory = !activeCategory || category === activeCategory;

      // 2. Price Filter Match
      const matchPrice = price <= maxPrice;

      // 3. Size Filter Match
      const matchSize =
        activeSizes.size === 0 || sizes.some((size) => activeSizes.has(size));

      // 4. Color Filter Match
      const matchColor =
        activeColors.size === 0 ||
        colors.some((color) => activeColors.has(color));

      // Show or hide product card
      if (matchCategory && matchPrice && matchSize && matchColor) {
        card.classList.remove("hidden");
        visibleCount++;
      } else {
        card.classList.add("hidden");
      }
    });

    // Toggle "No Products Found" Message
    if (visibleCount === 0) {
      noProductsMsg.classList.remove("hidden");
    } else {
      noProductsMsg.classList.add("hidden");
    }

    // Update display count
    const displayCountElem = document.querySelector(".catalog-top p");
    if (displayCountElem) {
      displayCountElem.textContent = `Hiển thị ${visibleCount} sản phẩm`;
    }
  }

  // Sorting Logic
  function sortProducts() {
    if (!sortSelector) return;
    const sortBy = sortSelector.value;
    const cardsArray = Array.from(
      productGrid.querySelectorAll(".product-card"),
    );

    cardsArray.sort((a, b) => {
      const priceA = parseInt(a.getAttribute("data-price") || 0);
      const priceB = parseInt(b.getAttribute("data-price") || 0);
      const indexA = parseInt(a.getAttribute("data-original-index") || 0);
      const indexB = parseInt(b.getAttribute("data-original-index") || 0);

      if (sortBy === "price-asc") {
        return priceA - priceB;
      } else if (sortBy === "price-desc") {
        return priceB - priceA;
      } else {
        // 'newest' / original order
        return indexA - indexB;
      }
    });

    // Append sorted cards back to grid (which rearranges them in DOM)
    cardsArray.forEach((card) => {
      productGrid.appendChild(card);
    });

    // Ensure No Products Message stays at the end
    productGrid.appendChild(noProductsMsg);
  }

  // 1. Category Click Listeners
  if (categoryFilter) {
    categoryFilter.querySelectorAll("li").forEach((li) => {
      li.addEventListener("click", () => {
        const category = li.getAttribute("data-category");

        // Toggle category
        if (activeCategory === category) {
          activeCategory = null;
          li.classList.remove("active");
        } else {
          categoryFilter
            .querySelectorAll("li")
            .forEach((item) => item.classList.remove("active"));
          activeCategory = category;
          li.classList.add("active");
        }
        applyFilters();
      });
    });
  }

  // 2. Size Checkbox Listeners
  if (sizeFilter) {
    sizeFilter
      .querySelectorAll('input[type="checkbox"]')
      .forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
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
    colorFilter.querySelectorAll(".color").forEach((span) => {
      span.addEventListener("click", () => {
        const color = span.getAttribute("data-color");

        if (activeColors.has(color)) {
          activeColors.delete(color);
          span.classList.remove("active");
        } else {
          activeColors.add(color);
          span.classList.add("active");
        }
        applyFilters();
      });
    });
  }

  // 4. Price Slider Input Listener
  if (priceRange) {
    priceRange.addEventListener("input", (e) => {
      maxPrice = parseInt(e.target.value);
      if (priceValue) {
        priceValue.textContent = formatCurrency(maxPrice);
      }
      applyFilters();
    });
  }

  // 5. Sort Selector Listener
  if (sortSelector) {
    sortSelector.addEventListener("change", () => {
      sortProducts();
    });
  }

  // 6. Clear Filters Button Listener
  if (btnClearFilter) {
    btnClearFilter.addEventListener("click", () => {
      // Reset active category
      activeCategory = null;
      if (categoryFilter) {
        categoryFilter
          .querySelectorAll("li")
          .forEach((li) => li.classList.remove("active"));
      }

      // Reset active colors
      activeColors.clear();
      if (colorFilter) {
        colorFilter
          .querySelectorAll(".color")
          .forEach((span) => span.classList.remove("active"));
      }

      // Reset active sizes
      activeSizes.clear();
      if (sizeFilter) {
        sizeFilter.querySelectorAll('input[type="checkbox"]').forEach((cb) => {
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
        sortSelector.value = "newest";
        sortProducts();
      }

      // Run filter
      applyFilters();
    });
  }

  // 7. Toggle Like (Wishlist) API Integration
  const wishlistButtons = document.querySelectorAll(".wishlist");
  wishlistButtons.forEach((btn) => {
    btn.addEventListener("click", async (e) => {
      e.preventDefault();
      const productId = btn.getAttribute("data-id");
      const icon = btn.querySelector(".material-symbols-outlined");

      try {
        // Sử dụng cấu hình động từ APP_CONFIG
        const apiUrl = APP_CONFIG.toggleLikeUrl;

        const response = await fetch(apiUrl, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ product_id: productId }),
        });

        // Kiểm tra mã trạng thái HTTP trước khi ép kiểu JSON
        if (response.status === 401) {
          showToast("Vui lòng đăng nhập để yêu thích sản phẩm.", "error");
          setTimeout(() => {
            window.location.href = APP_CONFIG.loginUrl;
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
          showToast("Vui lòng đăng nhập để thao tác.", "error");
          setTimeout(() => {
            window.location.href = APP_CONFIG.loginUrl;
          }, 1500);
          return;
        }

        if (result.success) {
          if (result.liked) {
            btn.classList.add("liked");
            icon.style.fontVariationSettings = "'FILL' 1";
          } else {
            btn.classList.remove("liked");
            icon.style.fontVariationSettings = "'FILL' 0";
          }
          showToast(result.message, "success");
        } else {
          showToast(result.message || "Đã có lỗi xảy ra", "error");
        }
      } catch (err) {
        console.error("Error toggling like:", err);
        showToast("Vui lòng đăng nhập để yêu thích sản phẩm.", "error");
        setTimeout(() => {
          window.location.href = '<?= url("auth/login") ?>';
        }, 1500);
      }
    });
  });

  // 8. Add to cart API Integration -> Now opens Modal
  const addToCartButtons = document.querySelectorAll(".btn-add-cart");
  addToCartButtons.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const productId = btn.getAttribute("data-id");
      if (typeof window.openCartModal === "function") {
        window.openCartModal(productId);
      }
    });
  });
});
