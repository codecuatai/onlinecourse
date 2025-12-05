<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<div class="container-fluid mt-4">

    <!-- Header + nút quay lại -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Sửa thông tin sinh viên</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="update.php">

                <!-- hidden id -->
                <input type="hidden" name="id" value="1">

                <!-- Tên sinh viên -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên sinh viên</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="Nguyễn Văn A"
                        required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="nguyenvana@example.com"
                        required>
                </div>

                <!-- Ngày đăng ký -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Ngày đăng ký</label>
                    <input
                        type="date"
                        name="created_at"
                        class="form-control"
                        value="2025-12-01"
                        required>
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="active" selected>Active</option>
                        <option value="dropped">Dropped</option>
                        <option value="paused">Paused</option>
                    </select>
                </div>

                <!-- Tiến độ -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tiến độ (%)</label>
                    <input
                        type="number"
                        name="progress"
                        class="form-control"
                        min="0"
                        max="100"
                        value="75"
                        required>
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-warning text-white">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>

                    <a href="./manage.php" class="btn btn-danger">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
