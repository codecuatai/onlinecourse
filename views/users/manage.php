<?php require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>


<!-- Main Content -->
<main class="main-content p-4">

    <!-- Header + Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Danh sách tài khoản</h4>

        <a href="create.php" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Tạo người dùng
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white" style="margin-bottom:20px;">
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
                    <tr>
                        <th scope="row">1</th>
                        <td>Tên tài khoản</td>
                        <td>Họ và tên</td>
                        <td>email@example.com</td>
                        <td>******</td>
                        <td>2025-12-04</td>
                        <td>Sinh Viên</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash">Xóa</i>
                            </button>
                        </td>
                        <td class="text-center">
                            <a href="./edit.php" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit">Sửa</i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">2</th>
                        <td>Tên tài khoản</td>
                        <td>Họ và tên</td>
                        <td>email@example.com</td>
                        <td>******</td>
                        <td>2025-12-04</td>
                        <td>Giảng Viên</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash">Xóa</i>
                            </button>
                        </td>
                        <td class="text-center">
                            <a href="./edit.php" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit">Sửa</i>
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</main>



<?php require_once _PATH_URL . '/../views/layouts/footer.php'; ?>