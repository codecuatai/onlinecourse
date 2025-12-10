<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<?php
// Dữ liệu bài học đã được controller truyền qua $_SESSION['lesson']
$lesson = $_SESSION['lesson'];
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Sửa bài học - <?= htmlspecialchars($lesson['title']) ?></h4>
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="?controllers=LessonController&action=updateLesson" method="POST" enctype="multipart/form-data">

                <!-- Input ẩn để gửi id và course_id -->
                <input type="hidden" name="id" value="<?= $lesson['id'] ?>">
                <input type="hidden" name="course_id" value="<?= $lesson['course_id'] ?>">

                <!-- Tên bài học -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên bài học</label>
                    <input type="text" name="title" class="form-control"
                        value="<?= htmlspecialchars($lesson['title']) ?>" required>
                </div>

                <!-- Video -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Link Video</label>
                    <input type="text" name="video_url" class="form-control" placeholder="Link video">

                    <?php if (!empty($lesson['video_url'])): ?>
                        <div class="mt-2">
                            <a href="<?= htmlspecialchars($lesson['video_url']) ?>" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-video"></i> Xem video hiện tại
                            </a>
                        </div>
                    <?php endif; ?>

                    <small class="text-muted d-block mt-1">Để trống nếu không thay đổi.</small>
                </div>


                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($lesson['content']) ?></textarea>
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

<?php require_once _PATH_URL . '/../views/layouts/footer.php'; ?>