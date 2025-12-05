<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mẫu dữ liệu user (thực tế sẽ lấy từ database)
$user = [
    "username" => "taivn",
    "fullname" => "Trần Văn Tài",
    "email" => "taivn@example.com",
    "phone" => "0123456789",
    "avatar" => "https://i.pravatar.cc/150?img=3",
    "role" => "Học viên"
];
?>

<main class="main-content p-4">
    <div class="container">
        <h4 class="mb-4">Trang cá nhân</h4>

        <div class="row">
            <!-- Avatar và thông tin cơ bản -->
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <img src="<?= $user['avatar'] ?>" class="rounded-circle mb-3" width="120" height="120" alt="Avatar">
                        <h5 class="card-title"><?= $user['fullname'] ?></h5>
                        <p class="text-muted"><?= $user['role'] ?></p>
                        <button class="btn btn-primary btn-sm">Đổi avatar</button>
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
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" value="<?= $user['fullname'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?= $user['email'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" value="<?= $user['phone'] ?>">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
?>