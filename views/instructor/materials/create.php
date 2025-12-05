<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Tải tài liệu mới</h4>

        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Form tạo tài liệu -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="" method="POST" enctype="multipart/form-data">

                <!-- Tên tài liệu -->
                <div class="mb-3">
                    <label class="form-label">Tên tài liệu <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="Nhập tên tài liệu" required>
                </div>

                <!-- Loại tài liệu -->
                <div class="mb-3">
                    <label class="form-label">Loại tài liệu <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Chọn loại --</option>
                        <option value="PDF">PDF</option>
                        <option value="DOCX">DOCX</option>
                        <option value="PPTX">PPTX</option>
                        <option value="ZIP">ZIP</option>
                        <option value="LINK">Link</option>
                    </select>
                </div>

                <!-- Tải file -->
                <div class="mb-3">
                    <label class="form-label">Tải file lên <span class="text-danger">*</span></label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.docx,.pptx,.zip" required>
                    <small class="text-muted">Cho phép: PDF, DOCX, PPTX, ZIP</small>
                </div>

                <!-- Mô tả tài liệu -->
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Nhập mô tả (tuỳ chọn)"></textarea>
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" selected>Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu tài liệu
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>