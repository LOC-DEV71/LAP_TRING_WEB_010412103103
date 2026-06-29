<!-- Dashboard Thống kê -->
<section class="dashboard-stats">
    <div class="glass-panel stat-box">
        <div class="stat-icon-wrapper">
            <span class="material-symbols-outlined">local_shipping</span>
        </div>
        <div>
            <p class="stat-label-title">Đơn hàng</p>
            <p class="stat-numeric-value"><?= count($orders) ?></p>
        </div>
    </div>
    <div class="glass-panel stat-box">
        <div class="stat-icon-wrapper">
            <span class="material-symbols-outlined">favorite</span>
        </div>
        <div>
            <p class="stat-label-title">Yêu thích</p>
            <p class="stat-numeric-value" id="favorite-count"><?= count($likedProducts ?? []) ?></p>
        </div>
    </div>
    <div class="glass-panel stat-box">
        <div class="stat-icon-wrapper">
            <span class="material-symbols-outlined">confirmation_number</span>
        </div>
        <div>
            <p class="stat-label-title">Voucher</p>
            <p class="stat-numeric-value">0</p>
        </div>
    </div>
</section>
