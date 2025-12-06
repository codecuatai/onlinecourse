<?php
require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';

// Mảng danh sách người dùng
$users = [
    [
        "username" => "user1",
        "fullname" => "Nguyễn Văn A",
        "email" => "nguyenvana@example.com",
        "password" => "******",
        "created_at" => "2025-12-04",
        "role" => "Sinh Viên",
        "edit_link" => "./edit.php"
    ],
    [
        "username" => "teacher1",
        "fullname" => "Trần Thị B",
        "email" => "tranthib@example.com",
        "password" => "******",
        "created_at" => "2025-12-04",
        "role" => "Giảng Viên",
        "edit_link" => "./edit.php"
    ],
    // Thêm người dùng khác nếu cần
];
?>

<!-- Main Content -->
<main class="main-content p-4">

    <!-- Header + Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Danh sách tài khoản</h4>
        <a href="?views=users&action=create" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Tạo người dùng
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white mb-2">
            <h5 class="mb-0">Quản lý người dùng</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên tài khoản</th>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mật Khẩu</th>
                        <th scope="col">Tạo lúc</th>
                        <th scope="col">Role</th>
                        <th scope="col" class="text-center">Xóa</th>
                        <th scope="col" class="text-center">Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">
                                Chưa có tài khoản nào.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['fullname'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['password'] ?></td>
                                <td><?= $user['created_at'] ?></td>
                                <td><?= $user['role'] ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a href="?views=users&action=edit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php require_once _PATH_URL . '/../views/layouts/footer.php'; ?>