<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mẫu dữ liệu user (thực tế sẽ lấy từ database)
$user = $_SESSION;
print_r($user);
?>

<main class="main-content p-4">
    <div class="container">
        <h4 class="mb-4">Trang cá nhân</h4>
        <div class="d-flex justify-content-end mb-2">
            <a href="javascript:history.back()" class="btn btn-secondary btn-sm">
                ← Quay lại
            </a>
        </div>
        <form method="post" action="?controllers=UserController&action=updateProfile" enctype="multipart/form-data">
            <div class="row">
                <!-- Avatar và thông tin cơ bản -->
                <div class="col-md-4">
                    <div class="card shadow-sm text-center">
                        <div class="card-body">
                            <img src="<?= $user['avatar'] ?>" class="rounded-circle mb-3" width="120" height="120" alt="Avatar">
                            <h5 class="card-title"><?= $user['fullname'] ?></h5>
                            <p class="text-muted">
                                <?php if ($user['role'] == 0) {
                                    echo "Học Viên";
                                } elseif ($user['role'] == 1) {
                                    echo "Giảng Viên";
                                } else {
                                    echo "Quản trị viên";
                                } ?></p>
                            <label class="btn btn-primary btn-sm mb-2">
                                Đổi avatar
                                <input type="file" name="avatar" accept="image/*">
                            </label>

                        </div>
                    </div>
                </div>

                <!-- Thông tin chi tiết -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Thông tin cá nhân</h5>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Tên đăng nhập</label>
                                <input name="username" type="text" class="form-control" value="<?= $user['username'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input name="fullname" type="text" class="form-control" value="<?= $user['fullname'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" value="<?= $user['email'] ?>">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">Lưu thay đổi</button>

                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</main>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>