<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Giả lập dữ liệu lấy từ DB
$material = [
    "title" => "Bài học 1 - Giới thiệu Python",
    "type" => "PDF",
    "description" => "Tài liệu giới thiệu cơ bản về Python.",
    "status" => 1,
    "file" => "document1.pdf",
];
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Sửa tài liệu</h4>

        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Form sửa tài liệu -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="" method="POST" enctype="multipart/form-data">

                <!-- Tên tài liệu -->
                <div class="mb-3">
                    <label class="form-label">Tên tài liệu <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control"
                        value="<?= $material['title'] ?>" required>
                </div>

                <!-- Loại tài liệu -->
                <div class="mb-3">
                    <label class="form-label">Loại tài liệu <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="PDF" <?= $material['type'] == 'PDF' ? 'selected' : '' ?>>PDF</option>
                        <option value="DOCX" <?= $material['type'] == 'DOCX' ? 'selected' : '' ?>>DOCX</option>
                        <option value="PPTX" <?= $material['type'] == 'PPTX' ? 'selected' : '' ?>>PPTX</option>
                        <option value="ZIP" <?= $material['type'] == 'ZIP' ? 'selected' : '' ?>>ZIP</option>
                        <option value="LINK" <?= $material['type'] == 'LINK' ? 'selected' : '' ?>>LINK</option>
                    </select>
                </div>

                <!-- File hiện tại -->
                <div class="mb-3">
                    <label class="form-label">Tệp hiện tại</label><br>
                    <a href="/uploads/<?= $material['file'] ?>" target="_blank">
                        <?= $material['file'] ?>
                    </a>
                </div>

                <!-- Tải file mới -->
                <div class="mb-3">
                    <label class="form-label">Tải file mới (tuỳ chọn)</label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.docx,.pptx,.zip">
                    <small class="text-muted">Chỉ tải nếu muốn thay file cũ</small>
                </div>

                <!-- Mô tả tài liệu -->
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"><?= $material['description'] ?></textarea>
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $material['status'] == 1 ? 'selected' : '' ?>>Hiển thị</option>
                        <option value="0" <?= $material['status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật tài liệu
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>