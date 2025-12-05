<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Danh sách sinh viên - Khóa học: Python cho Người Mới</h4>

        <!-- Nút quay lại -->
        <a href="../course/manage.php" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Nút thêm sinh viên mới -->
    <div class="mb-3">
        <a href="./create.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm sinh viên mới
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Thứ tự</th>
                            <th>Tên sinh viên</th>
                            <th>Email</th>
                            <th>Ngày đăng ký</th>
                            <th>Trạng thái</th>
                            <th>Tiến độ (%)</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="text-center">
                            <td>1</td>
                            <td class="text-start">Nguyễn Văn A</td>
                            <td>nguyenvana@example.com</td>
                            <td>01/12/2025</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td>75%</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="./edit.php" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="text-center">
                            <td>2</td>
                            <td class="text-start">Trần Thị B</td>
                            <td>tranthib@example.com</td>
                            <td>02/12/2025</td>
                            <td>
                                <span class="badge bg-warning text-dark">Dropped</span>
                            </td>
                            <td>40%</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
