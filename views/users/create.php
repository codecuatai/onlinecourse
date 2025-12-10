<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Tạo người dùng mới</h4>

        <a href="?views=users&action=manage" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Thông tin tài khoản</h6>
        </div>

        <div class="card-body">

            <form method="POST" action="?controllers=AdminController&action=createUser">

                <!-- Username -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên tài khoản</label>
                    <input type="text" name="username" class="form-control" placeholder="Nhập tên tài khoản" required>
                </div>

                <!-- Full name -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Họ và tên</label>
                    <input type="text" name="fullname" class="form-control" placeholder="Nhập họ và tên" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Vai trò</label>
                    <select name="role" class="form-select" required>
                        <option value="0">Sinh viên</option>
                        <option value="1">Giảng viên</option>
                        <option value="2">Quản trị viên</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu người dùng
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>