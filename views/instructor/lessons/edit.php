<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<?php
// Giả lập dữ liệu bài học (sau này thay bằng truy vấn DB)
$lesson = [
    "title" => "Giới thiệu Python",
    "description" => "Bài học giới thiệu tổng quan về Python",
    "status" => 1,
    "video" => "video1.mp4",
    "document" => "doc1.pdf",
];
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Sửa bài học - Python cho Người Mới</h4>

        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="update.php" method="POST" enctype="multipart/form-data">

                <!-- Tên bài học -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên bài học</label>
                    <input type="text" name="title" class="form-control"
                        value="<?= $lesson['title'] ?>" required>
                </div>

                <!-- Video -->
                <div class="mb-3">
                    <label class="form-label fw-bold">File Video (MP4)</label>
                    <input type="file" name="video" class="form-control" accept="video/mp4">

                    <?php if (!empty($lesson['video'])): ?>
                        <div class="mt-2">
                            <a href="<?= $lesson['video'] ?>" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-video"></i> Xem video hiện tại
                            </a>
                        </div>
                    <?php endif; ?>

                    <small class="text-muted d-block mt-1">Để trống nếu không thay đổi.</small>
                </div>

                <!-- Tài liệu -->
                <div class="mb-3">
                    <label class="form-label fw-bold">File Tài liệu (PDF)</label>
                    <input type="file" name="document" class="form-control" accept="application/pdf">

                    <?php if (!empty($lesson['document'])): ?>
                        <div class="mt-2">
                            <a href="<?= $lesson['document'] ?>" target="_blank" class="btn btn-sm btn-secondary">
                                <i class="fas fa-file-pdf"></i> Xem tài liệu hiện tại
                            </a>
                        </div>
                    <?php endif; ?>

                    <small class="text-muted d-block mt-1">Để trống nếu không thay đổi.</small>
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea name="description" class="form-control" rows="4"><?= $lesson['description'] ?></textarea>
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $lesson['status'] == 1 ? "selected" : "" ?>>Hiển thị</option>
                        <option value="0" <?= $lesson['status'] == 0 ? "selected" : "" ?>>Ẩn</option>
                    </select>
                </div>

                <!-- Nút submit -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo"></i> Làm mới
                    </button>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>




<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
