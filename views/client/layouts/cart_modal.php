<!-- Modal Thêm vào giỏ hàng (Glassmorphism) -->
<div id="cart-modal" class="cart-modal-overlay">
    <div class="cart-modal-content">
        <button class="cart-modal-close" id="btn-close-modal">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="cart-modal-body">
            <div class="cart-modal-img">
                <img id="modal-product-img" src="" alt="Product">
            </div>
            <div class="cart-modal-info">
                <h3 id="modal-product-title">Loading...</h3>
                <p id="modal-product-price" class="price">0đ</p>
                
                <div class="modal-section">
                    <h4>Màu sắc</h4>
                    <div id="modal-colors" class="modal-options">
                        <!-- Render colors here -->
                    </div>
                </div>

                <div class="modal-section">
                    <h4>Kích thước</h4>
                    <div id="modal-sizes" class="modal-options">
                        <!-- Render sizes here -->
                    </div>
                </div>

                <div class="modal-actions">
                    <button class="btn-modal-confirm" id="btn-confirm-add-cart">Xác nhận thêm vào giỏ</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('js/client/Products/cart_modal.js') ?>?v=<?= time() ?>"></script>
