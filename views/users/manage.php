<?php require_once __DIR__ . '/../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';


?>


<!-- Main Content -->
<main class="main-content p-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white" style="margin-bottom: 20px;">
            <h4 class="mb-1">Danh sách tài khoản</h4>
        </div>
        <div class=" card-body p-0">
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
                        <th scope="col">Xóa</th>
                        <th scope="col">Sửa</th>
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
                        <td>
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning">Sửa</button>
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
                        <td>
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning">Sửa</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</main>


<?php require_once _PATH_URL . '/../views/layouts/footer.php'; ?>