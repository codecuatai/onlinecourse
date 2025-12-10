<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// $lessons được controller truyền vào
$lessons = $lessons ?? [];
$course_id = $course_id ?? 0;
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

                <!-- Chọn bài học -->
                <div class="mb-3">
                    <label class="form-label">Chọn bài học <span class="text-danger">*</span></label>
                    <select name="lesson_id" class="form-select" required>
                        <option value="">-- Chọn bài học --</option>
                        <?php foreach ($lessons as $lesson): ?>
                            <option value="<?= $lesson['id'] ?>"><?= htmlspecialchars($lesson['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Upload file -->
                <div class="mb-3">
                    <label class="form-label">Tải file lên <span class="text-danger">*</span></label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.docx,.pptx,.zip" required>
                    <small class="text-muted">Cho phép: PDF, DOCX, PPTX, ZIP</small>
                </div>

                <!-- Hidden course_id -->
                <input type="hidden" name="course_id" value="<?= $course_id ?>">

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