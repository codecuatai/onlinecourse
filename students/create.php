<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Thêm sinh viên mới</h4>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form>

                <!-- Tên sinh viên -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên sinh viên</label>
                    <input type="text" class="form-control" placeholder="Nhập tên sinh viên" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" placeholder="Nhập email" required>
                </div>

                <!-- Ngày đăng ký -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Ngày đăng ký</label>
                    <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select class="form-select">
                        <option value="active">Active</option>
                        <option value="dropped">Dropped</option>
                        <option value="paused">Paused</option>
                    </select>
                </div>

                <!-- Tiến độ -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tiến độ (%)</label>
                    <input type="number" class="form-control" min="0" max="100" value="0" required>
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu
                    </button>

                    <a href="?views=instructor&instructor=students&action=manage" class="btn btn-danger">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>


<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
