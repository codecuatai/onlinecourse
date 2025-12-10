<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
$user = $_SESSION['user'];
// --- Giả sử dữ liệu lấy từ database ---
?>

<div class="container mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Chỉnh sửa người dùng</h4>

        <a href="?views=users&action=manage" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Thông tin tài khoản</h6>
        </div>

        <div class="card-body">

            <form method="POST" action="?controllers=AdminController&action=updateUser">

                <input type="hidden" name="id" value="<?= $user['id'] ?>">

                <!-- Username -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên tài khoản</label>
                    <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
                </div>

                <!-- Full name -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Họ và tên</label>
                    <input type="text" name="fullname" class="form-control" value="<?= $user['fullname'] ?>" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mật khẩu (nếu muốn đổi)</label>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới">
                    <small class="text-muted">Để trống nếu không thay đổi</small>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Vai trò</label>
                    <select name="role" class="form-select" required>
                        <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>Sinh viên</option>
                        <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Giảng viên</option>
                        <option value="2" <?= $user['role'] == 2 ? 'selected' : '' ?>>Quản trị viên</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="text-end">
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
?>