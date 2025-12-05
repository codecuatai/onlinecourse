<?php require_once __DIR__ . '/../../../config/config.php';
require_once _PATH_URL . '/../views/layouts/header.php';
require_once _PATH_URL . '/../views/layouts/sidebar.php';
?>

<div class="container-fluid mt-4">
    <h4 class="mb-4">Quản lý tài liệu - Khóa học: Python cho Người Mới</h4>

    <!-- Nút tải tài liệu mới -->
    <div class="mb-3">
        <button class="btn btn-success">
            <i class="fas fa-plus"></i> Tải tài liệu mới
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Thứ tự</th>
                            <th>Tên tài liệu</th>
                            <th>Loại</th>
                            <th>Ngày tải lên</th>
                            <th>Link tải</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>1</td>
                            <td class="text-start">Bài học 1 - Giới thiệu Python</td>
                            <td>PDF</td>
                            <td>01/12/2025</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download"></i> Tải về
                                </a>
                            </td>
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

                        <tr class="text-center">
                            <td>2</td>
                            <td class="text-start">Bài học 2 - Biến và kiểu dữ liệu</td>
                            <td>DOCX</td>
                            <td>02/12/2025</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download"></i> Tải về
                                </a>
                            </td>
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

                        <!-- Khi chưa có tài liệu -->
                        <!--
                        <tr>
                            <td colspan="6" class="text-center text-muted">Chưa có tài liệu nào.</td>
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
