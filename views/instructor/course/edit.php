<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
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
        <form action="#" method="POST" enctype="multipart/form-data">

            <div class="card-body">

                <!-- Tên khóa học -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên khóa học</label>
                    <input type="text" name="title" class="form-control"
                        value="Python cho người mới"
                        required>
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả khóa học</label>
                    <textarea name="description" class="form-control" rows="3" required>Khóa học này giúp bạn làm quen với Python từ cơ bản đến nâng cao.</textarea>
                </div>

                <!-- Thể loại + Level -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thể loại</label>
                        <select name="category" class="form-select" required>
                            <option value="">-- Chọn thể loại --</option>
                            <option value="programming" selected>Lập trình</option>
                            <option value="design">Thiết kế</option>
                            <option value="marketing">Marketing</option>
                            <option value="business">Kinh doanh</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Level</label>
                        <select name="level" class="form-select" required>
                            <option value="">-- Chọn level --</option>
                            <option value="beginner" selected>Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                </div>

                <!-- Giá -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Giá (VNĐ)</label>
                    <input type="number" name="price" class="form-control"
                        value="499000" min="0">
                </div>

                <!-- Ảnh cũ -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Ảnh đại diện hiện tại</label>
                    <br>
                    <img src="https://via.placeholder.com/200x120?text=Course+Image" class="img-thumbnail" width="200">
                </div>

                <!-- Upload ảnh mới -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Đổi ảnh đại diện (nếu muốn)</label>
                    <input type="file" name="thumbnail" class="form-control">
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
