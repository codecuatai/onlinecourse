<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// $material, $lessons và $course_id được controller truyền vào
$material = $material ?? [];
$lessons = $lessons ?? [];
$course_id = $course_id ?? 0;
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

            <form action="?controllers=MaterialController&action=updateMaterial" method="POST" enctype="multipart/form-data">

                <!-- Chọn bài học -->
                <div class="mb-3">
                    <label class="form-label">Chọn bài học <span class="text-danger">*</span></label>
                    <select name="lesson_id" class="form-select" required>
                        <option value="">-- Chọn bài học --</option>
                        <?php foreach ($lessons as $lesson): ?>
                            <option value="<?= $lesson['id'] ?>" <?= ($material['lesson_id'] == $lesson['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($lesson['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tên tài liệu -->
                <div class="mb-3">
                    <label class="form-label">Tên tài liệu <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control"
                        value="<?= htmlspecialchars($material['filename']) ?>" required>
                </div>



                <!-- File hiện tại -->
                <div class="mb-3">
                    <label class="form-label">Tệp hiện tại</label><br>
                    <a href="<?= htmlspecialchars($material['file_path']) ?>" target="_blank">
                        <?= htmlspecialchars($material['filename']) ?>
                    </a>
                </div>

                <!-- Upload file mới -->
                <div class="mb-3">
                    <label class="form-label">Tải file mới (tuỳ chọn)</label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.docx,.pptx,.zip">
                    <small class="text-muted">Chỉ tải nếu muốn thay file cũ</small>
                </div>



                <!-- Hidden fields -->
                <input type="hidden" name="material_id" value="<?= $material['id'] ?>">
                <input type="hidden" name="course_id" value="<?= $course_id ?>">

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