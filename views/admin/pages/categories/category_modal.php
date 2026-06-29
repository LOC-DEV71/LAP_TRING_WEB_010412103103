<!-- Modal Thêm Mới & Chỉnh Sửa Danh Mục -->
<div id="categoryModal" class="modal-overlay">
    <div class="modal-container">
        <form id="categoryForm" method="POST" action="">
            <div class="modal-header">
                <h3 id="modalTitle">Thêm Danh Mục Mới</h3>
                <button type="button" class="close-btn">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Tên Danh Mục</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Ví dụ: THỜI TRANG NAM" required>
                </div>
                <div class="form-group">
                    <label for="position">Thứ tự hiển thị</label>
                    <div class="custom-stepper" style="display: flex; align-items: center; gap: 8px;">
                        <button type="button" class="btn-step" onclick="stepDown()" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px; border: 1px solid var(--panel-border); background: var(--panel-bg); color: var(--text-primary); font-size: 20px; cursor: pointer; transition: all 0.2s; font-weight: bold;">−</button>
                        <input type="text" id="position" name="position" class="form-control text-center fw-bold" value="0" required style="width: 80px; height: 40px; text-align: center; margin: 0;" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <button type="button" class="btn-step" onclick="stepUp()" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px; border: 1px solid var(--panel-border); background: var(--panel-bg); color: var(--text-primary); font-size: 20px; cursor: pointer; transition: all 0.2s; font-weight: bold;">+</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <div class="admin-custom-dropdown" id="status-dropdown">
                        <button type="button" class="dropdown-trigger">
                            <span class="selected-value">Hiển thị (Active)</span>
                            <span class="material-symbols-outlined arrow-icon">expand_more</span>
                        </button>
                        <ul class="dropdown-options">
                            <li data-value="active" class="active">Hiển thị (Active)</li>
                            <li data-value="inactive">Ẩn (Inactive)</li>
                        </ul>
                        <input type="hidden" id="status" name="status" value="active">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu Lại</button>
            </div>
        </form>
    </div>
</div>
