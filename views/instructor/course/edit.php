<?php
require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

$course = $_SESSION['edit_course'];
$categories = $_SESSION['edit_categories'];
?>

<div class="container mt-5">

    <div class="card shadow-lg border-0">

        <!-- Header -->
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-edit"></i> Sửa khóa học</h5>

            <!-- Button Back -->
            <a href="?views=instructor&instructor=course&action=manage" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <!-- Form -->
        <form action="?controllers=CourseController&action=updateCourse" method="POST" enctype="multipart/form-data">

            <!-- Hidden ID + old image -->
            <input type="hidden" name="id" value="<?= $course['id']; ?>">
            <input type="hidden" name="old_image" value="<?= $course['image']; ?>">

            <div class="card-body">
                <!-- Tên khóa học -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên khóa học</label>
                    <input type="text" name="title" class="form-control"
                        value="<?= htmlspecialchars($course['title']); ?>" required>
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả khóa học</label>
                    <input name="description" class="form-control" value="<?= htmlspecialchars($course['description']); ?>">
                </div>

                <!-- Thể loại + Level -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thể loại</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Chọn thể loại --</option>

                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id']; ?>"
                                    <?= ($c['id'] == $course['category_id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($c['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Level</label>
                        <select name="level" class="form-select" required>
                            <option value="">-- Chọn level --</option>

                            <option value="beginner" <?= ($course['level'] == 'beginner' ? 'selected' : '') ?>>Beginner</option>
                            <option value="intermediate" <?= ($course['level'] == 'intermediate' ? 'selected' : '') ?>>Intermediate</option>
                            <option value="advanced" <?= ($course['level'] == 'advanced' ? 'selected' : '') ?>>Advanced</option>

                        </select>
                    </div>
                </div>

                <!-- Giá -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Giá (VNĐ)</label>
                    <input type="number" name="price" class="form-control"
                        value="<?= $course['price']; ?>" min="0">
                </div>

                <!-- Ảnh cũ -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Ảnh đại diện hiện tại</label>
                    <br>

                    <?php if (!empty($course['image'])): ?>
                        <img src="/onlinecourse/<?= $course['image']; ?>" class="img-thumbnail" width="200">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/200x120?text=No+Image" class="img-thumbnail" width="200">
                    <?php endif; ?>
                </div>

                <!-- Upload ảnh mới -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Đổi ảnh đại diện (nếu muốn)</label>
                    <input type="file" name="image" class="form-control">
                </div>

            </div>

            <!-- Footer -->
            <div class="card-footer text-end">
                <button type="reset" class="btn btn-secondary me-2">Làm mới</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu thay đổi
                </button>
            </div>

        </form>
    </div>
</div>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>