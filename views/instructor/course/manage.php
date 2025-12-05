<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<div class="container-fluid mt-4">
    <h4 class="mb-4">Quản lý khóa học của giảng viên</h4>

    <!-- Nút tạo khóa học mới -->
    <div class="mb-3">
        <button class="btn btn-success">
            <i class="fas fa-plus"></i> Tạo khóa học mới
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Tên khóa học</th>
                            <th>Ngày tạo</th>
                            <th>Thể loại</th>
                            <th>Level</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Khóa học 1 -->
                        <tr class="text-center">
                            <th scope="row">1</th>
                            <td class="text-start">Python cho Người Mới</td>
                            <td>01/12/2025</td>
                            <td>Lập trình</td>
                            <td>Beginner</td>
                            <td>499.000₫</td>
                            <td><span class="badge bg-warning text-dark">Chờ duyệt</span></td>
                            <td>
                                <div class="d-flex justify-content-center flex-wrap gap-1">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <a href="../students/manage.php" class="btn btn-sm btn-info">
                                        <i class="fas fa-book"></i> Sinh viên
                                    </a>
                                    <a href="../lessons/manage.php" class="btn btn-sm btn-info">
                                        <i class="fas fa-book"></i> Bài học
                                    </a>

                                    <a href="../materials/manage.php" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-book"></i> Tài liệu
                                    </a>
                                </div>
                            </td>
                        </tr>


                        <!-- Khi không có khóa học -->
                        <!--
                        <tr>
                            <td colspan="8" class="text-center text-muted">Chưa có khóa học nào.</td>
                        </tr>
                        -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php
require_once _PATH_URL . '/../views/layouts/footer.php';
