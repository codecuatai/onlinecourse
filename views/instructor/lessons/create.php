<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Tạo bài học mới - Python cho Người Mới</h4>

        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="?controllers=LessonController&action=createLesson" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?= $_GET['id'] ?>>">
                <!-- Tên bài học -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên bài học</label>
                    <input type="text" name="title" class="form-control" placeholder="Nhập tên bài học..." required>
                </div>

                <!-- Video -->
                <div class="mb-3">
                    <label class="form-label fw-bold">File Video (MP4)</label>
                    <input type="file" name="video" class="form-control" accept="video/mp4">
                    <small class="text-muted">Để trống nếu chưa có video.</small>
                </div>

                <!-- Tài liệu -->
                <div class="mb-3">
                    <label class="form-label fw-bold">File Tài liệu (PDF)</label>
                    <input type="file" name="document" class="form-control" accept="application/pdf">
                    <small class="text-muted">Để trống nếu chưa có tài liệu.</small>
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Nội dung mô tả bài học..."></textarea>
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <!-- Nút submit -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo"></i> Làm mới
                    </button>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu bài học
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>



<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
