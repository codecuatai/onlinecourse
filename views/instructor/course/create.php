<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';


$categories = $_SESSION['categories'];
?>

<div class="container mt-5">

    <div class="card shadow-lg border-0">

        <!-- Header -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Tạo khóa học mới</h5>

            <!-- Button Back -->
            <a href="?views=instructor&instructor=course&action=manage" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>


        <form action="?controllers=CourseController&action=storeCoures" method="POST" enctype="multipart/form-data">


            <div class="card-body">

                <!-- Tên khóa học -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên khóa học</label>
                    <input type="text" name="title" class="form-control" placeholder="Ví dụ: Lập trình PHP cơ bản" required>
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả khóa học</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Nhập mô tả ngắn..." required></textarea>
                </div>

                <!-- Thể loại + Level -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thể loại</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Chọn thể loại --</option>

                            <?php foreach ($categories as $cate): ?>
                                <option value="<?= $cate['id'] ?>">
                                    <?= htmlspecialchars($cate['name']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Level</label>
                        <select name="level" class="form-select" required>
                            <option value="">-- Chọn level --</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                </div>

                <!-- Giá -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Giá (VNĐ)</label>
                    <input type="number" name="price" class="form-control" placeholder="VD: 499000" min="0">
                </div>

                <!-- Ảnh đại diện -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Ảnh đại diện</label>
                    <input type="file" name="image" class="form-control">
                </div>

            </div>

            <!-- Footer -->
            <div class="card-footer text-end">
                <button type="reset" class="btn btn-secondary me-2">Làm mới</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Tạo khóa học
                </button>
            </div>

        </form>
    </div>
</div>




<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
